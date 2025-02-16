<?php namespace App\Models;

class ProductAdminModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('products');
    }

    //build query
    public function buildQuery($langId = null, $type = null, $getExpired = true)
    {
        if (empty($langId)) {
            $langId = $this->activeLang->id;
        }
        $this->builder->resetQuery();
        $this->builder->select('products.*, users.username AS user_username,  users.slug AS user_slug')
            ->select('(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = ' . clrNum($langId) . ' LIMIT 1) AS title')
            ->select("(SELECT GROUP_CONCAT(lang_id, '" . CAT_QUERY_SEPARATOR_SUB . "', name SEPARATOR '" . CAT_QUERY_SEPARATOR . "') FROM categories_lang WHERE categories_lang.category_id = products.category_id) AS category_name")
            ->select("(SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC, images.id DESC LIMIT 1) AS image")
            ->join('users', 'products.user_id = users.id');
        if (countItems($this->activeLanguages) > 1) {
            $this->builder->select('(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != ' . clrNum($langId) . " LIMIT 1) AS second_title");
        }
        if ($this->generalSettings->membership_plans_system == 1 && $getExpired == true) {
            if ($type == 'expired') {
                $this->builder->where('users.is_membership_plan_expired = 1');
            } else {
                $this->builder->where('users.is_membership_plan_expired = 0');
            }
        }
    }

    //get latest products
    public function getLatestProducts($limit)
    {
        $this->buildQuery();
        return $this->builder->where('products.is_active', 1)->orderBy('products.id DESC')->get(clrNum($limit))->getResult();
    }

    //get products count
    public function getProductsCount()
    {
        $this->buildQuery();
        return $this->builder->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->countAllResults();
    }

    //get latest pending products
    public function getLatestPendingProducts($limit)
    {
        $this->buildQuery();
        return $this->builder->where('products.status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->orderBy('products.id DESC')->get(clrNum($limit))->getResult();
    }

    //get pending products count
    public function getPendingProductsCount()
    {
        $this->buildQuery();
        return $this->builder->where('products.status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->countAllResults();
    }

    //get paginated products count
    public function getFilteredProductCount($list)
    {
        if ($list == 'expired_products') {
            $this->buildQuery(null, 'expired');
        } elseif ($list == 'deleted_products') {
            $this->buildQuery(null, null, false);
        } else {
            $this->buildQuery();
        }
        $this->filterProducts($list);
        return $this->builder->countAllResults();
    }

    //get paginated products
    public function getFilteredProductsPaginated($perPage, $offset, $list)
    {
        if ($list == 'expired_products') {
            $this->buildQuery(null, 'expired');
        } elseif ($list == 'deleted_products') {
            $this->buildQuery(null, null, false);
        } else {
            $this->buildQuery();
        }
        $this->filterProducts($list);
        return $this->builder->limit($perPage, $offset)->get()->getResult();
    }

    //get export products
    public function getFilteredProductsExport($list)
    {
        if ($list == 'expired_products') {
            $this->buildQuery(null, 'expired');
        } elseif ($list == 'deleted_products') {
            $this->buildQuery(null, null, false);
        } else {
            $this->buildQuery();
        }
        $this->builder->select('(SELECT username FROM users WHERE products.user_id = users.id) AS seller_username')
            ->select("(SELECT GROUP_CONCAT(storage, ':::', image_big) FROM images WHERE images.product_id = products.id) AS images_big")
            ->select('(SELECT CONCAT(short_description, ":::", description)  FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = ' . clrNum($this->activeLang->id) . ' LIMIT 1) AS product_content')
            ->select('(SELECT name FROM categories_lang WHERE products.category_id = categories_lang.category_id AND categories_lang.lang_id = ' . clrNum($this->activeLang->id) . ' LIMIT 1) AS category_name');
        $this->filterProducts($list, 'POST');
        return $this->builder->get()->getResult();
    }

    //filter by values
    public function filterProducts($list, $formMethod = 'GET')
    {
        $listingType = inputGet('listing_type');
        $productType = inputGet('product_type');
        $stock = inputGet('stock');
        $q = inputGet('q');
        $categoryId = inputGet('category');
        $subCategoryId = inputGet('subcategory');
        if ($formMethod == 'POST') {
            $listingType = inputPost('listing_type');
            $productType = inputPost('product_type');
            $stock = inputPost('stock');
            $q = inputPost('q');
            $categoryId = inputPost('category');
            $subCategoryId = inputPost('subcategory');
        }

        $arrayCategoryIds = array();
        if (!empty($subCategoryId)) {
            $categoryId = $subCategoryId;
        }
        if (!empty($categoryId)) {
            $categoryModel = new CategoryModel();
            $arrayCategoryIds = $categoryModel->getSubCategoriesTreeIds($categoryId, false);
        }

        if (!empty($arrayCategoryIds)) {
            $this->builder->whereIn('products.category_id', $arrayCategoryIds);
        }
        if (!empty($q)) {
            $search = removeForbiddenCharacters($q);
            $escSearch = $this->db->escape($search);
            $this->builder->join('product_search_indexes psi', 'psi.product_id = products.id AND psi.lang_id = ' . selectedLangId())
                ->where("MATCH(psi.search_index) AGAINST({$escSearch} IN NATURAL LANGUAGE MODE)");
        }
        if ($listingType == 'sell_on_site' || $listingType == 'ordinary_listing' || $listingType == 'bidding' || $listingType == 'license_key') {
            $this->builder->where('products.listing_type', $listingType);
        }
        if ($productType == 'physical' || $productType == 'digital') {
            $this->builder->where('products.product_type', $productType);
        }
        if ($stock == 'in_stock' || $stock == 'out_of_stock') {
            $this->builder->groupStart();
            if ($stock == 'out_of_stock') {
                $this->builder->where("products.product_type = 'physical' AND products.stock <=", 0);
            } else {
                $this->builder->where("products.product_type = 'digital' OR products.stock >", 0);
            }
            $this->builder->groupEnd();
        }
        if (!empty($list)) {
            if ($list == 'products') {
                $this->builder->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.status', 1);
            }
            if ($list == 'featured_products') {
                $this->builder->where('products.visibility', 1)->where('products.is_promoted', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.status', 1);
            }
            if ($list == 'edited_products') {
                $this->builder->where('products.visibility', 1)->where('products.is_edited', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
            }
            if ($list == 'special_offers') {
                $this->builder->where('products.visibility', 1)->where('products.is_special_offer', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.status', 1);
            }
            if ($list == 'pending_products') {
                $this->builder->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.status !=', 1)->where('products.is_edited !=', 1);
            }
            if ($list == 'hidden_products') {
                $this->builder->where('products.visibility', 0)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.status', 1);
            }
            if ($list == 'expired_products') {
                $this->builder->where('products.is_draft', 0)->where('products.is_deleted', 0);
            }
            if ($list == 'sold_products') {
                $this->builder->where('products.is_sold', 1)->where('products.is_deleted', 0);
            }
            if ($list == 'drafts') {
                $this->builder->where('products.is_draft', 1)->where('products.is_deleted', 0);
            }
            if ($list == 'deleted_products') {
                $this->builder->where('products.is_deleted', 1);
            }
        }
        if ($list == 'special_offers') {
            $this->builder->orderBy('products.special_offer_date DESC');
        } else {
            if (empty($q)) {
                $this->builder->orderBy('products.id DESC');
            }
        }
    }

    //get product
    public function getProduct($id)
    {
        return $this->builder->where('products.id', clrNum($id))->get()->getRow();
    }

    //get product by slug
    public function isProductSlugUnique($productId, $slug)
    {
        if ($this->builder->where('products.id !=', clrNum($productId))->where('products.slug', removeSpecialCharacters($slug))->get()->getRow()) {
            return false;
        }
        return true;
    }

    //approve product
    public function approveProduct($id)
    {
        $product = $this->getProduct($id);
        if (!empty($product)) {
            $data = [
                'status' => 1,
                'is_active' => 1,
                'is_edited' => 0,
                'is_rejected' => 0,
                'reject_reason' => '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $this->builder->where('id', $product->id)->update($data);
        }
        return false;
    }

    //reject product
    public function rejectProduct($id)
    {
        $product = $this->getProduct($id);
        if (!empty($product)) {
            $data = [
                'status' => 0,
                'is_active' => 0,
                'is_rejected' => 1,
                'reject_reason' => inputPost('reject_reason')
            ];
            return $this->builder->where('id', $product->id)->update($data);
        }
        return false;
    }

    //add remove promoted product
    public function addRemoveFeaturedProduct($productId, $dayCount)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $transaction = null;
            if ($product->is_promoted == 1) {
                $data = ['is_promoted' => 0];
            } else {
                $date = date('Y-m-d H:i:s');
                $endDate = date('Y-m-d H:i:s', strtotime($date . ' + ' . clrNum($dayCount) . ' days'));
                $data = [
                    'is_promoted' => 1,
                    'promote_start_date' => $date,
                    'promote_end_date' => $endDate
                ];
                $transactionId = inputPost('transaction_id');
                $transaction = $this->db->table('promoted_transactions')->where('id', clrNum($transactionId))->get()->getRow();
                if (!empty($transaction)) {
                    $data["promote_plan"] = $transaction->purchased_plan;
                    $data["promote_day"] = $transaction->day_count;
                }
            }
            $result = $this->builder->where('id', $product->id)->update($data);
            if ($result && !empty($transaction)) {
                $dataTransaction = ['payment_status' => "Completed"];
                $this->db->table('promoted_transactions')->where('id', $transaction->id)->update($dataTransaction);
            }
            return $result;
        }
        return false;
    }

    //add remove special offers
    public function addRemoveSpecialOffer($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            if ($product->is_special_offer == 1) {
                $data = [
                    'is_special_offer' => 0,
                    'special_offer_date' => ''
                ];
            } else {
                $data = [
                    'is_special_offer' => 1,
                    'special_offer_date' => date('Y-m-d H:i:s')
                ];
            }
            return $this->builder->where('id', $product->id)->update($data);
        }
        return false;
    }

    //add remove affiliate product
    public function addRemoveAffiliateProduct($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product) && $product->user_id == user()->id) {
            $data['is_affiliate'] = $product->is_affiliate == 1 ? 0 : 1;
            return $this->builder->where('id', $product->id)->update($data);
        }
        return false;
    }

    //set product as edited
    public function setProductAsEdited($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $data = ['updated_at' => date('Y-m-d H:i:s')];
            if (!empty($this->generalSettings->approve_after_editing)) {
                if (!hasPermission('products')) {
                    if ($product->is_draft != 1 && $product->status == 1) {
                        $data['is_edited'] = 1;
                        if ($this->generalSettings->approve_after_editing == 2) {
                            $data['status'] = 0;
                            $data['is_active'] = 0;
                        }
                    }
                }
            }
            $this->builder->where('id', $product->id)->update($data);
        }
    }

    //approve multi edited products
    public function approveMultiEditedProducts($productIds)
    {
        if (!empty($productIds)) {
            foreach ($productIds as $id) {
                $this->approveProduct($id);
            }
        }
    }

    //get product max id
    public function getProductMaxId()
    {
        $row = $this->builder->selectMax('id')->get()->getRow();
        if (!empty($row->id)) {
            return $row->id;
        }
        return 0;
    }

    //delete product
    public function deleteProduct($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $data = [
                'is_deleted' => 1,
                'is_active' => 0,
            ];
            return $this->builder->where('id', $product->id)->update($data);
        }
        return false;
    }

    //delete product permanently
    public function deleteProductPermanently($id)
    {
        $product = $this->getProduct($id);
        if (!empty($product)) {
            //delete product details
            $this->db->table('product_details')->where('product_id', $product->id)->delete();
            //delete product license keys
            $this->db->table('product_license_keys')->where('product_id', $product->id)->delete();
            //delete images
            $fileModel = new FileModel();
            $fileModel->deleteProductImages($product->id);
            //delete digital product
            if ($product->product_type == 'digital') {
                $fileModel->deleteDigitalFile($product->id);
            }
            //delete comments
            $this->db->table('comments')->where('product_id', $product->id)->delete();
            //delete reviews
            $this->db->table('reviews')->where('product_id', $product->id)->delete();
            //delete from wishlist
            $this->db->table('wishlist')->where('product_id', $product->id)->delete();
            //delete from custom fields
            $this->db->table('custom_fields_product')->where('product_id', $product->id)->delete();
            //delete tags
            $this->db->table('product_tags')->where('product_id', $product->id)->delete();
            //delete variations
            $variations = $this->db->table('variations')->where('product_id', $product->id)->get()->getResult();
            if (!empty($variations)) {
                foreach ($variations as $variation) {
                    $this->db->table('variation_options')->where('variation_id', $variation->id)->delete();
                    $this->db->table('variations')->where('id', $variation->id)->delete();
                }
            }
            return $this->builder->where('id', $product->id)->delete();
        }
        return false;
    }

    //delete multi product
    public function deleteMultiProducts($productIds)
    {
        if (!empty($productIds)) {
            foreach ($productIds as $id) {
                $this->deleteProduct($id);
            }
        }
    }

    //delete multi product
    public function deleteSelectedProductsPermanently($productIds)
    {
        if (!empty($productIds)) {
            foreach ($productIds as $id) {
                $this->deleteProductPermanently($id);
            }
        }
    }

    //restore product
    public function restoreProduct($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            return $this->builder->where('id', $product->id)->update(['is_deleted' => 0, 'is_active' => 1]);
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * CSV Bulk Upload
     * --------------------------------------------------------------------
     */

    //generate CSV object
    public function generateCsvObject($filePath)
    {
        $array = array();
        $fields = array();
        $txtName = uniqid() . '-' . user()->id . '.txt';
        $i = 0;
        $handle = fopen($filePath, 'r');
        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k => $value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                return false;
            }
            fclose($handle);
            if (!empty($array)) {
                $txtFile = fopen(FCPATH . 'uploads/temp/' . $txtName, 'w');
                fwrite($txtFile, serialize($array));
                fclose($txtFile);
                $csvObject = new \stdClass();
                $csvObject->number_of_items = count($array);
                $csvObject->txt_file_name = $txtName;
                @unlink($filePath);
                return $csvObject;
            }
        }
        return false;
    }

    //add csv product
    public function addCsvProduct($txtFileName, $index)
    {
        $filePath = FCPATH . 'uploads/temp/' . $txtFileName;
        $file = fopen($filePath, 'r');
        $content = fread($file, filesize($filePath));
        $array = unserializeData($content);
        $membershipModel = new MembershipModel();
        $productModel = new ProductModel();
        if (!empty($array)) {
            $listingType = inputPost('listing_type');
            $currency = inputPost('currency');
            $i = 1;
            foreach ($array as $item) {
                if (!empty($listingType) && !empty($currency)) {
                    if ($i == $index) {
                        if (!$membershipModel->isAllowedAddingProduct()) {
                            echo 'Upgrade your current plan if you want to upload more ads!';
                            exit();
                        }
                        $data = array();
                        $productTitle = getCsvValue($item, 'title');
                        $data['slug'] = !empty(getCsvValue($item, 'slug')) ? getCsvValue($item, 'slug') : strSlug($productTitle);
                        $data['product_type'] = 'physical';
                        $data['listing_type'] = !empty($listingType) ? $listingType : 'sell_on_site';
                        $data['sku'] = getCsvValue($item, 'sku');
                        $data['category_id'] = !empty(getCsvValue($item, 'category_id', 'int')) ? getCsvValue($item, 'category_id', 'int') : 1;
                        $data['price'] = $this->getCsvPrice(getCsvValue($item, 'price'));
                        $data['price_discounted'] = $this->getCsvPrice(getCsvValue($item, 'price_discounted'));
                        if (empty($data['price_discounted']) || $data['price_discounted'] > $data['price']) {
                            $data['price_discounted'] = $data['price'];
                        }
                        $data['discount_rate'] = 0;
                        if (!empty($data['price']) && $data['price_discounted'] < $data['price']) {
                            $data['discount_rate'] = @intval((($data['price'] - $data['price_discounted']) * 100) / $data['price']);
                            if (empty($data['discount_rate'])) {
                                $data['discount_rate'] = 0;
                            }
                        }
                        $data['currency'] = !empty($currency) ? $currency : 'USD';
                        $data['vat_rate'] = getCsvValue($item, 'vat_rate', 'int');
                        $data['user_id'] = user()->id;
                        $data['status'] = 0;
                        $data['is_active'] = 0;
                        $data['is_promoted'] = 0;
                        $data['promote_start_date'] = null;
                        $data['promote_end_date'] = null;
                        $data['promote_plan'] = 'none';
                        $data['promote_day'] = 0;
                        $data['visibility'] = 1;
                        $data['rating'] = 0;
                        $data['pageviews'] = 0;
                        $data['demo_url'] = '';
                        $data['external_link'] = getCsvValue($item, 'external_link');
                        $data['files_included'] = '';
                        $data['stock'] = getCsvValue($item, 'stock', 'int');
                        $data['shipping_class_id'] = 0;
                        $data['shipping_delivery_time_id'] = 0;
                        $data['multiple_sale'] = 0;
                        $data['brand_id'] = getCsvValue($item, 'brand_id', 'int');
                        $data['is_sold'] = 0;
                        $data['is_deleted'] = 0;
                        $data['is_draft'] = 0;
                        $data['is_free_product'] = 0;
                        $data['status'] = 0;
                        $data['updated_at'] = !empty(getCsvValue($item, 'updated_at')) ? getCsvValue($item, 'updated_at') : null;
                        $data['created_at'] = !empty(getCsvValue($item, 'created_at')) ? getCsvValue($item, 'created_at') : date('Y-m-d H:i:s');
                        if ($this->generalSettings->approve_before_publishing == 0 || hasPermission('products')) {
                            $data['status'] = 1;
                            $data['is_active'] = 1;
                        }
                        if ($this->builder->insert($data)) {
                            //last id
                            $lastId = $this->db->insertID();
                            //update slug
                            $productModel->updateSlug($lastId);
                            //add product title description
                            $dataTitleDesc = [
                                'product_id' => $lastId,
                                'lang_id' => selectedLangId(),
                                'title' => $productTitle,
                                'description' => getCsvValue($item, 'description'),
                                'short_description' => getCsvValue($item, 'short_description')
                            ];
                            $this->db->table('product_details')->insert($dataTitleDesc);
                            //add tags
                            $this->addTagsCSV(getCsvValue($item, 'tags'), selectedLangId(), $lastId);
                            //upload images
                            $this->uploadProductImagesCsv(getCsvValue($item, 'image_url'), $lastId);
                            return $productTitle;
                        }
                    }
                    $i++;
                }
            }
        }
    }

    //edit csv product
    public function editCsvProduct($txtFileName, $index)
    {
        $filePath = FCPATH . 'uploads/temp/' . $txtFileName;
        $file = fopen($filePath, 'r');
        $content = fread($file, filesize($filePath));
        $array = unserializeData($content);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $item) {
                if ($i == $index) {
                    $productId = getCsvValue($item, 'id', 'int');
                    if (empty($productId)) {
                        return 'id_not_defined';
                    }
                    $data = array();
                    if (issetCsvValue($item, 'slug') && !empty(getCsvValue($item, 'slug'))) {
                        $data['slug'] = getCsvValue($item, 'slug');
                    }
                    if (issetCsvValue($item, 'sku')) {
                        $data['sku'] = getCsvValue($item, 'sku');
                    }
                    if (issetCsvValue($item, 'category_id')) {
                        $data['category_id'] = getCsvValue($item, 'category_id', 'int');
                    }
                    if (issetCsvValue($item, 'price')) {
                        $data['price'] = $this->getCsvPrice(getCsvValue($item, 'price'));
                        if (issetCsvValue($item, 'price_discounted')) {
                            $data['price_discounted'] = $this->getCsvPrice(getCsvValue($item, 'price_discounted'));
                        }
                        if (empty($data['price_discounted']) || $data['price_discounted'] > $data['price']) {
                            $data['price_discounted'] = $data['price'];
                        }
                        $data['discount_rate'] = 0;
                        if (!empty($data['price']) && $data['price_discounted'] < $data['price']) {
                            $data['discount_rate'] = @intval((($data['price'] - $data['price_discounted']) * 100) / $data['price']);
                            if (empty($data['discount_rate'])) {
                                $data['discount_rate'] = 0;
                            }
                        }
                    }
                    if (issetCsvValue($item, 'vat_rate')) {
                        $data['vat_rate'] = getCsvValue($item, 'vat_rate');
                    }
                    if (issetCsvValue($item, 'stock')) {
                        $data['stock'] = getCsvValue($item, 'stock', 'int');
                    }
                    if (issetCsvValue($item, 'brand_id')) {
                        $data['brand_id'] = getCsvValue($item, 'brand_id', 'int');
                    }
                    if (issetCsvValue($item, 'external_link')) {
                        $data['external_link'] = getCsvValue($item, 'external_link');
                    }
                    $data['updated_at'] = !empty(getCsvValue($item, 'updated_at')) ? getCsvValue($item, 'updated_at') : date('Y-m-d H:i:s');
                    if (issetCsvValue($item, 'created_at')) {
                        $data['created_at'] = getCsvValue($item, 'created_at');
                    }
                    if ($this->builder->where('id', clrNum($productId))->update($data)) {
                        //edit product title description
                        $dataTitleDesc = array();
                        if (issetCsvValue($item, 'title')) {
                            $dataTitleDesc['title'] = getCsvValue($item, 'title');
                        }
                        if (issetCsvValue($item, 'description')) {
                            $dataTitleDesc['description'] = getCsvValue($item, 'description');
                        }
                        if (issetCsvValue($item, 'short_description')) {
                            $dataTitleDesc['short_description'] = getCsvValue($item, 'short_description');
                        }

                        if (!empty($dataTitleDesc) && countItems($dataTitleDesc) > 0) {
                            $this->db->table('product_details')->where('product_id', clrNum($productId))->update($dataTitleDesc);
                        }
                        //update tags
                        if (issetCsvValue($item, 'tags')) {
                            $this->addTagsCSV(getCsvValue($item, 'tags'), selectedLangId(), $productId, true);
                        }
                        //update images
                        if (issetCsvValue($item, 'image_url') && !empty(getCsvValue($item, 'image_url'))) {
                            $this->uploadProductImagesCsv(getCsvValue($item, 'image_url'), $productId, true);
                        }
                        return trans("product") . ': ' . $productId;
                    }
                }
                $i++;
            }
        }
    }

    //upload product csv images
    public function uploadProductImagesCsv($imageUrl, $productId, $deleteOldImages = false)
    {
        if (!empty($imageUrl)) {
            $uploadModel = new UploadModel();
            $arrayImageUrls = explode(',', $imageUrl);
            if (!empty($arrayImageUrls)) {
                $uploadStatus = false;
                $oldImages = null;
                if ($deleteOldImages) {
                    $oldImages = $this->db->table('images')->where('product_id', clrNum($productId))->get()->getResult();
                }
                foreach ($arrayImageUrls as $url) {
                    $url = trim($url);
                    if (isValidImageUrl($url)) {
                        //upload images
                        $saveTo = FCPATH . 'uploads/temp/temp-' . user()->id . '.jpg';
                        @copy($url, $saveTo);
                        if (!empty($saveTo) && file_exists($saveTo)) {
                            $dataImage = [
                                'product_id' => $productId,
                                'image_small' => $uploadModel->uploadProductImage($saveTo, 'small', 'images'),
                                'image_default' => $uploadModel->uploadProductImage($saveTo, 'default', 'images'),
                                'image_big' => $uploadModel->uploadProductImage($saveTo, 'big', 'images'),
                                'is_main' => 0,
                                'storage' => 'local'
                            ];
                            $uploadModel->deleteTempFile($saveTo);
                        }
                        //move to s3
                        if ($this->storageSettings->storage == 'aws_s3') {
                            $awsModel = new AwsModel();
                            $dataImage['storage'] = 'aws_s3';
                            if (!empty($dataImage['image_default'])) {
                                $awsModel->putProductObject($dataImage['image_default'], FCPATH . 'uploads/images/' . $dataImage['image_default']);
                                deleteFile('uploads/images/' . $dataImage['image_default']);
                            }
                            if (!empty($dataImage['image_big'])) {
                                $awsModel->putProductObject($dataImage['image_big'], FCPATH . 'uploads/images/' . $dataImage['image_big']);
                                deleteFile('uploads/images/' . $dataImage['image_big']);
                            }
                            if (!empty($dataImage['image_small'])) {
                                $awsModel->putProductObject($dataImage['image_small'], FCPATH . 'uploads/images/' . $dataImage['image_small']);
                                deleteFile('uploads/images/' . $dataImage['image_small']);
                            }
                        }
                        error_reporting(0);
                        $this->db->reconnect();
                        if ($this->db->table('images')->insert($dataImage)) {
                            $uploadStatus = true;
                        }
                    }
                }
                if ($deleteOldImages && $uploadStatus && !empty($oldImages)) {
                    $fileModel = new FileModel();
                    foreach ($oldImages as $img) {
                        $fileModel->deleteProductImage($img->id);
                    }
                }
            }
        }
    }

    //add or update product tags
    private function addTagsCSV($tagsInput, $langId, $productId, $deleteOldTags = false)
    {
        if ($deleteOldTags) {
            $this->db->table('product_tags')->where('product_id', clrNum($productId))->where('lang_id', clrNum($langId))->delete();
        }
        $tags = [];
        if (!empty($tagsInput)) {
            $tagsArray = explode(',', $tagsInput);
            if (!empty($tagsArray) && countItems($tagsArray) > 0) {
                $tagsArray = array_slice($tagsArray, 0, PRODUCT_TAG_LIMIT);
                foreach ($tagsArray as $item) {
                    if (!empty($item)) {
                        $item = removeSpecialCharacters($item);
                        $item = strtolower($item ?? '');
                        if (!empty($item) && strlen($item) > 2 && !in_array($item, $tags)) {
                            array_push($tags, $item);
                        }
                    }
                }
            }
        }
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    $tag = strlen($tag) > PRODUCT_TAG_CHAR_LIMIT ? substr($tag, 0, PRODUCT_TAG_CHAR_LIMIT) : $tag;
                    $data = [
                        'product_id' => clrNum($productId),
                        'lang_id' => clrNum($langId),
                        'tag' => $tag,
                    ];
                    $this->db->table('product_tags')->insert($data);
                }
            }
        }
    }

    //check product tags
    public function checkProductTags()
    {
        if (!empty($price)) {
            $price = str_replace(',', '.', $price);
            $price = @preg_replace('/[^0-9\.,]/', '', $price);
            $price = @number_format($price, 2, '.', '');
            $price = @str_replace('.00', '', $price);
            $price = @floatval($price);
            if (!empty($price)) {
                return $price * 100;
            }
        }
        return 0;
    }

    //get csv price
    public function getCsvPrice($price)
    {
        if (!empty($price)) {
            $price = str_replace(',', '.', $price);
            $price = @preg_replace('/[^0-9\.,]/', '', $price);
            $price = @number_format($price, 2, '.', '');
            $price = @str_replace('.00', '', $price);
            $price = @floatval($price);
            if (!empty($price)) {
                return $price * 100;
            }
        }
        return 0;
    }
}
