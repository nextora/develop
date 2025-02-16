<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\ChatModel;
use App\Models\CouponModel;
use App\Models\EmailModel;
use App\Models\FieldModel;
use App\Models\FileModel;
use App\Models\LocationModel;
use App\Models\NewsletterModel;
use App\Models\ShippingModel;
use App\Models\VariationModel;
use Config\Globals;

class AjaxController extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!$this->request->isAJAX()) {
            exit();
        }
    }

    /**
     * Load Products
     */
    public function loadProducts()
    {
        $userId = inputGet('user_id');
        $couponId = inputGet('coupon_id');
        $arrayParams = inputGet('params');
        $categoryId = inputGet('category_id');
        $sysLangId = inputGet('sysLangId');
        Globals::setActiveLanguage($sysLangId);
        $page = 1;
        if (!empty($arrayParams)) {
            if (!empty($arrayParams['page'])) {
                $page = getValidPageNumber($arrayParams['page']);
            }
        }
        $category = null;
        $customFilters = null;
        if (!empty($categoryId)) {
            $category = getCategory($categoryId);
            if (!empty($category)) {
                $fieldModel = new FieldModel();
                $parentCategoriesTree = $this->categoryModel->getCategoryParentTree($category);
                $customFilters = $fieldModel->getCustomFilters($category->id, $parentCategoriesTree);
            }
        }

        $objParams = new \stdClass();
        $objParams->pageNumber = $page;
        $objParams->category = $category;
        $objParams->userId = $userId;
        $objParams->customFilters = $customFilters;
        $objParams->arrayParams = $arrayParams;
        $objParams->couponId = $couponId;
        $objParams->langId = $sysLangId;
        $products = $this->productModel->loadProducts($objParams);
        $dataJson = [
            'result' => 0,
            'htmlContent' => '',
            'hasMore' => false
        ];
        $htmlContent = '';
        if (!empty($products)) {
            $i = 0;
            foreach ($products as $product) {
                if ($i < $this->productSettings->pagination_per_page) {
                    $vars = [
                        'product' => $product,
                        'promoted_badge' => true
                    ];
                    $htmlContent .= '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">' . view('product/_product_item', $vars) . '</div>';
                }
                $i++;
            }
            $dataJson = [
                'result' => 1,
                'htmlContent' => $htmlContent,
                'hasMore' => countItems($products) > $this->productSettings->pagination_per_page ? true : false,
                'pageNumber' => $page
            ];
        }
        echo json_encode($dataJson);
    }

    /**
     * Load More Promoted Products
     */
    public function loadMorePromotedProducts()
    {
        $perPage = $this->generalSettings->index_promoted_products_count;
        $page = clrNum(inputPost('page'));
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $perPage;
        $promotedProducts = $this->productModel->getPromotedProductsLimited($perPage, $offset);
        $htmlContent = '';
        if (!empty($promotedProducts)) {
            $i = 0;
            foreach ($promotedProducts as $product) {
                if ($i < $perPage) {
                    $vars = [
                        'product' => $product,
                        'promoted_badge' => false
                    ];
                    $htmlContent .= '<div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">' . view('product/_product_item', $vars) . '</div>';
                }
                $i++;
            }
        }
        $dataJson = [
            'result' => 1,
            'htmlContent' => $htmlContent,
            'hasMore' => countItems($promotedProducts) > $perPage ? true : false
        ];
        echo json_encode($dataJson);
    }

    /**
     * Hide Cookies Warning
     */
    public function hideCookiesWarning()
    {
        helperSetCookie('cks_warning', '1', time() + (86400 * 365));
    }

    /**
     * Create Affiliate Link
     */
    public function createAffiliateLink()
    {
        $productId = inputPost('product_id');
        $langId = inputPost('lang_id');
        $data = [
            'status' => 0,
            'response' => ''
        ];
        $product = getProduct($productId);
        if (!empty($product)) {
            $vendor = getUser($product->user_id);
            if (!empty($vendor) && isActiveAffiliateProduct($product, $vendor)) {
                $this->commonModel->createAffiliateLink(user()->id, $productId, $langId);
                $url = $this->commonModel->getAffiliateLink(user()->id, $productId, $langId);
                if (!empty($url)) {
                    $data = [
                        'status' => 1,
                        'response' => generateUrl('affiliate') . '/' . $url->link_short
                    ];
                }
            }
        }
        echo json_encode($data);
    }

    /**
     * Select Coupon Category
     */
    public function selectCouponCategoryPost()
    {
        $couponId = inputPost('coupon_id');
        $categoryId = inputPost('category_id');
        $action = inputPost('action');
        if (!authCheck()) {
            exit();
        }
        $couponModel = new CouponModel();
        $coupon = $couponModel->getCoupon($couponId);
        if (empty($coupon) || $coupon->seller_id != user()->id) {
            exit();
        }
        $couponModel->setCouponCategories($coupon, $categoryId, $action);
        exit();
    }

    /**
     * Select Coupon Product
     */
    public function selectCouponProductPost()
    {
        $couponId = inputPost('coupon_id');
        $productId = inputPost('product_id');
        $action = inputPost('action');
        if (!authCheck()) {
            exit();
        }
        $couponModel = new CouponModel();
        $coupon = $couponModel->getCoupon($couponId);
        $product = getProduct($productId);
        if (empty($coupon) || empty($product) || $coupon->seller_id != user()->id || $product->user_id != user()->id) {
            exit();
        }
        $couponModel->addRemoveCouponProduct($coupon, $product, $action);
        exit();
    }

    /*
     * --------------------------------------------------------------------
     * Location
     * --------------------------------------------------------------------
     */

    //get states
    public function getStates()
    {
        $countryId = inputPost('country_id');
        $states = $this->locationModel->getStatesByCountry($countryId);
        $status = 0;
        $content = '<option value="">' . trans('state') . '</option>';
        if (!empty($states)) {
            $status = 1;
            foreach ($states as $item) {
                $content .= '<option value="' . $item->id . '">' . esc($item->name) . '</option>';
            }
        }
        $data = [
            'result' => $status,
            'content' => $content
        ];
        echo json_encode($data);
    }

    //get cities
    public function getCities()
    {
        $stateId = inputPost('state_id');
        $cities = $this->locationModel->getCitiesByState($stateId);
        $status = 0;
        $content = '<option value="">' . trans("city") . '</option>';
        if (!empty($cities)) {
            $status = 1;
            foreach ($cities as $item) {
                $content .= '<option value="' . $item->id . '">' . esc($item->name) . '</option>';
            }
        }
        $data = [
            'result' => $status,
            'content' => $content
        ];
        echo json_encode($data);
    }

    //get countries by continent
    public function getCountriesByContinent()
    {
        $key = inputPost('key');
        $model = new LocationModel();
        $countries = $model->getCountriesByContinent($key);
        if (!empty($countries)) {
            foreach ($countries as $country) {
                echo "<option value='" . $country->id . "'>" . esc($country->name) . "</option>";
            }
        }
    }

    //get states by country
    public function getStatesByCountry()
    {
        $countryId = inputPost('country_id');
        $model = new LocationModel();
        $states = $model->getStatesByCountry($countryId);
        if (!empty($states)) {
            foreach ($states as $state) {
                echo "<option value='" . $state->id . "'>" . esc($state->name) . "</option>";
            }
        }
    }

    //get product shipping cost
    public function getProductShippingCost()
    {
        $stateId = inputPost('state_id');
        $productId = inputPost('product_id');
        $shippingModel = new ShippingModel();
        $shippingModel->getProductShippingCost($stateId, $productId);
    }

    /*
     * --------------------------------------------------------------------
     * Search
     * --------------------------------------------------------------------
     */

    //ajax search
    public function ajaxSearch()
    {
        $langBaseUrl = inputPost('lang_base_url');
        $inputValue = cleanStr(inputPost('input_value'));
        $langId = inputPost('sysLangId');
        $data = [
            'result' => 0,
            'response' => ''
        ];
        if (!empty($inputValue) && strlen($inputValue) > 2) {
            $data['result'] = 1;
            $response = '<div class="search-results"><ul>';
            $rows = $this->commonModel->mainAjaxSearch($inputValue, $langId);
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $response .= '<li><a href="' . esc($row['url']) . '"><div class="d-flex justify-content-between align-items-center">';
                    $response .= '<div class="search-item-left">' . esc($row['title']) . '</div>';
                    if ($row['data_type'] != 'tag') {
                        $response .= '<div class="search-item-right"><span>' . trans($row['data_type']) . '</span></div>';
                    } else {
                        $response .= '<div class="search-item-right"></div>';
                    }
                    $response .= '</div></a></li>';
                }
            }
            $response .= '</ul></div>';
            $data['response'] = $response;
            $data['rowCount'] = countItems($rows);
        } else {
            $data['result'] = 1;
            $data['response'] = '';
        }
        echo json_encode($data);
    }

    //get subcategories
    public function getSubCategories()
    {
        $parentId = inputPost('parent_id');
        $langId = inputPost('lang_id');
        $showIds = inputPost('show_ids');
        $htmlContent = '';
        if (!empty($parentId)) {
            $subCategories = $this->categoryModel->getSubCategoriesByParentId($parentId);
            foreach ($subCategories as $item) {
                if (!empty($showIds)) {
                    $htmlContent .= "<option value='" . $item->id . "'>" . getCategoryName($item, $langId) . " (ID: " . $item->id . ")</option>";
                } else {
                    $htmlContent .= "<option value = '" . $item->id . "'> " . getCategoryName($item, $langId) . "</option>";
                }
            }
        }
        $data = [
            'result' => 1,
            'htmlContent' => $htmlContent,
        ];
        echo json_encode($data);
    }

    /*
     * --------------------------------------------------------------------
     * Variations
     * --------------------------------------------------------------------
     */

    //select variation option
    public function selectProductVariationOption()
    {
        $variationArray = inputPost('variation_array');
        $variationModel = new VariationModel();
        $isInStock = false;
        if (!empty($variationArray)) {
            foreach ($variationArray as $variation) {
                if (!empty($variation['var_option_id'])) {
                    $option = $variationModel->getVariationOption($variation['var_option_id']);
                    if (!empty($option)) {
                        if ($option->is_default == 1) {
                            $variation = $variationModel->getVariation($option->variation_id);
                            if (!empty($variation)) {
                                $product = getProduct($variation->product_id);
                                if (!empty($product) && $product->stock > 0) {
                                    $isInStock = true;
                                }
                            }
                        } else {
                            if ($option->stock > 0) {
                                $isInStock = true;
                            }
                        }
                    }
                }
            }
        }

        $variationId = inputPost('variation_id');
        $selectedOptionId = inputPost('selected_option_id');
        $variation = $variationModel->getVariation($variationId);
        $option = $variationModel->getVariationOption($selectedOptionId);
        $data = [
            'status' => 0,
            'htmlContentSlider' => '',
            'htmlContentPrice' => '',
            'htmlContentStock' => '',
            'stockStatus' => 1,
        ];
        if (!empty($variation) && !empty($option)) {
            $product = $this->productModel->getProduct($variation->product_id);
            //slider content response
            if ($variation->show_images_on_slider) {
                $productImages = $variationModel->getVariationOptionImages($selectedOptionId);
                if (empty($productImages)) {
                    $fileModel = new FileModel();
                    $productImages = $fileModel->getProductImages($variation->product_id);
                }
                $vars = [
                    'product' => $product,
                    'productImages' => $productImages
                ];
                $data['htmlContentSlider'] = view('product/details/_preview', $vars);
            }
            $price = $product->price;
            $priceDiscounted = $product->price_discounted;
            $discountRate = $product->discount_rate;
            $updatePrice = false;
            if ($variation->use_different_price == 1) {
                $updatePrice = true;
                if (isset($option->price)) {
                    $price = $option->price;
                }
                if (isset($option->price_discounted)) {
                    $priceDiscounted = $option->price_discounted;
                }
                if (isset($option->discount_rate)) {
                    $discountRate = $option->discount_rate;
                }
                if (empty($price)) {
                    $price = $product->price;
                    $priceDiscounted = $product->price_discounted;
                    $discountRate = $product->discount_rate;
                }
            }
            $vars = [
                'product' => $product,
                'price' => $price,
                'priceDiscounted' => $priceDiscounted,
                'discountRate' => $discountRate
            ];

            $data['htmlContentPrice'] = $updatePrice == true ? view('product/details/_price', $vars) : '';

            //stock content response
            if ($isInStock) {
                $data['htmlContentStock'] = '<span class="text-success">' . trans("in_stock") . '</span>';
            } else {
                $data['htmlContentStock'] = '<span class="text-danger">' . trans("out_of_stock") . '</span>';
                $data['stockStatus'] = 0;
            }
            $data['status'] = 1;
        }
        echo json_encode($data);
    }

    //get sub variation options
    public function getSubVariationOptions()
    {
        $variationId = inputPost('variation_id');
        $selectedOptionId = inputPost('selected_option_id');
        $variationModel = new VariationModel();
        $subvariation = $variationModel->getProductSubVariation($variationId);
        $content = null;
        $data = [
            'status' => 0,
            'subVariationId' => '',
            'htmlContent' => ''
        ];
        if (!empty($subvariation)) {
            $options = $variationModel->getVariationSubOptions($selectedOptionId);
            if (!empty($options)) {
                $content .= '<option value="">' . trans("select") . '</option>';
                foreach ($options as $option) {
                    $option_name = getVariationOptionName($option->option_names, selectedLangId());
                    $content .= '<option value="' . $option->id . '">' . esc($option_name) . '</option>';
                }
            }
            $data['status'] = 1;
            $data['subVariationId'] = $subvariation->id;
            $data['htmlContent'] = $content;
        }
        echo json_encode($data);
    }

    /*
     * --------------------------------------------------------------------
     * Wishlist
     * --------------------------------------------------------------------
     */

    //add or remove wishlist
    public function addRemoveWishlist()
    {
        $productId = inputPost('product_id');
        $this->productModel->addRemoveWishlist($productId);
    }

    /*
     * --------------------------------------------------------------------
     * Product Comment
     * --------------------------------------------------------------------
     */

    //add comment
    public function addComment()
    {
        if ($this->generalSettings->product_comments != 1) {
            exit();
        }
        if (!empty(inputPost('comment_name'))) {
            exit();
        }
        $productId = inputPost('product_id');
        $limit = inputPost('limit');
        $product = getProduct($productId);
        if (!empty($product)) {
            if (authCheck()) {
                $this->commonModel->addComment();
            } else {
                if (reCAPTCHA('validate') != 'invalid') {
                    $this->commonModel->addComment();
                }
            }
            if ($this->generalSettings->comment_approval_system == 1 && !hasPermission('comments')) {
                $data = [
                    'status' => 1,
                    'type' => 'message',
                    'message' => trans("msg_comment_sent_successfully")
                ];
                echo json_encode($data);
            } else {
                $commentsArray = $this->commonModel->getProductCommentsByOffset($productId, $limit, 0);
                $parentComments = [];
                if (!empty($commentsArray) && !empty($commentsArray[0]) && countItems($commentsArray[0]) > 0) {
                    $parentComments = $commentsArray[0];
                }
                $data = [
                    'status' => 1,
                    'type' => 'comments',
                    'htmlContent' => view('product/details/_comments_list', ['product' => $product, 'comments' => $parentComments, 'commentsArray' => $commentsArray])
                ];
                echo json_encode($data);
            }
        }
        exit();
    }

    //load more reviews
    public function loadMoreReviews()
    {
        $productId = inputPost('product_id');
        $offset = inputPost('offset');
        $product = getProduct($productId);
        $data = ['status' => 0];
        if (!empty($product)) {
            $reviews = $this->commonModel->getProductReviewsByOffset($productId, REVIEWS_LOAD_LIMIT, $offset);
            $data = [
                'status' => 1,
                'htmlContent' => view('product/details/_reviews_list', ['product' => $product, 'reviews' => $reviews])
            ];
        }
        echo json_encode($data);
    }

    //load more comments
    public function loadMoreComments()
    {
        $productId = inputPost('product_id');
        $offset = inputPost('offset');
        $product = getProduct($productId);
        $data = ['status' => 0];
        if (!empty($product)) {
            $commentsArray = $this->commonModel->getProductCommentsByOffset($productId, COMMENTS_LOAD_LIMIT, $offset);
            $parentComments = [];
            if (!empty($commentsArray) && !empty($commentsArray[0]) && countItems($commentsArray[0]) > 0) {
                $parentComments = $commentsArray[0];
            }
            $data = [
                'status' => 1,
                'htmlContent' => view('product/details/_comments_list', ['product' => $product, 'comments' => $parentComments, 'commentsArray' => $commentsArray])
            ];
        }
        echo json_encode($data);
    }

    //delete comment
    public function deleteComment()
    {
        $id = inputPost('id');
        $comment = $this->commonModel->getComment($id);
        if (authCheck() && !empty($comment)) {
            if (hasPermission('comments') || user()->id == $comment->user_id) {
                $this->commonModel->deleteComment($id);
            }
        }
    }

    //delete review
    public function deleteReview()
    {
        if (authCheck()) {
            $id = inputPost('id');
            $review = $this->commonModel->getReviewById($id);
            if (!empty($review) && $review->user_id == user()->id) {
                $this->commonModel->deleteReview($id);
            }
        }
    }

    //load subcomment form
    public function loadSubCommentForm()
    {
        $commentId = inputPost('comment_id');
        $vars = [
            'parentComment' => $this->commonModel->getComment($commentId)
        ];
        $data = [
            'status' => 1,
            'htmlContent' => view('product/details/_add_subcomment', $vars),
        ];
        echo json_encode($data);
    }

    /*
     * --------------------------------------------------------------------
     * Blog
     * --------------------------------------------------------------------
     */

    /**
     * Get Blog Categories by Language
     */
    public function getBlogCategoriesByLang()
    {
        $model = new BlogModel();
        $langId = inputPost('lang_id');
        if (!empty($langId)) {
            $categories = $model->getCategoriesByLang($langId);
            if (!empty($categories)) {
                foreach ($categories as $item) {
                    echo '<option value="' . $item->id . '">' . esc($item->name) . '</option>';
                }
            }
        }
    }

    /**
     * Add Blog Comment
     */
    public function addBlogComment()
    {
        if ($this->generalSettings->blog_comments != 1) {
            exit();
        }
        $postId = inputPost('post_id');
        $limit = inputPost('limit');
        $blogModel = new BlogModel();
        if (authCheck()) {
            $blogModel->addComment();
        } else {
            if (reCAPTCHA('validate') != 'invalid') {
                $blogModel->addComment();
            }
        }
        if ($this->generalSettings->comment_approval_system == 1 && !hasPermission('comments')) {
            $data = [
                'type' => 'message',
                'message' => trans("msg_comment_sent_successfully")
            ];
            echo json_encode($data);
        } else {
            $this->generateCommentBlogHtmlContent($blogModel, $postId, $limit);
        }
    }

    /**
     * Delete Blog Comment
     */
    public function deleteBlogComment()
    {
        $commentId = inputPost('comment_id');
        $postId = inputPost('post_id');
        $limit = inputPost('limit');
        $blogModel = new BlogModel();
        $comment = $blogModel->getComment($commentId);
        if (authCheck() && !empty($comment)) {
            if (hasPermission('comments') || user()->id == $comment->user_id) {
                $blogModel->deleteComment($comment->id);
            }
        }
        $this->generateCommentBlogHtmlContent($blogModel, $postId, $limit);
    }

    /**
     * Load More Comments
     */
    public function loadMoreBlogComments()
    {
        $blogModel = new BlogModel();
        $postId = inputPost('post_id');
        $limit = inputPost('limit');
        $newLimit = $limit + COMMENTS_LOAD_LIMIT;
        $this->generateCommentBlogHtmlContent($blogModel, $postId, $newLimit);
    }

    //generate blog comment html content
    private function generateCommentBlogHtmlContent($blogModel, $postId, $limit)
    {
        $vars = [
            'comments' => $blogModel->getCommentsByPostId($postId, $limit),
            'commentPostId' => $postId,
            'commentsCount' => $blogModel->getActiveCommentsCountByPostId($postId),
            'commentLimit' => $limit
        ];
        $data = [
            'type' => 'comments',
            'htmlContent' => view('blog/_blog_comments', $vars),
        ];
        echo json_encode($data);
    }

    /*
     * --------------------------------------------------------------------
     * Abuse Reports
     * --------------------------------------------------------------------
     */

    //report abuse
    public function reportAbusePost()
    {
        if (!authCheck()) {
            exit();
        }
        $data = [
            'message' => "<p class='text-danger'>" . trans("msg_error") . "</p>"
        ];
        if ($this->commonModel->reportAbuse()) {
            $data['message'] = "<p class='text-success'>" . trans("abuse_report_msg") . "</p>";
        }
        echo json_encode($data);
    }


    /*
     * --------------------------------------------------------------------
     * Chat
     * --------------------------------------------------------------------
     */


    /**
     * Add Chat Post
     */
    public function addChatPost()
    {
        if (!authCheck()) {
            exit();
        }
        $receiverId = inputPost('receiver_id');
        $data = [
            'result' => 0,
            'senderId' => 0,
            'htmlContent' => ''
        ];
        if (user()->id == $receiverId) {
            setErrorMessage(trans("msg_message_sent_error"));
            $data['result'] = 1;
            $data['htmlContent'] = view('partials/_messages');
            resetFlashData();
        } else {
            $chatModel = new ChatModel();
            $chatId = $chatModel->addChat();
            if ($chatId) {
                $messageId = $chatModel->addMessage($chatId);
                if ($messageId) {
                    setSuccessMessage(trans("msg_message_sent"));
                    $data['result'] = 1;
                    $data['senderId'] = user()->id;
                    $data['htmlContent'] = view('partials/_messages');
                    resetFlashData();
                } else {
                    setErrorMessage(trans("msg_error"));
                    $data['result'] = 1;
                    $data["htmlContent"] = view('partials/_messages');
                    resetFlashData();
                }
            } else {
                setErrorMessage(trans("msg_error"));
                $data['result'] = 1;
                $data['htmlContent'] = view('partials/_messages');
                resetFlashData();
            }
        }
        echo json_encode($data);
    }

    //send message
    public function sendMessagePost()
    {
        if (!authCheck()) {
            exit();
        }
        $jsonData = ['status' => 0];
        $chatModel = new ChatModel();
        $chatId = inputPost('chat_id');
        $chat = $chatModel->getChat($chatId);
        if ($chat->sender_id == user()->id || $chat->receiver_id == user()->id) {
            $chatModel->addMessage($chatId);
            $jsonData = [
                'status' => 1,
                'chatId' => $chat->id,
                'arrayChats' => $chatModel->getChatsArray($chat->id),
                'arrayMessages' => $chatModel->getMessagesArray($chatId)
            ];
        }
        echo json_encode($jsonData);
        exit();
    }

    //load mesages post
    public function loadChatPost()
    {
        if (!authCheck()) {
            exit();
        }
        $jsonData = ['status' => 0];
        $chatId = inputPost('chat_id');
        $jsonData = $this->loadChatHTML($chatId);
        echo $jsonData;
        exit();
    }

    //update chat post
    public function updateChatGet()
    {
        if (!authCheck()) {
            exit();
        }
        $chatModel = new ChatModel();
        $jsonData = json_encode(['status' => 0]);
        if ($chatModel->checkUserChatCache(user()->id)) {
            $chatId = inputGet('chat_id');
            $jsonData = $this->updateChatHTML($chatId);
        }
        echo $jsonData;
        exit();
    }

    //delete chat
    public function deleteChatPost()
    {
        if (!authCheck()) {
            exit();
        }
        $chatModel = new ChatModel();
        $chatId = inputPost('chat_id');
        $chatModel->deleteChat($chatId);
    }

    //load chat HTML
    private function loadChatHTML($chatId)
    {
        $chatModel = new ChatModel();
        $chat = $chatModel->getChat($chatId);
        $jsonData = [
            'status' => 0
        ];
        if (!empty($chat)) {
            if ($chat->sender_id != user()->id && $chat->receiver_id != user()->id) {
                exit();
            }
            $messages = $chatModel->getMessages($chatId);
            //chat receiver
            $receiverId = $chat->sender_id;
            if (user()->id == $chat->sender_id) {
                $receiverId = $chat->receiver_id;
            }
            $jsonData = [
                'status' => 1,
                'arrayChats' => $chatModel->getChatsArray($chat->id),
                'htmlchatUser' => view('chat/_chat_user', ['chat' => $chat]),
                'htmlContentMessages' => view('chat/_messages', ['chat' => $chat, 'messages' => $messages]),
                'htmlChatForm' => view('chat/_chat_form', ['chat' => $chat]),
                'receiverId' => $receiverId,
            ];
            $chatModel->setChatMessagesAsRead($chat->id);
        }
        return json_encode($jsonData);
    }

    //update chat html
    private function updateChatHTML($chatId)
    {
        $chatModel = new ChatModel();
        $jsonData = [
            'status' => 1,
            'arrayChats' => $chatModel->getChatsArray($chatId),
        ];
        $chat = $chatModel->getChat($chatId);
        if (!empty($chat)) {
            if ($chat->sender_id != user()->id && $chat->receiver_id != user()->id) {
                exit();
            }
            $jsonData['chatId'] = $chat->id;
            $jsonData['arrayMessages'] = $chatModel->getMessagesArray($chat->id);
            $chatModel->setChatMessagesAsRead($chat->id);
        }
        echo json_encode($jsonData);
        exit();
    }

    /*
     * --------------------------------------------------------------------
     * Newsletter
     * --------------------------------------------------------------------
     */

    /**
     * Add to Newsletter
     */
    public function addToNewsletter()
    {
        $vld = inputPost('url');
        if (!empty($vld)) {
            exit();
        }
        $data = [
            'result' => 0,
            'message' => '',
            'isSuccess' => 0,
        ];
        $email = cleanStr(inputPost('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['message'] = trans("msg_invalid_email");
        } else {
            if ($email) {
                $newsletterModel = new NewsletterModel();
                if (empty($newsletterModel->getSubscriber($email))) {
                    if ($newsletterModel->addSubscriber($email)) {
                        $data['message'] = trans("msg_newsletter_success");
                        $data['isSuccess'] = 1;
                    }
                } else {
                    $data['message'] = trans("msg_newsletter_error");
                }
                $data['result'] = 1;
            }
        }
        echo json_encode($data);
    }

    /*
     * --------------------------------------------------------------------
     * Email Functions
     * --------------------------------------------------------------------
     */

    /**
     * Run Email Queue
     */
    public function runEmailQueue()
    {
        $emailModel = new EmailModel();
        $emailModel->runEmailQueue();
        if (authCheck()) {
            $this->authModel->updateLastSeen();
        }
    }
}
