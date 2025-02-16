<?php namespace App\Models;

use Config\Globals;

class ProductModel extends BaseModel
{
    protected $builder;
    protected $builderProductDetails;
    protected $builderTags;
    protected $builderProductLicenseKeys;
    protected $builderCustomFieldsProduct;
    protected $builderDigitalSales;
    protected $builderWishlist;
    protected $builderUsers;
    protected $builderSearchIndexes;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('products');
        $this->builderProductDetails = $this->db->table('product_details');
        $this->builderTags = $this->db->table('product_tags');
        $this->builderProductLicenseKeys = $this->db->table('product_license_keys');
        $this->builderCustomFieldsProduct = $this->db->table('custom_fields_product');
        $this->builderDigitalSales = $this->db->table('digital_sales');
        $this->builderWishlist = $this->db->table('wishlist');
        $this->builderUsers = $this->db->table('users');
        $this->builderSearchIndexes = $this->db->table('product_search_indexes');
    }

    //add product
    public function addProduct()
    {
        $data = [
            'slug' => strSlug(inputPost('title_' . selectedLangId())),
            'product_type' => inputPost('product_type'),
            'listing_type' => inputPost('listing_type'),
            'sku' => '',
            'price' => 0,
            'price_discounted' => 0,
            'currency' => '',
            'discount_rate' => 0,
            'vat_rate' => 0,
            'user_id' => activeUserId(),
            'status' => 0,
            'is_promoted' => 0,
            'promote_start_date' => null,
            'promote_end_date' => null,
            'promote_plan' => 'none',
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'pageviews' => 0,
            'demo_url' => '',
            'external_link' => '',
            'files_included' => '',
            'stock' => 1,
            'shipping_delivery_time_id' => 0,
            'multiple_sale' => 1,
            'digital_file_download_link' => '',
            'is_deleted' => 0,
            'is_draft' => 1,
            'is_free_product' => 0,
            'country_id' => 0,
            'state_id' => 0,
            'city_id' => 0,
            'address' => '',
            'zip_code' => '',
            'is_active' => 0,
            'updated_at' => null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        if (empty($data['sku'])) {
            $data['sku'] = '';
        }
        if (!empty($data['slug'])) {
            $data['slug'] = substr($data['slug'], 0, 200);
        }
        if (empty($data['multiple_sale'])) {
            $data['multiple_sale'] = 0;
        }
        //set category id
        $data['category_id'] = getDropdownCategoryId();
        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //add product title and desc
    public function addProductTitleDesc($productId)
    {
        $mainTitle = inputPost('title_' . defaultLangId());
        $mainTitle = trim($mainTitle ?? '');
        foreach ($this->activeLanguages as $language) {
            $title = inputPost('title_' . $language->id);
            $title = trim($title ?? '');
            if (!empty($title)) {
                $data = [
                    'product_id' => $productId,
                    'lang_id' => $language->id,
                    'title' => !empty($title) ? $title : $mainTitle,
                    'description' => inputPost('description_' . $language->id),
                    'short_description' => inputPost('short_description_' . $language->id)
                ];
                $this->builderProductDetails->insert($data);
            }
            //add product tags
            $this->addUpdateProductTags($productId, $language->id);
        }
    }

    //edit product title and desc
    public function editProductTitleDesc($productId)
    {
        $mainTitle = inputPost('title_' . defaultLangId());
        $mainTitle = trim($mainTitle ?? '');
        foreach ($this->activeLanguages as $language) {
            $title = inputPost('title_' . $language->id);
            $title = trim($title ?? '');
            $data = [
                'product_id' => $productId,
                'lang_id' => $language->id,
                'title' => !empty($title) ? $title : $mainTitle,
                'description' => inputPost('description_' . $language->id),
                'short_description' => inputPost('short_description_' . $language->id)
            ];
            $row = getProductDetails($productId, $language->id, false);
            if (empty($row)) {
                $this->builderProductDetails->insert($data);
            } else {
                $this->builderProductDetails->where('product_id', clrNum($productId))->where('lang_id', $language->id)->update($data);
            }
            //add product tags
            $this->addUpdateProductTags($productId, $language->id);
        }
    }

    //edit product details
    public function editProductDetails($id)
    {
        $product = $this->getProduct($id);
        $data = [
            'sku' => inputPost('sku'),
            'price' => inputPost('price'),
            'price_discounted' => inputPost('price_discounted'),
            'currency' => inputPost('currency'),
            'vat_rate' => inputPost('vat_rate'),
            'demo_url' => inputPost('demo_url'),
            'external_link' => inputPost('external_link'),
            'files_included' => inputPost('files_included'),
            'stock' => inputPost('stock'),
            'shipping_class_id' => inputPost('shipping_class_id'),
            'shipping_delivery_time_id' => inputPost('shipping_delivery_time_id'),
            'multiple_sale' => inputPost('multiple_sale'),
            'digital_file_download_link' => inputPost('digital_file_download_link'),
            'is_free_product' => inputPost('is_free_product'),
            'is_draft' => 0,
            'country_id' => inputPost('country_id'),
            'state_id' => inputPost('state_id'),
            'city_id' => inputPost('city_id'),
            'address' => inputPost('address'),
            'zip_code' => inputPost('zip_code'),
        ];
        $price = getPrice($data['price'], 'database');
        if (empty($price)) {
            $price = 0;
        }
        $priceDiscounted = getPrice($data['price_discounted'], 'database');
        if (empty($priceDiscounted) || $priceDiscounted > $price) {
            $priceDiscounted = $price;
        }
        $discountRate = 0;
        if ($price != 0 && $priceDiscounted < $price) {
            $discountRate = @intval((($price - $priceDiscounted) * 100) / $price);
            if (empty($discountRate)) {
                $discountRate = 0;
            }
        }
        if (!empty(inputPost('checkbox_has_discount'))) {
            $priceDiscounted = $price;
            $discountRate = 0;
        }
        $data['price'] = $price;
        $data['price_discounted'] = $priceDiscounted;
        $data['discount_rate'] = $discountRate;
        $data['vat_rate'] = !empty($data['vat_rate']) ? $data['vat_rate'] : 0;
        $data['external_link'] = !empty($data['external_link']) ? $data['external_link'] : '';
        $data['stock'] = !empty($data['stock']) ? $data['stock'] : 0;
        $data['shipping_class_id'] = !empty($data['shipping_class_id']) ? $data['shipping_class_id'] : 0;
        $data['shipping_delivery_time_id'] = !empty($data['shipping_delivery_time_id']) ? $data['shipping_delivery_time_id'] : 0;
        $data['is_free_product'] = !empty($data['is_free_product']) ? 1 : 0;
        $data['country_id'] = !empty($data['country_id']) ? $data['country_id'] : 0;
        $data['state_id'] = !empty($data['state_id']) ? $data['state_id'] : 0;
        $data['city_id'] = !empty($data['city_id']) ? $data['city_id'] : 0;
        $data['address'] = !empty($data['address']) ? $data['address'] : '';
        $data['zip_code'] = !empty($data['zip_code']) ? $data['zip_code'] : '';
        if (inputPost('brand_id')) {
            $data['brand_id'] = !empty(inputPost('brand_id')) ? inputPost('brand_id') : 0;
        }
        //unset price if bidding system selected
        if ($this->generalSettings->bidding_system == 1) {
            $array['price'] = 0;
        }
        //validate sku
        $isSkuValid = true;
        if (!empty($data['sku'])) {
            $row = $this->builder->where('sku', removeSpecialCharacters($data['sku']))->where('id != ', clrNum($id))->where('user_id', clrNum(activeUserId()))->get()->getRow();
            if (!empty($row)) {
                $isSkuValid = false;
                $data['sku'] = '';
            }
        }
        if ($data['stock'] < 0) {
            $data['stock'] = 0;
        }
        if (inputPost('submit') == 'save_as_draft') {
            $data['is_draft'] = 1;
            $data['is_active'] = 0;
        } else {
            if ($this->generalSettings->approve_before_publishing == 0 || hasPermission('products')) {
                $data['status'] = 1;
                $data['is_active'] = 1;
            }
        }
        if ($this->builder->where('id', clrNum($id))->update($data)) {
            if ($isSkuValid == false) {
                setErrorMessage(trans("msg_error_sku"));
                return redirect()->back();
            }
            return true;
        }
        return false;
    }

    //edit product
    public function editProduct($product, $slug)
    {
        if (!empty($product)) {
            $data = [
                'product_type' => inputPost('product_type'),
                'listing_type' => inputPost('listing_type'),
                'slug' => $slug
            ];
            $data['category_id'] = getDropdownCategoryId();
            $data['is_sold'] = $product->is_sold;
            $data['visibility'] = $product->visibility;
            if ($product->is_draft != 1 && $product->status == 1) {
                $data['is_sold'] = inputPost('is_sold');
                $data['visibility'] = inputPost('visibility');
            }
            if (!empty($data['slug'])) {
                $data['slug'] = str_replace(' ', '-', $data['slug'] ?? '');
                $data['slug'] = removeSpecialCharacters($data['slug']);
                $data['slug'] = substr($data['slug'], 0, 200);
            }
            if ($data['is_sold'] == 1) {
                $data['stock'] = 0;
                $variations = $this->db->table('variations')->where('product_id', $product->id)->get()->getResult();
                if (!empty($variations)) {
                    foreach ($variations as $variation) {
                        $this->db->table('variation_options')->where('variation_id', $variation->id)->update(['stock' => 0]);
                    }
                }
            }
            return $this->builder->where('id', $product->id)->update($data);
        }
    }

    //update custom fields
    public function updateProductCustomFields($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $fieldModel = new FieldModel();
            $customFields = $fieldModel->getCustomFieldsByCategory($product->category_id);
            if (!empty($customFields)) {
                //delete previous custom field values
                $fieldModel->deleteFieldProductValuesByProductId($productId);
                foreach ($customFields as $customField) {
                    $inputValue = inputPost('field_' . $customField->id);
                    //add custom field values
                    if (!empty($inputValue)) {
                        if ($customField->field_type == 'checkbox') {
                            foreach ($inputValue as $key => $value) {
                                $data = [
                                    'field_id' => $customField->id,
                                    'product_id' => $productId,
                                    'product_filter_key' => $customField->product_filter_key
                                ];
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $value;
                                $this->db->table('custom_fields_product')->insert($data);
                            }
                        } else {
                            $data = [
                                'field_id' => $customField->id,
                                'product_id' => clrNum($productId),
                                'product_filter_key' => $customField->product_filter_key,
                            ];
                            if ($customField->field_type == 'radio_button' || $customField->field_type == 'dropdown') {
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $inputValue;
                            } else {
                                $data['field_value'] = $inputValue;
                                $data['selected_option_id'] = 0;
                            }
                            $this->db->table('custom_fields_product')->insert($data);
                        }
                    }
                }
            }
        }
    }

    //update slug
    public function updateSlug($id)
    {
        $product = $this->getProduct($id);
        if (!empty($product)) {
            if (empty($product->slug) || $product->slug == '-') {
                $data = ['slug' => $product->id];
            } else {
                if ($this->generalSettings->product_link_structure == 'id-slug') {
                    $data = ['slug' => $product->id . '-' . $product->slug];
                } else {
                    $data = ['slug' => $product->slug . '-' . $product->id];
                }
            }
            $pageModel = new PageModel();
            if (!empty($pageModel->checkPageSlugForProduct($data['slug']))) {
                $data['slug'] .= uniqid();
            }
            return $this->builder->where('id', $product->id)->update($data);
        }
    }

    //set base query
    public function setBaseQuery()
    {
        $this->builder->resetQuery();
        $this->builder->select("products.*,
            users.username AS user_username, users.role_id AS role_id, users.slug AS user_slug,
            (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clrNum(selectedLangId()) . " LIMIT 1) AS title,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC, images.id DESC LIMIT 1) AS image,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC, images.id DESC LIMIT 1 OFFSET 1) AS image_second,
            (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id) AS wishlist_count,
            (SELECT variations.id FROM variations WHERE products.id = variations.product_id LIMIT 1) AS has_variation");
        if (countItems($this->activeLanguages) > 1) {
            $this->builder->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clrNum(selectedLangId()) . " LIMIT 1) AS second_title");
        }
        $this->builder->join('users', 'users.id = products.user_id AND banned = 0');
    }

    //build sql query string
    public function buildQuery()
    {
        $this->setBaseQuery();
        if ($this->generalSettings->membership_plans_system == 1) {
            $this->builder->where('users.is_membership_plan_expired', 0);
        }
        $this->builder->where('users.vacation_mode', 0);
        if (authCheck()) {
            $this->select("(SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id AND wishlist.user_id = " . clrNum(user()->id) . ") AS is_in_wishlist");
        } else {
            $this->select("0 AS is_in_wishlist");
        }
        $this->where('products.is_active', 1);
        if ($this->generalSettings->show_sold_products != 1) {
            $this->builder->where('products.is_sold', 0);
        }
        $defaultLocation = Globals::$defaultLocation;
        if (!empty($defaultLocation->country_id)) {
            $this->builder->where('IF(products.country_id != 0, products.country_id, users.country_id) = ' . clrNum($defaultLocation->country_id));
        }
        if (!empty($defaultLocation->state_id)) {
            $this->builder->where('IF(products.state_id != 0, products.state_id, users.state_id) = ' . clrNum($defaultLocation->state_id));
        }
        if (!empty($defaultLocation->city_id)) {
            $this->builder->where('IF(products.city_id != 0, products.city_id, users.city_id) = ' . clrNum($defaultLocation->city_id));
        }
    }

    //load products
    public function loadProducts($objParams)
    {
        if ($objParams->arrayParams == null) {
            foreach ($_GET as $key => $value) {
                $objParams->arrayParams[$key] = $value;
            }
        }
        $perPage = $this->productSettings->pagination_per_page;
        $offset = ($objParams->pageNumber - 1) * $perPage;
        $langId = $objParams->langId;
        $search = '';
        $sort = '';
        $pMin = '';
        $pMax = '';
        $brand = '';
        $arrayFilterQueries = [];
        if (!empty($objParams->arrayParams) && countItems($objParams->arrayParams) > 0) {
            foreach ($objParams->arrayParams as $param => $value) {
                if (!empty($value)) {
                    if ($param == 'search') {
                        $search = removeSpecialCharacters($value);
                    } elseif ($param == 'sort') {
                        $sort = $value;
                    } elseif ($param == 'p_min') {
                        $pMin = $value;
                    } elseif ($param == 'p_max') {
                        $pMax = $value;
                    } elseif ($param == 'brand') {
                        $brand = $value;
                    } else {
                        if ($param != 'page' && $param != 'brand') {
                            if (!empty($objParams->customFilters)) {
                                foreach ($objParams->customFilters as $filter) {
                                    if ($filter->product_filter_key == $param) {
                                        $arrayValues = explode(',', $value);
                                        if (!empty($arrayValues) && countItems($arrayValues) > 0) {
                                            $arrayFilterQueries[] = $this->builderCustomFieldsProduct->join('custom_fields_options', 'custom_fields_options.id = custom_fields_product.selected_option_id')->select('product_id')
                                                ->where('custom_fields_product.field_id', $filter->id)->groupStart()->whereIn('custom_fields_options.option_key', $arrayValues)->groupEnd()->getCompiledSelect();
                                            $this->builderCustomFieldsProduct->resetQuery();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($this->selectedCurrency) && $this->selectedCurrency->id != $this->defaultCurrency->id) {
            if (!empty($pMin)) {
                $pMin = convertToDefaultCurrency($pMin, $this->selectedCurrency->code);
            }
            if (!empty($pMax)) {
                $pMax = convertToDefaultCurrency($pMax, $this->selectedCurrency->code);
            }
        }
        //set builder
        $this->buildQuery();
        //filter by category
        if (!empty($objParams->category)) {
            $this->builder->groupStart()->where('products.category_id', $objParams->category->id)->orWhere('products.category_id IN (SELECT id FROM (SELECT id, parent_tree FROM categories WHERE categories.visibility = 1 
            AND categories.tree_id = ' . clrNum($objParams->category->tree_id) . ') AS cat_tbl WHERE FIND_IN_SET(' . clrNum($objParams->category->id) . ', cat_tbl.parent_tree))')->groupEnd();
        }
        //filter by brand
        if (!empty($brand)) {
            $brandArray = explode(',', $brand);
            $brandArrayNew = array();
            if (!empty($brandArray) && is_array($brandArray)) {
                foreach ($brandArray as $item) {
                    $valInt = @intval($item);
                    if (!empty($valInt)) {
                        array_push($brandArrayNew, $valInt);
                    }
                }
            }
            if (!empty($brandArrayNew) && countItems($brandArrayNew) > 0) {
                $this->builder->whereIn('products.brand_id', $brandArrayNew, false);
            }
        }
        //filter by custom filters
        if (!empty($arrayFilterQueries)) {
            foreach ($arrayFilterQueries as $query) {
                $this->builder->where('products.id IN (' . $query . ')');
            }
        }
        //filter by price
        if (!empty($pMin) && $pMin >= 0) {
            $this->builder->where('price_discounted >=', intval($pMin * 100));
        }
        if (!empty($pMax) && $pMax > 0) {
            $this->builder->where('price_discounted <=', intval($pMax * 100));
        }
        //filter by vendor
        if (!empty($objParams->userId)) {
            $this->builder->where('products.user_id', clrNum($objParams->userId));
        }
        //filter by coupon
        if (!empty($objParams->couponId)) {
            $this->builder->where('products.id IN (SELECT product_id FROM coupon_products WHERE coupon_id = ' . clrNum($objParams->couponId) . ')');
        }
        //search
        if (!empty($search)) {
            $search = removeForbiddenCharacters($search);
            $escSearch = $this->db->escape($search);
            $this->builder->join('product_search_indexes psi', 'psi.product_id = products.id AND psi.lang_id = ' . clrNum($langId))
                ->where("MATCH(psi.search_index) AGAINST({$escSearch} IN NATURAL LANGUAGE MODE)");
        }
        //sort products
        if (!empty($sort) && $sort == 'lowest_price') {
            $this->builder->orderBy('price_discounted');
        } elseif (!empty($sort) && $sort == 'highest_price') {
            $this->builder->orderBy('price_discounted DESC');
        } elseif (!empty($sort) && $sort == 'highest_rating') {
            $this->builder->orderBy('rating DESC');
        } else {
            if (empty($search)) {
                if (empty($sort) && $this->productSettings->sort_by_featured_products == 1) {
                    $this->builder->orderBy('products.is_promoted DESC');
                }
                $this->builder->orderBy('products.id DESC');
            }
        }
        return $this->builder->limit($perPage + 1, $offset)->get()->getResult();
    }

    //get products
    public function getProducts($limit)
    {
        $key = 'products_limit_' . clrNum($limit);
        $products = getCacheProduct($key);
        if (!empty($products)) {
            return $products;
        }
        $this->buildQuery();
        $products = $this->builder->orderBy('products.id DESC')->get(clrNum($limit))->getResult();
        setCacheProduct($key, $products);
        return $products;
    }

    //get promoted products
    public function getPromotedProducts()
    {
        $this->buildQuery();
        return $this->builder->where('products.is_promoted', 1)->orderBy('products.promote_start_date', 'DESC')->get()->getResult();
    }

    //get promoted products limited
    public function getPromotedProductsLimited($perPage, $offset)
    {
        $key = 'promoted_products_' . $perPage . '_' . $offset;
        $products = getCacheProduct($key);
        if (!empty($products)) {
            return $products;
        }
        $this->buildQuery();
        $products = $this->builder->where('products.is_promoted', 1)->orderBy('products.promote_start_date DESC')->limit(clrNum($perPage) + 1, clrNum($offset))->get()->getResult();
        setCacheProduct($key, $products);
        return $products;
    }

    //check promoted products
    public function checkPromotedProducts()
    {
        $products = $this->builder->where('is_promoted', 1)->get()->getResult();
        if (!empty($products)) {
            foreach ($products as $item) {
                if (dateDifference($item->promote_end_date, date('Y-m-d H:i:s')) < 1) {
                    $this->builder->where('id', $item->id)->update(['is_promoted' => 0]);
                }
            }
        }
    }

    //get special offers
    public function getSpecialOffers()
    {
        $products = getCacheProduct('special_offers');
        if (!empty($products)) {
            return $products;
        }
        $this->buildQuery();
        $products = $this->builder->where('products.is_special_offer', 1)->orderBy('products.special_offer_date', 'DESC')->limit(20)->get()->getResult();
        setCacheProduct('special_offers', $products);
        return $products;
    }

    //get index categories products
    public function getIndexCategoriesProducts($categories)
    {
        $productsArray = getCacheProduct('index_category_products');
        if (!empty($productsArray)) {
            return $productsArray;
        }
        $productsArray = array();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if ($category->show_subcategory_products == 1) {
                    $this->buildQuery();
                    $productsArray[$category->id] = $this->builder->groupStart()->where("products.category_id IN (SELECT id FROM categories WHERE FIND_IN_SET(" . clrNum($category->id) . ", categories.parent_tree))")
                        ->orWhere("products.category_id", clrNum($category->id))->groupEnd()->orderBy('products.id', 'DESC')->get(NUM_INDEX_CATEGORY_PRODUCTS)->getResult();
                } else {
                    $this->buildQuery();
                    $productsArray[$category->id] = $this->builder->where('products.category_id', clrNum($category->id), false)->orderBy('products.id', 'DESC')->get(NUM_INDEX_CATEGORY_PRODUCTS)->getResult();
                }
            }
        }
        setCacheProduct('index_category_products', $productsArray);
        return $productsArray;
    }

    //get related products
    public function getRelatedProducts($productId, $categoryId)
    {
        $key = 'related_products_' . $productId;
        $products = getCacheProduct($key);
        if (!empty($products)) {
            return $products;
        }
        $this->buildQuery();
        $products = $this->builder->where('products.category_id', clrNum($categoryId))->where('products.id !=', clrNum($productId))->get(100)->getResult();
        setCacheProduct($key, $products);
        return $products;
    }

    //get more products by user
    public function getMoreProductsByUser($userId, $productId)
    {
        $key = 'more_products_by_vendor_' . $userId;
        $products = getCacheProduct($key);
        if (!empty($products)) {
            return $products;
        }
        $this->buildQuery();
        $products = $this->builder->where('users.id', clrNum($userId))->where('products.id != ', clrNum($productId))->orderBy('products.id DESC')->get(6)->getResult();
        setCacheProduct($key, $products);
        return $products;
    }

    //get user wishlist products count
    public function getUserWishlistProductsCount($userId)
    {
        $this->buildQuery();
        $this->builder->join('wishlist', 'products.id = wishlist.product_id');
        return $this->builder->where('wishlist.user_id', clrNum($userId))->countAllResults();
    }

    //get user wishlist products
    public function getPaginatedUserWishlistProducts($userId, $perPage, $offset)
    {
        $this->buildQuery();
        $this->builder->join('wishlist', 'products.id = wishlist.product_id');
        return $this->builder->where('wishlist.user_id', clrNum($userId))->orderBy('products.id DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get guest wishlist products count
    public function getGuestWishlistProductsCount()
    {
        $wishlist = helperGetSession('mds_guest_wishlist');
        if (!empty($wishlist) && countItems($wishlist) > 0) {
            $this->buildQuery();
            return $this->builder->whereIn('products.id', $wishlist, FALSE)->countAllResults();
        }
        return 0;
    }

    //get guest wishlist products
    public function getGuestWishlistProductsPaginated($perPage, $offset)
    {
        $wishlist = helperGetSession('mds_guest_wishlist');
        if (!empty($wishlist) && countItems($wishlist) > 0) {
            $this->buildQuery();
            return $this->builder->whereIn('products.id', $wishlist, FALSE)->orderBy('products.id DESC')->limit($perPage, $offset)->get()->getResult();
        }
        return array();
    }

    //get downloadable product
    public function getDownloadableProduct($id)
    {
        $this->setBaseQuery();
        return $this->builder->where('products.id', clrNum($id))->get()->getRow();
    }

    //get user downloads count
    public function getUserDownloadsCount($userId)
    {
        return $this->builderDigitalSales->where('buyer_id', clrNum($userId))->countAllResults();
    }

    //get paginated downloads
    public function getUserDownloadsPaginated($userId, $perPage, $offset)
    {
        return $this->builderDigitalSales->where('buyer_id', clrNum($userId))->orderBy('purchase_date DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get digital sale
    public function getDigitalSale($saleId)
    {
        return $this->builderDigitalSales->where('id', clrNum($saleId))->get()->getRow();
    }

    //get digital sale by buyer id
    public function getDigitalSaleByBuyerId($buyerId, $productId)
    {
        return $this->builderDigitalSales->where('buyer_id', clrNum($buyerId))->where('product_id', clrNum($productId))->get()->getRow();
    }

    //get digital sale by order id
    public function getDigitalSaleByOrderId($buyerId, $productId, $orderId)
    {
        return $this->builderDigitalSales->where('buyer_id', clrNum($buyerId))->where('product_id', clrNum($productId))->where('order_id', clrNum($orderId))->get()->getRow();
    }

    //get product by id
    public function getProduct($id)
    {
        $this->builder->select("products.*, 
        (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clrNum(selectedLangId()) . " LIMIT 1) AS title");
        if (countItems($this->activeLanguages) > 1) {
            $this->builder->select('(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != ' . clrNum(selectedLangId()) . ' LIMIT 1) AS second_title');
        }
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    //get available product
    public function getActiveProduct($id)
    {
        $this->buildQuery();
        return $this->builder->where('products.id', clrNum($id))->get()->getRow();
    }

    //get product by slug
    public function getProductBySlug($slug)
    {
        if ($this->generalSettings->membership_plans_system == 1) {
            $this->builder->join('users', 'products.user_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        } else {
            $this->builder->join('users', 'products.user_id = users.id AND users.banned = 0');
        }
        $this->builder->where('users.vacation_mode', 0);
        $this->builder->select('products.*, users.username as user_username, users.role_id as user_role, users.slug as user_slug,
              (SELECT name_data FROM brands WHERE products.brand_id = brands.id) AS brand_name_data')
            ->where('products.slug', strSlug($slug))->where('products.is_draft', 0)->where('products.is_deleted', 0);
        if ($this->generalSettings->show_sold_products != 1) {
            $this->builder->where('products.is_sold', 0);
        }
        if ($this->generalSettings->vendor_verification_system == 1) {
            $this->builder->where('users.role_id != ', 'member');
        }
        return $this->builder->get()->getRow();
    }

    //get product details
    public function getProductDetails($id, $langId, $getMainOnNull = true)
    {
        $row = $this->builderProductDetails->where('product_id', clrNum($id))->where('lang_id', clrNum($langId))->get()->getRow();
        if ((empty($row) || empty($row->title)) && $getMainOnNull == true) {
            $row = $this->builderProductDetails->where('product_id', clrNum($id))->limit(1)->get()->getRow();
        }
        return $row;
    }

    //is product in wishlist
    public function isProductInWishlist($productId)
    {
        if (authCheck()) {
            if (!empty($this->builderWishlist->where('user_id', user()->id)->where('product_id', clrNum($productId))->get()->getRow())) {
                return true;
            }
        } else {
            $wishlist = $this->session->get('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($productId, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }

    //get product wishlist count
    public function getProductWishlistCount($productId)
    {
        return $this->builderWishlist->where('product_id', clrNum($productId))->countAllResults();
    }

    //add remove wishlist
    public function addRemoveWishlist($productId)
    {
        if (authCheck()) {
            if ($this->isProductInWishlist($productId)) {
                $this->builderWishlist->where('user_id', user()->id)->where('product_id', clrNum($productId))->delete();
            } else {
                $data = [
                    'user_id' => user()->id,
                    'product_id' => clrNum($productId)
                ];
                $this->builderWishlist->insert($data);
            }
        } else {
            if ($this->isProductInWishlist($productId)) {
                $wishlist = array();
                if (!empty(helperGetSession('mds_guest_wishlist'))) {
                    $wishlist = helperGetSession('mds_guest_wishlist');
                }
                $new = array();
                if (!empty($wishlist)) {
                    foreach ($wishlist as $item) {
                        if ($item != clrNum($productId)) {
                            array_push($new, $item);
                        }
                    }
                }
                helperSetSession('mds_guest_wishlist', $new);
            } else {
                $wishlist = array();
                if (!empty(helperGetSession('mds_guest_wishlist'))) {
                    $wishlist = helperGetSession('mds_guest_wishlist');
                }
                array_push($wishlist, clrNum($productId));
                helperSetSession('mds_guest_wishlist', $wishlist);
            }
        }
    }

    //get vendor total pageviews count
    public function getVendorTotalPageviewsCount($userId)
    {
        return $this->builder->select('SUM(products.pageviews) as total_pageviews')->where('status', 1)->where('products.is_draft', 0)
            ->where('products.is_deleted', 0)->where('products.user_id', clrNum($userId))->get()->getRow()->total_pageviews;
    }

    //increase product pageviews
    public function increaseProductPageviews($product)
    {
        if (!empty($product)) {
            if (empty(helperGetSession('pr_' . $product->id))) {
                helperSetSession('pr_' . $product->id, '1');
                $this->builder->where('id', $product->id)->update(['pageviews' => $product->pageviews + 1]);
            }
        }
    }

    //get rss products by category
    public function getRssProductsByCategory($categoryId)
    {
        $categoryModel = new CategoryModel();
        $categoryIds = $categoryModel->getSubCategoriesTreeIds($categoryId, true);
        if (empty($categoryIds) || countItems($categoryIds) < 1) {
            return array();
        }
        $this->buildQuery();
        return $this->builder->whereIn('products.category_id', $categoryIds, FALSE)->orderBy('products.id DESC')->get()->getResult();
    }

    //get rss products by user
    public function getRssProductsByUser($userId)
    {
        $this->buildQuery();
        return $this->builder->where('users.id', clrNum($userId))->orderBy('products.id DESC')->get()->getResult();
    }

    //get products
    public function getSitemapProducts()
    {
        $this->buildQuery();
        return $this->builder->orderBy('products.id')->get()->getResult();
    }

    /*
     * --------------------------------------------------------------------
     * Dashboard
     * --------------------------------------------------------------------
     */

    //get user products count
    public function getUserTotalProductsCount($userId)
    {
        $cacheKey = 'vendor_products_count_' . $userId;
        $count = getCacheData($cacheKey);
        if (!empty($count)) {
            return $count;
        }
        $this->setBaseQuery();
        $count = $this->builder->where('users.id', clrNum($userId))->where('products.is_draft', 0)->where('products.is_deleted', 0)->countAllResults();
        setCacheData($cacheKey, $count);
        return $count;
    }

    //get vendor products count
    public function getVendorProductsCount($userId, $listType)
    {
        $this->filterUserProducts($listType);
        return $this->builder->where('users.id', clrNum($userId))->countAllResults();
    }

    //get vendor products
    public function getVendorProductsPaginated($userId, $listType, $perPage, $offset)
    {
        $this->filterUserProducts($listType);
        return $this->builder->where('users.id', clrNum($userId))->limit($perPage, $offset)->get()->getResult();
    }

    //get vendor products coupon count
    public function getVendorProductsCouponCount($userId)
    {
        $this->filterUserProducts('active');
        return $this->builder->where('products.user_id', clrNum($userId))->countAllResults();
    }

    //get vendor products coupon
    public function getVendorProductsCouponPaginated($userId, $couponId, $perPage, $offset)
    {
        $this->filterUserProducts('active');
        $this->builder->select('(SELECT coupon_products.id FROM coupon_products WHERE products.id = coupon_products.product_id AND coupon_products.coupon_id = ' . clrNum($couponId) . ' LIMIT 1) AS is_selected');
        return $this->builder->where('products.user_id', clrNum($userId))->limit($perPage, $offset)->get()->getResult();
    }

    //get vendor products export
    public function getVendorProductsExport($userId, $listType)
    {
        $this->filterUserProducts($listType, 'POST');
        return $this->builder->select("(SELECT GROUP_CONCAT(storage, ':::', image_big) FROM images WHERE images.product_id = products.id) AS images_big")
            ->select('(SELECT CONCAT(short_description, ":::", description)  FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = ' . clrNum($this->activeLang->id) . ' LIMIT 1) AS product_content')
            ->select('(SELECT name FROM categories_lang WHERE products.category_id = categories_lang.category_id AND categories_lang.lang_id = '.clrNum($this->activeLang->id).' LIMIT 1) AS category_name')
            ->where('users.id', clrNum($userId))->get()->getResult();
    }

    //filter user products
    public function filterUserProducts($listType, $formMethod = 'GET')
    {
        $listingType = inputGet('listing_type');
        $productType = inputGet('product_type');
        $productType = inputGet('product_type');
        $category = clrNum(inputGet('category'));
        $subCategory = clrNum(inputGet('subcategory'));
        $stock = inputGet('stock');
        $q = removeSpecialCharacters(inputGet('q'));
        if ($formMethod == 'POST') {
            $listingType = inputPost('listing_type');
            $productType = inputPost('product_type');
            $productType = inputPost('product_type');
            $category = clrNum(inputPost('category'));
            $subCategory = clrNum(inputPost('subcategory'));
            $stock = inputPost('stock');
            $q = removeSpecialCharacters(inputPost('q'));
        }

        $categoryIds = array();
        $categoryId = $category;
        if (!empty($subCategory)) {
            $categoryId = $subCategory;
        }
        $categoryModel = new CategoryModel();
        if (!empty($categoryId)) {
            $categoryIds = $categoryModel->getSubCategoriesTreeIds($categoryId, true);
        }
        $this->setBaseQuery();
        $this->builder->where('products.is_deleted', 0);

        //$this->builder->where('products.status', $status)->where('products.visibility', $visibility)->where('products.is_draft', $isDraft)->where('products.is_deleted', 0);
        if ($listType == 'pending') {
            $this->builder->where('products.status', 0)->where('products.is_draft', 0);
        } elseif ($listType == 'draft') {
            $this->builder->where('products.is_draft', 1);
        } elseif ($listType == 'hidden') {
            $this->builder->where('products.visibility', 0)->where('products.is_draft', 0);
        } elseif ($listType == 'sold') {
            $this->builder->where('products.is_sold', 1);
        } else {
            $this->builder->where('products.status', 1)->where('products.is_draft', 0)->where('products.visibility', 1)->where('products.is_sold', 0);
        }
        if ($listingType == 'sell_on_site' || $listingType == 'ordinary_listing' || $listingType == 'bidding' || $listingType == 'license_key') {
            $this->builder->where('products.listing_type', $listingType);
        }
        if ($productType == 'physical' || $productType == 'digital') {
            $this->builder->where('products.product_type', $productType);
        }
        if (!empty($categoryIds)) {
            $this->builder->whereIn("products.category_id", $categoryIds, FALSE);
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
        if (!empty($q)) {
            $search = removeForbiddenCharacters($q);
            $escSearch = $this->db->escape($search);
            $this->builder->join('product_search_indexes psi', 'psi.product_id = products.id AND psi.lang_id = ' . selectedLangId())
                ->where("MATCH(psi.search_index) AGAINST({$escSearch} IN NATURAL LANGUAGE MODE)");
        }
        $this->builder->select("(SELECT GROUP_CONCAT(lang_id, '" . CAT_QUERY_SEPARATOR_SUB . "', name SEPARATOR '" . CAT_QUERY_SEPARATOR . "') FROM categories_lang WHERE categories_lang.category_id = products.category_id) AS category_name");
        if (empty($q)) {
            $this->builder->orderBy('products.id DESC');
        }
    }

    /*
     * --------------------------------------------------------------------
     * Tags & Search Indexes
     * --------------------------------------------------------------------
     */

    //update search index
    public function updateSearchIndex($productId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $rows = $this->builderProductDetails->where('product_id', $product->id)->get()->getResult();
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $index = removeSpecialCharacters($row->title);
                    if (!empty($index)) {
                        $index = str_replace(['&', ',', '-', '_'], ' ', $index);
                        $index = preg_replace('/\s+/', ' ', $index);
                        $index = mb_strtolower($index, 'UTF-8');
                        //add tags
                        $tagsStr = $this->getProductTagsString($product, $row->lang_id);
                        if (!empty($tagsStr)) {
                            $tagsStr = str_replace(['&', ',', '-', '_'], ' ', $tagsStr);
                            $tagsStr = preg_replace('/\s+/', ' ', $tagsStr);
                            $index .= ' ' . $tagsStr;
                        }
                        //filter index
                        $indexFiltered = '';
                        if (!empty($index)) {
                            $wordsArray = explode(' ', $index);
                            $uniqueWordsArray = array_unique($wordsArray);
                            $indexFiltered = implode(' ', $uniqueWordsArray);
                        }
                        if (!empty($product->sku)) {
                            $indexFiltered .= ' ' . $product->sku;
                        }
                        //add or update
                        $result = $this->builderSearchIndexes->where('product_id', $row->product_id)->where('lang_id', $row->lang_id)->get()->getRow();
                        if (!empty($result)) {
                            $this->builderSearchIndexes->where('id', $result->id)->update(['search_index' => $indexFiltered]);
                        } else {
                            $data = [
                                'product_id' => $row->product_id,
                                'lang_id' => $row->lang_id,
                                'search_index' => $indexFiltered
                            ];
                            $this->builderSearchIndexes->insert($data);
                        }
                    }
                }
            }
        }
    }

    //get product tags string
    public function getProductTagsString($product, $langId)
    {
        $tagsStr = '';
        $tagsArray = [];
        if (!empty($product)) {
            $result = $this->builderTags->where('product_id', $product->id)->where('lang_id', clrNum($langId))->get()->getResult();
            if (!empty($result)) {
                foreach ($result as $item) {
                    array_push($tagsArray, $item->tag);
                }
            }
        }
        if (!empty($tagsArray) && countItems($tagsArray) > 0) {
            $tagsStr = implode(',', $tagsArray);
        }
        return $tagsStr;
    }

    //add or update product tags
    private function addUpdateProductTags($productId, $langId)
    {
        $product = $this->getProduct($productId);
        if (!empty($product)) {
            $tagsStr = $this->getProductTagsString($product, $langId);
            $newTagsStr = '';
            $tagsInput = inputPost('tags_' . $langId);
            $tags = [];
            if (!empty($tagsInput)) {
                $tagsArray = explode(',', $tagsInput);
                if (!empty($tagsArray) && countItems($tagsArray) > 0) {
                    $tagsArray = array_slice($tagsArray, 0, PRODUCT_TAG_LIMIT);
                    foreach ($tagsArray as $item) {
                        if (!empty($item)) {
                            $item = removeSpecialCharacters($item);
                            if (!empty($item)) {
                                $item = mb_strtolower($item, 'UTF-8');
                            }
                            if (!empty($item) && strlen($item) > 1 && !in_array($item, $tags)) {
                                array_push($tags, $item);
                            }
                        }
                    }
                }
            }
            if (!empty($tags) && countItems($tags) > 0) {
                $newTagsStr = implode(',', $tags);
            }
            if ($tagsStr != $newTagsStr) {
                //delete old tags
                $this->builderTags->where('product_id', clrNum($productId))->where('lang_id', clrNum($langId))->delete();
                //add new tags
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        if (!empty($tag)) {
                            $tag = strlen($tag) > PRODUCT_TAG_CHAR_LIMIT ? substr($tag, 0, PRODUCT_TAG_CHAR_LIMIT) : $tag;
                            $data = [
                                'product_id' => clrNum($productId),
                                'lang_id' => clrNum($langId),
                                'tag' => $tag,
                            ];
                            $this->builderTags->insert($data);
                        }
                    }
                }
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * License Key
     * --------------------------------------------------------------------
     */

    //add license keys
    public function addLicenseKeys($productId)
    {
        $licenseKeys = inputPost('license_keys');
        $allowDuplicate = inputPost('allow_duplicate');
        $licenseKeysArray = explode(',', $licenseKeys ?? '');
        if (!empty($licenseKeysArray)) {
            foreach ($licenseKeysArray as $licenseKey) {
                $licenseKey = trim($licenseKey);
                if (!empty($licenseKey)) {
                    //check duplicate
                    $addKey = true;
                    if (empty($allowDuplicate)) {
                        if (!empty($this->checkLicenseKey($productId, $licenseKey))) {
                            $addKey = false;
                        }
                    }
                    //add license key
                    if ($addKey) {
                        $data = [
                            'product_id' => $productId,
                            'license_key' => trim($licenseKey ?? ''),
                            'is_used' => 0
                        ];
                        $this->builderProductLicenseKeys->insert($data);
                    }
                }
            }
        }
    }

    //get license keys
    public function getProductLicenseKeys($productId)
    {
        return $this->builderProductLicenseKeys->where('product_id', clrNum($productId))->get()->getResult();
    }

    //get license key
    public function getLicenseKey($id)
    {
        return $this->builderProductLicenseKeys->where('id', clrNum($id))->get()->getRow();
    }

    //get unused license key
    public function getUnusedLicenseKey($productId)
    {
        return $this->builderProductLicenseKeys->where('product_id', clrNum($productId))->where('is_used = 0')->get()->getRow();
    }

    //check license key
    public function checkLicenseKey($productId, $licenseKey)
    {
        return $this->builderProductLicenseKeys->where('product_id', clrNum($productId))->where('license_key', $licenseKey)->get()->getRow();
    }

    //set license key used
    public function setLicenseKeyUsed($id)
    {
        $this->builderProductLicenseKeys->where('id', clrNum($id))->update(['is_used' => 1]);
    }

    //delete license key
    public function deleteLicenseKey($id)
    {
        $licenseKey = $this->getLicenseKey($id);
        if (!empty($licenseKey)) {
            return $this->builderProductLicenseKeys->where('id', $licenseKey->id)->delete();
        }
        return false;
    }
}