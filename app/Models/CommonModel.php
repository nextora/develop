<?php namespace App\Models;

class CommonModel extends BaseModel
{
    protected $builderSlider;
    protected $builderBanners;
    protected $builderAbuseReports;
    protected $builderReviews;
    protected $builderComments;
    protected $builderContact;
    protected $builderAds;
    protected $builderBrands;
    protected $builderAffiliateLinks;
    protected $builderBankTransfers;

    public function __construct()
    {
        parent::__construct();
        $this->builderSlider = $this->db->table('slider');
        $this->builderBanners = $this->db->table('homepage_banners');
        $this->builderAbuseReports = $this->db->table('abuse_reports');
        $this->builderReviews = $this->db->table('reviews');
        $this->builderComments = $this->db->table('comments');
        $this->builderContact = $this->db->table('contacts');
        $this->builderAds = $this->db->table('ad_spaces');
        $this->builderBrands = $this->db->table('brands');
        $this->builderAffiliateLinks = $this->db->table('affiliate_links');
        $this->builderBankTransfers = $this->db->table('bank_transfers');
    }

    //main search)
    public function mainAjaxSearch($search, $langId)
    {
        $array = array();
        if (!empty($search)) {
            $escSearchTerm = removeSpecialCharacters($search);
            //search tags
            $resultTags = $this->db->table('product_tags')->select('DISTINCT tag', false)->where('lang_id', clrNum($langId))->like('tag', $escSearchTerm, 'after')->get(30)->getResult();
            if (!empty($resultTags)) {
                foreach ($resultTags as $item) {
                    $url = generateUrl('products') . "?search=" . $item->tag;
                    array_push($array, ['title' => $item->tag, 'data_type' => 'tag', 'url' => $url, 'img' => '']);
                }
            }
            //search categories
            $resultCategories = $this->db->table('categories')->select('categories.*, categories.parent_id AS join_parent_id, categories_lang.name, (SELECT slug FROM categories WHERE id = join_parent_id) AS parent_slug')
                ->join('categories_lang', 'categories_lang.category_id = categories.id')
                ->where('categories_lang.lang_id', clrNum($langId))->like('categories_lang.name', cleanStr($search))->get()->getResult();
            if (!empty($resultCategories)) {
                foreach ($resultCategories as $item) {
                    $url = generateCategoryUrl($item);
                    array_push($array, ['title' => $item->name, 'data_type' => 'category', 'url' => $url, 'img' => '']);
                }
            }
            //search brands
            $qSerialized = 'i:' . clrNum($langId) . ';s:' . strlen(cleanStr($search)) . ':"' . clrDoubleQuotes(cleanStr($search)) . '"';
            $resultbrands = $this->db->table('brands')->like('name_data', $qSerialized)->get()->getResult();
            if (!empty($resultbrands)) {
                foreach ($resultbrands as $item) {
                    $url = generateUrl('products') . "?brand=" . $item->id;
                    array_push($array, ['title' => getBrandName($item->name_data, $langId), 'data_type' => 'brand', 'url' => $url, 'img' => base_url($item->image_path)]);
                }
            }
            //search shops
            $resultShops = $this->db->table('users')->select('users.*, (SELECT COUNT(products.id) FROM products WHERE products.user_id = users.id) AS product_count')->like('username', cleanStr($search))->get()->getResult();
            if (!empty($resultShops)) {
                foreach ($resultShops as $item) {
                    if ($item->product_count > 0) {
                        $url = generateProfileUrl($item->slug);
                        array_push($array, ['title' => $item->username, 'data_type' => 'shop', 'url' => $url, 'img' => getUserAvatar($item)]);
                    }
                }
            }
        }
        return $array;
    }

    /*
     * --------------------------------------------------------------------
     * Slider
     * --------------------------------------------------------------------
     */

    //add item
    public function addSliderItem()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'title' => inputPost('title'),
            'description' => inputPost('description'),
            'link' => inputPost('link'),
            'item_order' => inputPost('item_order'),
            'button_text' => inputPost('button_text'),
            'text_color' => inputPost('text_color'),
            'button_color' => inputPost('button_color'),
            'button_text_color' => inputPost('button_text_color'),
            'animation_title' => inputPost('animation_title'),
            'animation_description' => inputPost('animation_description'),
            'animation_button' => inputPost('animation_button')
        ];
        $uploadModel = new UploadModel();
        $tempFile = $uploadModel->uploadTempFile('file');
        if (!empty($tempFile) && !empty($tempFile['path'])) {
            $data['image'] = $uploadModel->uploadSliderImage($tempFile['path'], false);
            $uploadModel->deleteTempFile($tempFile['path']);
        }
        $tempFileMobile = $uploadModel->uploadTempFile('file_mobile');
        if (!empty($tempFileMobile) && !empty($tempFileMobile['path'])) {
            $data['image_mobile'] = $uploadModel->uploadSliderImage($tempFileMobile['path'], true);
            $uploadModel->deleteTempFile($tempFileMobile['path']);
        }
        return $this->builderSlider->insert($data);
    }

    //edit slider item
    public function editSliderItem($id)
    {
        $item = $this->getSliderItem($id);
        if (!empty($item)) {
            $data = [
                'lang_id' => inputPost('lang_id'),
                'title' => inputPost('title'),
                'description' => inputPost('description'),
                'link' => inputPost('link'),
                'item_order' => inputPost('item_order'),
                'button_text' => inputPost('button_text'),
                'text_color' => inputPost('text_color'),
                'button_color' => inputPost('button_color'),
                'button_text_color' => inputPost('button_text_color'),
                'animation_title' => inputPost('animation_title'),
                'animation_description' => inputPost('animation_description'),
                'animation_button' => inputPost('animation_button')
            ];
            $uploadModel = new UploadModel();
            $tempFile = $uploadModel->uploadTempFile('file');
            if (!empty($tempFile) && !empty($tempFile['path'])) {
                deleteFile($item->image);
                $data['image'] = $uploadModel->uploadSliderImage($tempFile['path'], false);
                $uploadModel->deleteTempFile($tempFile['path']);
            }
            $tempFileMobile = $uploadModel->uploadTempFile('file_mobile');
            if (!empty($tempFileMobile) && !empty($tempFileMobile['path'])) {
                deleteFile($item->image_mobile);
                $data['image_mobile'] = $uploadModel->uploadSliderImage($tempFileMobile['path'], true);
                $uploadModel->deleteTempFile($tempFileMobile['path']);
            }
            error_reporting(0);
            $this->db->reconnect();
            return $this->builderSlider->where('id', $item->id)->update($data);
        }
        return false;
    }

    //get slider item
    public function getSliderItem($id)
    {
        return $this->builderSlider->where('id', clrNum($id))->get()->getRow();
    }

    //get slider items
    public function getSliderItems()
    {
        return $this->builderSlider->orderBy('item_order')->get()->getResult();
    }

    //get slider items by languages
    public function getSliderItemsByLang($langId)
    {
        $key = 'slider_' . $langId;
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        $rows = $this->builderSlider->where('lang_id', clrNum($langId))->orderBy('item_order')->get()->getResult();
        setCacheStatic($key, $rows);
        return $rows;
    }

    //edit slider settings
    public function editSliderSettings()
    {
        $data = [
            'slider_status' => inputPost('slider_status'),
            'slider_type' => inputPost('slider_type'),
            'slider_effect' => inputPost('slider_effect')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //delete slider item
    public function deleteSliderItem($id)
    {
        $item = $this->getSliderItem($id);
        if (!empty($item)) {
            deleteFile($item->image);
            deleteFile($item->image_mobile);
            return $this->builderSlider->where('id', $item->id)->delete();
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * Index Banners
     * --------------------------------------------------------------------
     */

    //add index banner
    public function addIndexBanner()
    {
        $data = [
            'banner_url' => addHTTPS(inputPost('banner_url')),
            'banner_order' => inputPost('banner_order'),
            'banner_width' => inputPost('banner_width'),
            'banner_location' => inputPost('banner_location'),
            'lang_id' => inputPost('lang_id')
        ];
        if ($data['banner_width'] > 100) {
            $data['banner_width'] = 100;
        }
        $uploadModel = new UploadModel();
        $file = $uploadModel->uploadAd('file');
        if (!empty($file) && !empty($file['path'])) {
            $data['banner_image_path'] = $file['path'];
        }
        return $this->builderBanners->insert($data);
    }

    //edit index banner
    public function editIndexBanner($id)
    {
        $banner = $this->getIndexBanner($id);
        if (!empty($banner)) {
            $data = [
                'banner_url' => addHTTPS(inputPost('banner_url')),
                'banner_order' => inputPost('banner_order'),
                'banner_width' => inputPost('banner_width'),
                'banner_location' => inputPost('banner_location'),
                'lang_id' => inputPost('lang_id')
            ];
            if ($data['banner_width'] > 100) {
                $data['banner_width'] = 100;
            }
            $uploadModel = new UploadModel();
            $file = $uploadModel->uploadAd('file');
            if (!empty($file) && !empty($file['path'])) {
                $data['banner_image_path'] = $file['path'];
                deleteFile($banner->banner_image_path);
            }
            return $this->builderBanners->where('id', $banner->id)->update($data);
        }
        return false;
    }

    //get index banner
    public function getIndexBanner($id)
    {
        return $this->builderBanners->where('id', clrNum($id))->get()->getRow();
    }

    //get index banners
    public function getIndexBanners()
    {
        return $this->builderBanners->orderBy('banner_order')->get()->getResult();
    }

    //get index banners array
    public function getIndexBannersArray()
    {
        $langId = selectedLangId();
        $key = 'index_banners_' . $langId;
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        $banners = $this->getIndexBanners();
        $array = array();
        if (!empty($banners)) {
            foreach ($banners as $banner) {
                if ($banner->lang_id == $langId) {
                    @$array[$banner->banner_location][] = $banner;
                }
            }
        }
        setCacheStatic($key, $array);
        return $array;
    }

    //delete index banner
    public function deleteIndexBanner($id)
    {
        $banner = $this->getIndexBanner($id);
        if (!empty($banner)) {
            deleteFile($banner->banner_image_path);
            return $this->builderBanners->where('id', $banner->id)->delete();
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * Abuse Reports
     * --------------------------------------------------------------------
     */

    //report abuse
    public function reportAbuse()
    {
        $data = [
            'item_type' => inputPost('item_type'),
            'item_id' => inputPost('id'),
            'report_user_id' => user()->id,
            'description' => inputPost('description'),
            'created_at' => date("Y-m-d H:i:s")
        ];
        if (empty($data['item_id'])) {
            $data['item_id'] = 0;
        }
        return $this->builderAbuseReports->insert($data);
    }

    //get abuse reports count
    public function getAbuseReportsCount()
    {
        return $this->builderAbuseReports->countAllResults();
    }

    //get paginated abuse reports
    public function getAbuseReportsPaginated($perPage, $offset)
    {
        return $this->builderAbuseReports->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //delete abuse report
    public function deleteAbuseReport($id)
    {
        return $this->builderAbuseReports->where('id', clrNum($id))->delete();
    }

    /*
     * --------------------------------------------------------------------
     * Ad Spaces
     * --------------------------------------------------------------------
     */

    public function updateAdSpaces($id)
    {
        $adSpace = $this->getAdSpaceById($id);
        if (!empty($adSpace)) {
            $uploadModel = new UploadModel();
            $data = [
                'ad_code_desktop' => inputPost('ad_code_desktop'),
                'ad_code_mobile' => inputPost('ad_code_mobile'),
                'desktop_width' => inputPost('desktop_width'),
                'desktop_height' => inputPost('desktop_height'),
                'mobile_width' => inputPost('mobile_width'),
                'mobile_height' => inputPost('mobile_height')
            ];
            $adURL = inputPost('url_ad_code_desktop');
            $file = $uploadModel->uploadAd('file_ad_code_desktop');
            if (!empty($file) && !empty($file['path'])) {
                $data['ad_code_desktop'] = $this->createAdCode($adURL, $file['path'], $data['desktop_width'], $data['desktop_height']);
            }
            $adURL = inputPost('url_ad_code_mobile');
            $file = $uploadModel->uploadAd('file_ad_code_mobile');
            if (!empty($file) && !empty($file['path'])) {
                $data['ad_code_mobile'] = $this->createAdCode($adURL, $file['path'], $data['mobile_width'], $data['mobile_height']);
            }
            return $this->builderAds->where('id', $adSpace->id)->update($data);
        }
        return false;
    }

    //get ad spaces
    public function getAdSpaces()
    {
        $key = 'ad_spaces';
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        $rows = $this->builderAds->get()->getResult();
        setCacheStatic($key, $rows);
        return $rows;
    }

    //get ad spaces by lang
    public function getAdSpacesByLang($langId)
    {
        return $this->builderAds->where('lang_id', clrNum($langId))->get()->getResult();
    }

    //get ad spaces by id
    public function getAdSpaceById($id)
    {
        return $this->builderAds->where('id', clrNum($id))->get()->getRow();
    }

    //get ad space
    public function getAdSpace($adSpace, $adSpaceArray)
    {
        $row = $this->builderAds->where('ad_space', cleanStr($adSpace))->get()->getRow();
        if (!empty($row)) {
            return $row;
        }
        $addNew = false;
        foreach ($adSpaceArray as $key => $value) {
            if ($key == strSlug($adSpace)) {
                $addNew = true;
            }
        }
        if ($addNew) {
            $data = [
                'ad_space' => strSlug($adSpace),
                'ad_code_desktop' => '',
                'desktop_width' => 728,
                'desktop_height' => 90,
                'ad_code_mobile' => '',
                'mobile_width' => 300,
                'mobile_height' => 250,
                'mobile_width' => 300,
            ];
            if ($adSpace == 'sidebar_1' || $adSpace == 'sidebar_2') {
                $data['desktop_width'] = 336;
                $data['desktop_height'] = 280;
            }
            $this->builderAds->insert($data);
            return $this->builderAds->where('ad_space', cleanStr($adSpace))->get()->getRow();
        }
        return false;
    }

    //create ad code
    public function createAdCode($url, $imgPath, $width, $height)
    {
        return '<a href="' . $url . '" aria-label="link-bn' . '"><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . base_url($imgPath) . '" width="' . $width . '" height="' . $height . '" alt="" class="lazyload"></a>';
    }

    //update google adsense code
    public function updateGoogleAdsenseCode()
    {
        return $this->db->table('general_settings')->where('id', 1)->update(['google_adsense_code' => inputPost('google_adsense_code')]);
    }

    /*
     * --------------------------------------------------------------------
     * Reviews
     * --------------------------------------------------------------------
     */

    //add review
    public function addReview($rating, $productId, $reviewText)
    {
        $data = [
            'product_id' => $productId,
            'user_id' => user()->id,
            'rating' => $rating,
            'review' => !empty($reviewText) ? $reviewText : '',
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (strlen($data['review']) > REVIEW_CHARACTER_LIMIT) {
            $data['review'] = substr($data['review'], 0, REVIEW_CHARACTER_LIMIT);
        }
        if (!empty($data['product_id']) && !empty($data['user_id']) && !empty($data['rating'])) {
            $this->builderReviews->insert($data);
            $this->updateProductRating($productId);
        }
    }

    //update review
    public function updateReview($review_id, $rating, $productId, $reviewText)
    {
        $data = [
            'rating' => $rating,
            'review' => $reviewText,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['rating']) && !empty($data['review'])) {
            $this->builderReviews->where('product_id', clrNum($productId))->where('user_id', user()->id)->update($data);
            $this->updateProductRating($productId);
        }
    }

    //get reviews count
    public function getReviewsCount()
    {
        $this->filterReviews();
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')
            ->select('reviews.*, users.username as user_username, users.slug as user_slug')->countAllResults();
    }

    //get paginated reviews
    public function getReviewsPaginated($perPage, $offset)
    {
        $this->filterReviews();
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')
            ->select('reviews.*, users.username as user_username, users.slug as user_slug')->orderBy('reviews.created_at DESC')
            ->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter reviews
    public function filterReviews()
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builderReviews->like('review', cleanStr($q))->orLike('users.username', cleanStr($q));
        }
    }

    //get reviews count
    public function getReviewsCountByProductId($productId)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->where('reviews.product_id', clrNum($productId))->countAllResults();
    }

    //get reviews
    public function getReviewsByProductId($productId)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->select('reviews.*, users.username as user_username, users.slug as user_slug')
            ->where('reviews.product_id', clrNum($productId))->orderBy('reviews.created_at DESC')->get()->getResult();
    }

    //get latest reviews
    public function getLatestReviews($limit)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->select('reviews.*, users.username as user_username')
            ->orderBy('reviews.id DESC')->get(clrNum($limit))->getResult();
    }

    //get review
    public function getReview($productId, $userId)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->select('reviews.*, users.username as user_username, users.slug as user_slug')
            ->where('reviews.product_id', $productId)->where('users.id', $userId)->get()->getRow();
    }

    //get review by id
    public function getReviewById($id)
    {
        return $this->builderReviews->where('id', clrNum($id))->get()->getRow();
    }

    //update product rating
    public function updateProductRating($productId)
    {
        $reviews = $this->getReviewsByProductId($productId);
        $data = array();
        if (!empty($reviews)) {
            $count = countItems($reviews);
            $total = 0;
            foreach ($reviews as $review) {
                $total += $review->rating;
            }
            $data['rating'] = round($total / $count);
        } else {
            $data['rating'] = 0;
        }
        $this->db->table('products')->where('id', clrNum($productId))->update($data);
    }

    //get vendor reviews count
    public function getVendorReviewsCount($userId)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')
            ->select('reviews.*, users.username as user_username, users.slug as user_slug')->where('products.user_id', clrNum($userId))->countAllResults();
    }

    //get paginated vendor reviews
    public function getVendorReviewsPaginated($userId, $perPage, $offset)
    {
        $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')->select('reviews.*, users.username AS user_username, users.slug AS user_slug, products.slug AS product_slug,
        (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = ' . clrNum(selectedLangId()) . ' LIMIT 1) AS title')
            ->where('products.user_id', clrNum($userId));
        if (countItems($this->activeLanguages) > 1) {
            $this->builderReviews->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clrNum(selectedLangId()) . " LIMIT 1) AS second_title");
        }
        return $this->builderReviews->orderBy('reviews.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get my reviews count
    public function getMyReviewsCount($userId)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')
            ->select('reviews.*, users.username as user_username, users.slug as user_slug')->where('reviews.user_id', clrNum($userId))->countAllResults();
    }

    //get paginated my reviews
    public function getMyReviewsPaginated($userId, $perPage, $offset)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')->select('reviews.*, users.username AS user_username, users.slug AS user_slug')
            ->where('reviews.user_id', clrNum($userId))->orderBy('reviews.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get reviews load more
    public function getProductReviewsByOffset($productId, $perPage, $offset)
    {
        return $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')->select('reviews.*, users.username AS user_username, users.slug AS user_slug, users.avatar AS user_avatar, users.user_type AS user_type')
            ->where('products.id', clrNum($productId))->orderBy('reviews.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //calculate user rating
    public function calculateUserRating($userId)
    {
        $std = new \stdClass();
        $std->count = 0;
        $std->rating = 0;
        $row = $this->builderReviews->join('users', 'users.id = reviews.user_id')->join('products', 'products.id = reviews.product_id')->select('COUNT(reviews.id) AS count, SUM(reviews.rating) AS total')
            ->where('products.user_id', clrNum($userId))->get()->getRow();
        if (!empty($row)) {
            $total = $row->total;
            $count = $row->count;
            if (!empty($total) && !empty($count)) {
                $avg = round($total / $count);
                $std->count = $count;
                $std->rating = $avg;
            }
        }
        return $std;
    }

    //delete review
    public function deleteReview($id, $productId = null)
    {
        $review = $this->getReviewById($id);
        if (!empty($review)) {
            if ($this->builderReviews->where('id', $review->id)->delete()) {
                $this->updateProductRating($review->product_id);
                return true;
            }
        }
        return false;
    }

    //delete multi reviews
    public function deleteSelectedReviews($reviewIds)
    {
        if (!empty($reviewIds)) {
            foreach ($reviewIds as $id) {
                $this->deleteReview($id);
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * Comments
     * --------------------------------------------------------------------
     */

    //add comment
    public function addComment()
    {
        $data = [
            'parent_id' => inputPost('parent_id'),
            'product_id' => inputPost('product_id'),
            'user_id' => 0,
            'name' => inputPost('name'),
            'email' => inputPost('email'),
            'comment' => inputPost('comment'),
            'status' => 1,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        ];
        if ($this->generalSettings->comment_approval_system == 1 && !hasPermission('comments')) {
            $data['status'] = 0;
        }
        if (empty($data['parent_id'])) {
            $data['parent_id'] = 0;
        }
        if (authCheck()) {
            $data['user_id'] = user()->id;
            $data['name'] = getUsername(user());
            $data['email'] = user()->email;
            if (hasPermission('comments')) {
                $data['status'] = 1;
            }
        } else {
            if (empty($data['name']) || empty($data['email'])) {
                return false;
            }
        }
        if (empty($data['name'])) {
            $data['name'] = '';
        }
        if (empty($data['email'])) {
            $data['email'] = '';
        }
        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        $data['parent_id'] = clrNum($data['parent_id']);
        $data['product_id'] = clrNum($data['product_id']);

        //check limits
        if (strlen($data['name']) > 255) {
            $data['name'] = substr($data['name'], 0, 255);
        }
        if (strlen($data['email']) > 255) {
            $data['email'] = substr($data['email'], 0, 255);
        }
        if (strlen($data['comment']) > COMMENT_CHARACTER_LIMIT) {
            $data['comment'] = substr($data['comment'], 0, COMMENT_CHARACTER_LIMIT);
        }
        if (!empty($data['product_id']) && !empty($data['comment'])) {
            $this->builderComments->insert($data);
        }
    }

    //get comment count
    public function getCommentCount($status)
    {
        return $this->builderComments->where('status', clrNum($status))->countAllResults();
    }

    //get paginated comments
    public function getCommentsPaginated($status, $perPage, $offset)
    {
        return $this->builderComments->where('status', clrNum($status))->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //latest comments
    public function getLatestComments($limit)
    {
        return $this->builderComments->orderBy('id DESC')->get(clrNum($limit))->getResult();
    }

    //comments
    public function getProductCommentsByOffset($productId, $perPage, $offset)
    {
        $arrayComments = array();
        $parentIds = array();
        $parentResult = $this->builderComments->join('users', 'comments.user_id = users.id', 'left')
            ->select('comments.*, users.username AS user_username, users.slug AS user_slug, users.avatar AS user_avatar, users.user_type AS user_type')
            ->where('product_id', clrNum($productId))->where('parent_id', 0)->orderBy('id DESC')->limit($perPage, $offset)->get()->getResult();
        if (!empty($parentResult)) {
            foreach ($parentResult as $result) {
                $arrayComments[0][] = $result;
                array_push($parentIds, $result->id);
            }
        }
        if (!empty($parentIds) && countItems($parentIds) > 0) {
            $subResult = $this->builderComments->join('users', 'comments.user_id = users.id', 'left')
                ->select('comments.*, users.username AS user_username, users.slug AS user_slug, users.avatar AS user_avatar, users.user_type AS user_type')
                ->where('product_id', clrNum($productId))->whereIn('parent_id', $parentIds, FALSE)->orderBy('id DESC')->get()->getResult();
            if (!empty($subResult)) {
                foreach ($subResult as $result) {
                    $arrayComments[$result->parent_id][] = $result;
                }
            }
        }
        return $arrayComments;
    }

    //comment
    public function getComment($id)
    {
        return $this->builderComments->where('id', clrNum($id))->get()->getRow();
    }

    //product comment count
    public function getProductCommentCount($productId)
    {
        return $this->builderComments->where('product_id', clrNum($productId))->where('parent_id', 0)->where('status', 1)->countAllResults();
    }

    //get vendor comments count
    public function getVendorCommentsCount($userId)
    {
        return $this->builderComments->join('products', 'comments.product_id = products.id')->where('products.user_id', clrNum($userId))->where('products.status', 1)
            ->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->countAllResults();
    }

    //get paginated vendor comments
    public function getVendorCommentsPaginated($userId, $perPage, $offset)
    {
        $this->builderComments->join('products', 'comments.product_id = products.id')->select('comments.*, products.slug AS product_slug, 
        (SELECT users.slug FROM users WHERE comments.user_id = users.id LIMIT 1) AS user_slug, 
        (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = ' . clrNum(selectedLangId()) . ' LIMIT 1) AS title')
            ->where('products.user_id', clrNum($userId))->where('products.status', 1)->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        if (countItems($this->activeLanguages) > 1) {
            $this->builderComments->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clrNum(selectedLangId()) . " LIMIT 1) AS second_title");
        }
        return $this->builderComments->orderBy('comments.id DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //approve comment
    public function approveComment($id)
    {
        $comment = $this->getComment($id);
        if (!empty($comment)) {
            return $this->builderComments->where('id', $comment->id)->update(['status' => 1]);
        }
        return false;
    }

    //approve multi comments
    public function approveMultiComments($commentIds)
    {
        if (!empty($commentIds)) {
            foreach ($commentIds as $id) {
                $this->approveComment($id);
            }
        }
    }

    //delete comment
    public function deleteComment($id)
    {
        $comment = $this->getComment($id);
        if (!empty($comment)) {
            $this->builderComments->where('parent_id', $comment->id)->delete();
            return $this->builderComments->where('id', $comment->id)->delete();
        }
        return false;
    }

    //delete multi comments
    public function deleteMultiComments($commentIds)
    {
        if (!empty($commentIds)) {
            foreach ($commentIds as $id) {
                $this->deleteComment($id);
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * Contact Messages
     * --------------------------------------------------------------------
     */

    //add contact message
    public function addContactMessage()
    {
        $data = [
            'name' => inputPost('name'),
            'email' => inputPost('email'),
            'message' => inputPost('message'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        //send email
        if (getEmailOptionStatus($this->generalSettings, 'contact_messages') == 1) {
            $emailData = [
                'email_type' => 'contact',
                'email_address' => $this->generalSettings->mail_options_account,
                'email_data' => serialize(['messageName' => $data['name'], 'messageEmail' => $data['email'], 'messageText' => $data['message']]),
                'email_subject' => trans("contact_message"),
                'template_path' => 'email/contact_message'
            ];
            addToEmailQueue($emailData);
        }
        return $this->builderContact->insert($data);
    }

    //get contact messages
    public function getContactMessages()
    {
        return $this->builderContact->orderBy('id DESC')->get()->getResult();
    }

    //get contact message
    public function getContactMessage($id)
    {
        return $this->builderContact->where('id', clrNum($id))->get()->getRow();
    }

    //get lastest contact messages
    public function getLastestContactMessages()
    {
        return $this->builderContact->orderBy('id DESC')->get(5)->getResult();
    }

    //delete contact message
    public function deleteContactMessage($id)
    {
        $contact = $this->getContactMessage($id);
        if (!empty($contact)) {
            return $this->builderContact->where('id', $contact->id)->delete();
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * Brands
     * --------------------------------------------------------------------
     */

    //add brand
    public function addBrand()
    {
        $data['show_on_slider'] = !empty(inputPost('show_on_slider')) ? 1 : 0;
        $nameArray = array();
        foreach ($this->activeLanguages as $language) {
            $nameArray[$language->id] = inputPost('name_lang_' . $language->id);
        }
        $data['name'] = inputPost('name_lang_' . selectedLangId());
        $data['name_data'] = serialize($nameArray);
        $uploadModel = new UploadModel();
        $file = $uploadModel->uploadTempFile('file', true);
        if (!empty($file) && !empty($file['path'])) {
            $data['image_path'] = $uploadModel->uploadBrand($file['path']);
            $uploadModel->deleteTempFile($file['path']);
        }
        $data = $this->setBrandCategories($data);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->builderBrands->insert($data);
    }

    //edit brand
    public function editBrand()
    {
        $id = inputPost('id');
        $brand = $this->getBrand($id);
        if (!empty($brand)) {
            $data['show_on_slider'] = !empty(inputPost('show_on_slider')) ? 1 : 0;
            $nameArray = array();
            foreach ($this->activeLanguages as $language) {
                $nameArray[$language->id] = inputPost('name_lang_' . $language->id);
            }
            $data['name'] = inputPost('name_lang_' . selectedLangId());
            $data['name_data'] = serialize($nameArray);
            $uploadModel = new UploadModel();
            $file = $uploadModel->uploadTempFile('file', true);
            if (!empty($file) && !empty($file['path'])) {
                deleteFile($brand->image_path);
                $data['image_path'] = $uploadModel->uploadBrand($file['path']);
            }
            $data = $this->setBrandCategories($data);
            return $this->builderBrands->where('id', $brand->id)->update($data);
        }
        return false;
    }

    //set brand categories
    public function setBrandCategories($data)
    {
        $array = [];
        $categoryData = '';
        $categoryIds = inputPost('category_ids');
        if (!empty($categoryIds)) {
            $categoryIdsArr = explode(',', $categoryIds);
            if (!empty($categoryIdsArr) && countItems($categoryIdsArr) > 0) {
                foreach ($categoryIdsArr as $item) {
                    if (!in_array($item, $array)) {
                        array_push($array, clrNum($item));
                    }
                }
            }
            if (!empty($array) && countItems($array) > 0) {
                $categoryData = implode(',', $array);
            }
        }
        $data['category_data'] = $categoryData;
        return $data;
    }

    //get brand
    public function getBrand($id)
    {
        return $this->builderBrands->where('id', clrNum($id))->get()->getRow();
    }

    //get brands
    public function getBrands($limit = null)
    {
        if (!empty($limit)) {
            return $this->builderBrands->orderBy('name')->get(clrNum($limit))->getResult();
        }
        return $this->builderBrands->orderBy('name')->get()->getResult();
    }

    //get brands slider
    public function getBrandsSlider()
    {
        $key = 'brands_slider';
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        $rows = $this->builderBrands->where('show_on_slider', 1)->orderBy('name')->get()->getResult();
        setCacheStatic($key, $rows);
        return $rows;
    }

    //get brands by category
    public function getBrandsByCategory($category)
    {
        $key = !empty($category) ? 'brands_cat_' . $category->id : 'brands';
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        if (!empty($category)) {
            $categoryModel = new CategoryModel();
            $idsArray = $categoryModel->getCategoryParentTreeIdArray($category);
            if (!empty($idsArray) && countItems($idsArray) > 0) {
                foreach ($idsArray as $id) {
                    $this->builderBrands->orWhere("FIND_IN_SET(" . clrNum($id) . ", category_data)");
                }
            }
        }
        $rows = $this->builderBrands->orderBy('name')->get()->getResult();
        setCacheStatic($key, $rows);
        return $rows;
    }

    //get brands count
    public function getBrandsCount()
    {
        return $this->builderBrands->countAllResults();
    }

    //get brands paginated
    public function getBrandsPaginated($perPage, $offset)
    {
        return $this->builderBrands->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //delete brand
    public function deleteBrand($id)
    {
        $brand = $this->getBrand($id);
        if (!empty($brand)) {
            deleteFile($brand->image_path);
            return $this->builderBrands->where('id', $brand->id)->delete();
        }
        return false;
    }

    //update brand settings
    public function updateBrandSettings()
    {
        $data = [
            'brand_status' => !empty(inputPost('brand_status')) ? 1 : 0,
            'is_brand_optional' => !empty(inputPost('is_brand_optional')) ? 1 : 0,
            'brand_where_to_display' => inputPost('brand_where_to_display')
        ];
        return $this->db->table('product_settings')->where('id', 1)->update($data);
    }

    /*
     * --------------------------------------------------------------------
     * Affiliate Links
     * --------------------------------------------------------------------
     */

    //create affiliate link
    public function createAffiliateLink($userId, $productId, $langId)
    {
        $product = getProduct($productId);
        if (authCheck() && !empty($product)) {
            $data['referrer_id'] = clrNum($userId);
            $data['product_id'] = $product->id;
            $data['seller_id'] = $product->user_id;
            $data['lang_id'] = clrNum($langId);
            $data['link_short'] = uniqid();
            $data['created_at'] = date('Y-m-d H:i:s');
            if (empty($this->getAffiliateLink($userId, $product->id, $langId))) {
                return $this->builderAffiliateLinks->insert($data);
            }
        }
        return false;
    }

    //get affiliate link
    public function getAffiliateLink($userId, $productId, $langId)
    {
        return $this->builderAffiliateLinks->where('referrer_id', clrNum($userId))->where('product_id', clrNum($productId))->where('lang_id', clrNum($langId))->get()->getRow();
    }

    //get affiliate link by id
    public function getAffiliateLinkById($id)
    {
        return $this->builderAffiliateLinks->where('id', clrNum($id))->get()->getRow();
    }

    //get affiliate link by slug
    public function getAffiliateLinkBySlug($slug)
    {
        return $this->builderAffiliateLinks->where('link_short', cleanStr($slug))->get()->getRow();
    }

    //get user affiliate links count
    public function getUserAffiliateLinksCount($userId)
    {
        return $this->builderAffiliateLinks->where('referrer_id', clrNum($userId))->countAllResults();
    }

    //get user affiliate links paginated
    public function getUserAffiliateLinksPaginated($userId, $perPage, $offset)
    {
        return $this->builderAffiliateLinks->where('referrer_id', clrNum($userId))->orderBy('id DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //convert affiliate link
    public function convertAffiliateLink($affiliateLink)
    {
        if (!empty($affiliateLink)) {
            $product = getProduct($affiliateLink->product_id);
            if (!empty($product)) {
                $url = '';
                $langBase = '';
                if ($this->generalSettings->site_lang != $affiliateLink->lang_id) {
                    $lang = getLanguage($langId);
                    if (!empty($lang)) {
                        $langBase = $lang->short_form;
                    }
                }
                if (!empty($langBase)) {
                    $url = $langBase . '/';
                }
                return base_url($langBase . $product->slug);
            }
        }
        return false;
    }

    //set affiliate cookie
    public function setAffiliateCookie($affiliateLink)
    {
        if (!empty($affiliateLink)) {
            helperSetCookie(AFFILIATE_COOKIE_NAME, $affiliateLink->id, time() + (86400 * AFFILIATE_COOKIE_TIME));
        }
    }

    //delete affiliate cookie
    public function deleteAffiliateCookie($productIds)
    {
        if (!empty(helperGetCookie(AFFILIATE_COOKIE_NAME)) && !empty($productIds) && countItems($productIds) > 0) {
            $affiliateId = helperGetCookie(AFFILIATE_COOKIE_NAME);
            $affiliate = $this->getAffiliateLinkById($affiliateId);
            if (!empty($affiliate)) {
                if (in_array($affiliate->product_id, $productIds)) {
                    helperDeleteCookie(AFFILIATE_COOKIE_NAME);
                }
            }
        }
    }

    //delete affiliate link
    public function deleteAffiliateLink($id)
    {
        if (authCheck()) {
            $link = $this->getAffiliateLinkById($id);
            if (!empty($link) && user()->id == $link->referrer_id) {
                return $this->builderAffiliateLinks->where('id', $link->id)->delete();
            }
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * Bank Transfer
     * --------------------------------------------------------------------
     */

    //add bank transfer payment report
    public function addBankTransferPaymentReport()
    {
        $reportType = inputPost('report_type');
        $reportItemId = inputPost('report_item_id');
        $orderNumber = inputPost('order_number');
        if (authCheck() && !empty($reportType) && !empty($reportItemId)) {
            if ($this->isValidBankReport($reportType) == false) {
                return false;
            }
            $data = [
                'report_type' => $reportType,
                'report_item_id' => $reportItemId,
                'order_number' => !empty($orderNumber) ? $orderNumber : 0,
                'payment_note' => inputPost('payment_note'),
                'receipt_path' => '',
                'user_id' => user()->id,
                'status' => "pending",
                'ip_address' => getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $uploadModel = new UploadModel();
            $file = $uploadModel->uploadReceipt('file');
            if (!empty($file) && !empty($file['path'])) {
                $data['receipt_path'] = $file['path'];
            }
            return $this->builderBankTransfers->insert($data);
        }
        return false;
    }

    //get bank transfer notifications
    public function getBankTransfersCount()
    {
        $this->filterBankTransfers();
        return $this->builderBankTransfers->countAllResults();
    }

    //get paginated bank transfer notifications
    public function getBankTransfersPaginated($perPage, $offset)
    {
        $this->filterBankTransfers();
        return $this->builderBankTransfers->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter bank transfers
    public function filterBankTransfers()
    {
        $status = inputGet('status');
        $q = inputGet('q');
        if (!empty($status)) {
            $this->builderBankTransfers->where('status', $status);
        }
        if (!empty($q)) {
            $q = urldecode($q);
            $q = str_replace('#', '', $q);
            $this->builderBankTransfers->where('order_number', $q);
        }
        $this->builderBankTransfers->join('users', 'users.id = bank_transfers.user_id')
            ->select('bank_transfers.*, users.slug AS user_slug, users.username AS user_username');
    }

    //get bank transfer
    public function getBankTransfer($id)
    {
        return $this->builderBankTransfers->where('id', clrNum($id))->get()->getRow();
    }

    //get last bank transfer record
    public function getLastBankTransfer($reportType, $itemId)
    {
        if ($this->isValidBankReport($reportType) == false) {
            return false;
        }
        if ($reportType == 'order') {
            return $this->builderBankTransfers->where('report_type', cleanStr($reportType))->where('order_number', cleanStr($itemId))->orderBy('id DESC')->get(1)->getRow();
        } else {
            return $this->builderBankTransfers->where('report_type', cleanStr($reportType))->where('report_item_id', clrNum($itemId))->orderBy('id DESC')->get(1)->getRow();
        }
    }

    //update bank transfer status
    public function updateBankTransferStatus($transfer, $option)
    {
        if (!empty($transfer)) {
            return $this->builderBankTransfers->where('id', $transfer->id)->update(['status' => $option]);
        }
        return false;
    }

    //delete bank transfer
    public function deleteBankTransfer($id)
    {
        $transfer = $this->getBankTransfer($id);
        if (!empty($transfer)) {
            deleteFile($transfer->receipt_path);
            return $this->builderBankTransfers->where('id', $transfer->id)->delete();
        }
        return false;
    }

    //check if report type is valid
    private function isValidBankReport($type)
    {
        if ($type != 'order' && $type != 'wallet_deposit' && $type != 'membership' && $type != 'promote') {
            return false;
        }
        return true;
    }


}
