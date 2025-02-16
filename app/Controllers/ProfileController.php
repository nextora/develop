<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CouponModel;
use App\Models\EarningsModel;
use App\Models\LocationModel;
use App\Models\ProfileModel;

class ProfileController extends BaseController
{
    protected $profileModel;
    protected $earningsModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->profileModel = new ProfileModel();
        $this->earningsModel = new EarningsModel();
    }

    /**
     * Profile
     */
    public function profile($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }

        if (isVendor($data['user'])) {
            $data['title'] = getUsername($data['user']);
            $data['description'] = getUsername($data['user']) . ' - ' . $this->baseVars->appName;
            $data['keywords'] = getUsername($data['user']) . ',' . $this->baseVars->appName;
            $data['showOgTags'] = true;
            $data['ogTitle'] = $data['title'];
            $data['ogDescription'] = $data['description'];
            $data['ogType'] = 'article';
            $data['ogUrl'] = generateProfileUrl($data['user']->slug);
            $data['ogImage'] = getUserAvatar($data['user']);
            $data['ogWidth'] = '200';
            $data['ogHeight'] = '200';
            $data['ogCreator'] = $data['title'];
            $data['userRating'] = calculateUserRating($data['user']->id);
            $data['queryStringArray'] = getQueryStringArray(null);
            $data['queryStringObjectArray'] = convertQueryStringToObjectArray($data['queryStringArray']);
            $data['category'] = null;
            $data['parentCategory'] = null;
            $categoryId = inputGet('p_cat');
            if (!empty($categoryId)) {
                $data['category'] = $this->categoryModel->getCategory($categoryId);
                if (!empty($data['category']) && $data['category']->parent_id != 0) {
                    $data['parentCategory'] = $this->categoryModel->getCategory($data['category']->parent_id);
                }
            }
            $data['categories'] = $this->categoryModel->getVendorCategoriesTree($data['user']->id, $data['category'], true, true);
            
            $data['coupon'] = null;
            $couponId = null;
            if (!empty(inputGet('v_coupon'))) {
                $coupon = getCouponByCode(inputGet('v_coupon'));
                if (!empty($coupon) && $coupon->seller_id == $data['user']->id) {
                    $data['coupon'] = $coupon;
                    $couponId = $coupon->id;
                }
            }
            $data['activeTab'] = 'products';
            $objParams = new \stdClass();
            $objParams->pageNumber = getValidPageNumber(inputGet('page'));
            $objParams->category = $data['category'];
            $objParams->userId = $data['user']->id;;
            $objParams->customFilters = null;
            $objParams->arrayParams = null;
            $objParams->couponId = $couponId;
            $objParams->langId = selectedLangId();
            $data['products'] = $this->productModel->loadProducts($objParams);

            echo view('partials/_header', $data);
            echo view('profile/profile', $data);
            echo view('partials/_footer');
        } else {
            $this->followers($slug);
        }
    }

    /**
     * Followers
     */
    public function followers($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' - ' . trans("followers");
        $data['description'] = getUsername($data['user']) . ' - ' . trans("followers") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' - ' . trans("followers") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'followers';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['followers'] = $this->profileModel->getFollowers($data['user']->id);

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Following
     */
    public function following($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' - ' . trans("following");
        $data['description'] = getUsername($data['user']) . ' - ' . trans("following") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' - ' . trans("following") . ',' . $this->baseVars->appName;
        $data['activeTab'] = "following";
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['followers'] = $this->profileModel->getFollowedUsers($data['user']->id);

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Reviews
     */
    public function reviews($slug)
    {
        if ($this->generalSettings->reviews != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user']) || !isVendor($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' - ' . trans("reviews");
        $data['description'] = getUsername($data['user']) . ' - ' . trans("reviews") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' - ' . trans("reviews") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'reviews';
        $data['userRating'] = calculateUserRating($data['user']->id);
        
        $numRows = $this->commonModel->getVendorReviewsCount($data['user']->id);
        $data['pager'] = paginate($this->baseVars->perPage, $numRows);
        $data['reviews'] = $this->commonModel->getVendorReviewsPaginated($data['user']->id, $this->baseVars->perPage, $data['pager']->offset);

        echo view('partials/_header', $data);
        echo view('profile/reviews', $data);
        echo view('partials/_footer');
    }

    /**
     * My Reviews
     */
    public function myReviews($slug)
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->generalSettings->reviews != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user']) || $data['user']->id != user()->id) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' - ' . trans("my_reviews");
        $data['description'] = getUsername($data['user']) . ' - ' . trans("my_reviews") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' - ' . trans("my_reviews") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'my_reviews';
        $data['userRating'] = calculateUserRating($data['user']->id);
        
        $data['numRows'] = $this->commonModel->getMyReviewsCount(user()->id);
        $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
        $data['reviews'] = $this->commonModel->getMyReviewsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);

        echo view('partials/_header', $data);
        echo view('profile/my_reviews', $data);
        echo view('partials/_footer');
    }

    /**
     * Shop Policies
     */
    public function shopPolicies($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' - ' . trans("shop_policies");
        $data['description'] = getUsername($data['user']) . ' - ' . trans("shop_policies") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' - ' . trans("shop_policies") . ',' . $this->baseVars->appName;
        $data['activeTab'] = "shop_policies";
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['pages'] = $this->pageModel->getVendorPagesByUserId($data['user']->id);
        if (empty($data['pages']) || $data['pages']->status_shop_policies != 1) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('profile/shop_policies', $data);
        echo view('partials/_footer');
    }

    /**
     * Wallet
     */
    public function wallet()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("wallet");
        $data['description'] = trans("wallet") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("wallet") . ',' . $this->baseVars->appName;

        $data['activeTab'] = 'earnings';
        $tab = inputGet('tab');
        if ($tab == 'referral-earnings') {
            if ($this->generalSettings->affiliate_status != 1) {
                return redirect()->to(langBaseUrl());
            }
            $data['activeTab'] = 'referral_earnings';
            $data['numRows'] = $this->earningsModel->getReferralEarningsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['earnings'] = $this->earningsModel->getReferralEarningsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'deposits') {
            $data['activeTab'] = 'deposits';
            $data['numRows'] = $this->earningsModel->getDepositsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['deposits'] = $this->earningsModel->getPaginatedDeposits($this->baseVars->perPage, $data['pager']->offset, user()->id);
        } elseif ($tab == 'expenses') {
            $data['activeTab'] = 'expenses';
            $data['numRows'] = $this->earningsModel->getExpensesCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['expenses'] = $this->earningsModel->getExpensesPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'payouts') {
            $data['activeTab'] = 'payouts';
            $data['numRows'] = $this->earningsModel->getPayoutsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['payouts'] = $this->earningsModel->getPaginatedPayouts(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'set-payout-account') {
            $data['activeTab'] = 'set_payout_account';
            $data['userPayout'] = $this->earningsModel->getUserPayoutAccount(user()->id);
            $data['payoutTab'] = '';
            $payoutOptions = getActivePayoutOptions();
            $payout = inputGet('payout');
            if (!empty($payout) && in_array($payout, $payoutOptions)) {
                $data['payoutTab'] = $payout;
            }
            if (empty($data['payoutTab']) && !empty($payoutOptions) && !empty($payoutOptions[0])) {
                $data['payoutTab'] = $payoutOptions[0];
            }
        } else {
            if (!isVendor()) {
                return redirect()->to(generateUrl('wallet') . '?tab=referral-earnings');
            }
            $data['numRows'] = $this->earningsModel->getEarningsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['earnings'] = $this->earningsModel->getEarningsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        }

        echo view('partials/_header', $data);
        echo view('wallet/wallet', $data);
        echo view('partials/_footer');
    }

    /**
     * Add Funds Post
     */
    public function addFundsPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->paymentSettings->wallet_deposit != 1) {
            return redirect()->to(langBaseUrl());
        }
        $amount = inputPost('amount');
        if (empty($amount)) {
            setErrorMessage(trans("invalid_attempt"));
            redirectToBackUrl();
        }
        if (!is_numeric($amount)) {
            setErrorMessage(trans("invalid_attempt"));
            redirectToBackUrl();
        }

        $amount = convertToDefaultCurrency($amount, $this->selectedCurrency->code, false);
        $serviceData = new \stdClass();
        $serviceData->paymentType = 'add_funds';
        $serviceData->paymentName = trans("add_funds");
        $serviceData->paymentAmountBeforeTaxes = $amount;
        $serviceData->paymentAmount = $amount;
        $serviceData->currency = $this->defaultCurrency->code;
        helperSetSession('mds_service_payment', $serviceData);

        return redirect()->to(generateUrl('cart', 'payment_method') . '?payment_type=service');
    }

    /**
     * New Payout Request Post
     */
    public function newPayoutRequestPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data = [
            'user_id' => user()->id,
            'payout_method' => inputPost('payout_method'),
            'amount' => inputPost('amount'),
            'currency' => inputPost('currency'),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $data['amount'] = getPrice($data['amount'], 'database');
        //check active payouts
        $activePayouts = $this->earningsModel->getActivePayouts(user()->id);
        if (!empty($activePayouts)) {
            setErrorMessage(trans("active_payment_request_error"));
            redirectToBackUrl();
        }
        $min = 0;
        if ($data['payout_method'] == 'paypal') {
            //check PayPal email
            $payoutPaypalEmail = $this->earningsModel->getUserPayoutAccount(user()->id);
            if (empty($payoutPaypalEmail) || empty($payoutPaypalEmail->payout_paypal_email)) {
                setErrorMessage(trans("msg_payout_paypal_error"));
                redirectToBackUrl();
            }
            $min = $this->paymentSettings->min_payout_paypal;
        }
        if ($data['payout_method'] == 'bitcoin') {
            //check bitcoin address
            $payoutBitcoin = $this->earningsModel->getUserPayoutAccount(user()->id);
            if (empty($payoutBitcoin) || empty($payoutBitcoin->payout_bitcoin_address)) {
                setErrorMessage(trans("msg_payout_bitcoin_address_error"));
                redirectToBackUrl();
            }
            $min = $this->paymentSettings->min_payout_bitcoin;
        }
        if ($data['payout_method'] == 'iban') {
            $min = $this->paymentSettings->min_payout_iban;
        }
        if ($data['payout_method'] == 'swift') {
            $min = $this->paymentSettings->min_payout_swift;
        }
        if ($data['amount'] <= 0) {
            setErrorMessage(trans("msg_error"));
            redirectToBackUrl();
        }
        if ($data['amount'] < $min) {
            setErrorMessage(trans("invalid_withdrawal_amount"));
            redirectToBackUrl();
        }
        if ($data['amount'] > user()->balance) {
            setErrorMessage(trans("invalid_withdrawal_amount"));
            redirectToBackUrl();
        }
        if ($this->earningsModel->withdrawMoney($data)) {
            setSuccessMessage(trans("msg_request_sent"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Set Payout Account Post
     */
    public function setPayoutAccountPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $submit = inputPost('submit');
        if ($this->earningsModel->setPayoutAccount(user()->id, $submit)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('wallet') . '?tab=set-payout-account&payout=' . strSlug($submit));
    }

    /**
     * My Coupons
     */
    public function myCoupons()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("my_coupons");
        $data['description'] = trans("my_coupons") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("my_coupons") . ',' . $this->baseVars->appName;
        $model = new CouponModel();
        $data['numRows'] = $model->getCouponsCount(true);
        $data['pager'] = paginate(24, $data['numRows']);
        $data['coupons'] = $model->getCouponsPaginated(24, $data['pager']->offset, true);

        echo view('partials/_header', $data);
        echo view('profile/my_coupons', $data);
        echo view('partials/_footer');
    }

    /**
     * Update Profile
     */
    public function editProfile()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("update_profile") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'edit_profile';
        
        echo view('partials/_header', $data);
        echo view('settings/edit_profile', $data);
        echo view('partials/_footer');
    }

    /**
     * Update Profile Post
     */
    public function editProfilePost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $action = inputPost('submit');
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[255]');
        $val->setRule('slug', trans("slug"), 'required|max_length[255]');
        $val->setRule('first_name', trans("first_name"), 'required|max_length[255]');
        $val->setRule('last_name', trans("last_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $data = [
                'slug' => strSlug(inputPost('slug')),
                'email' => inputPost('email'),
                'first_name' => inputPost('first_name'),
                'last_name' => inputPost('last_name'),
                'phone_number' => inputPost('phone_number'),
                'tax_registration_number' => inputPost('tax_registration_number'),
                'send_email_new_message' => inputPost('send_email_new_message'),
                'cover_image_type' => inputPost('cover_image_type'),
                'show_email' => inputPost('show_email'),
                'show_phone' => inputPost('show_phone')
            ];
            //is email unique
            if (!$this->authModel->isEmailUnique($data['email'], user()->id)) {
                setErrorMessage(trans("msg_email_unique_error"));
                return redirect()->to(generateUrl('settings', 'edit_profile'));
            }
            //is slug unique
            if (!$this->authModel->isSlugUnique($data['slug'], user()->id)) {
                setErrorMessage(trans("msg_slug_unique_error"));
                return redirect()->to(generateUrl('settings', 'edit_profile'));
            }
            if ($this->profileModel->editProfile($data, user()->id)) {
                setSuccessMessage(trans("msg_updated"));
            } else {
                setErrorMessage(trans("msg_error"));
            }
            return redirect()->to(generateUrl('settings', 'edit_profile'));
        }
    }

    //delete cover image
    public function deleteCoverImagePost()
    {
        $this->authModel->deleteCoverImage();
    }

    /**
     * Location
     */
    public function location()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("location");
        $data['description'] = trans("location") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("location") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'location';
        $locationModel = new LocationModel();
        if (!empty(user()->country_id)) {
            $data['states'] = $locationModel->getStatesByCountry(user()->country_id);
        }
        if (!empty(user()->state_id)) {
            $data['cities'] = $locationModel->getCitiesByState(user()->state_id);
        }
        
        echo view('partials/_header', $data);
        echo view('settings/location', $data);
        echo view('partials/_footer');
    }

    /**
     * Location Post
     */
    public function locationPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $paramCart = '';
        $paymentType = inputPost('payment_type');
        if (!empty($paymentType)) {
            $paramCart = '?payment_type=' . $paymentType;
        }
        $val = \Config\Services::validation();
        $val->setRule('country_id', trans("country"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(generateUrl('settings', 'location') . $paramCart)->withInput();
        } else {
            if ($this->profileModel->updateLocation()) {
                setSuccessMessage(trans("msg_updated"));
            } else {
                setErrorMessage(trans("msg_error"));
            }
        }
        if (!empty($paymentType)) {
            if ($paymentType == 'sale' || $paymentType == 'service') {
                $cartModel = new CartModel();
                $cartModel->setCartCustomerLocation();
                return redirect()->to(generateUrl('cart', 'payment_method') . '?payment_type=' . $paymentType);
            }
        }
        return redirect()->to(generateUrl('settings', 'location'));
    }

    /**
     * Shipping Address
     */
    public function shippingAddress()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("shipping_address");
        $data['description'] = trans("shipping_address") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("shipping_address") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'shipping_address';
        $data['shippingAddresses'] = $this->profileModel->getShippingAddresses(user()->id);
        $data['states'] = $this->locationModel->getStatesByCountry(1);
        
        echo view('partials/_header', $data);
        echo view('settings/shipping_address', $data);
        echo view('partials/_footer');
    }

    /**
     * Add Shipping Address Post
     */
    public function addShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (!$this->profileModel->addShippingAddress()) {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Edit Shipping Address Post
     */
    public function editShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->editShippingAddress()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Shipping Address Post
     */
    public function deleteShippingAddressPost()
    {
        if (!authCheck()) {
            exit();
        }
        if ($this->profileModel->deleteShippingAddress()) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /**
     * Affiliate Links
     */
    public function affiliateLinks()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (user()->is_affiliate != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data['title'] = trans("affiliate_links");
        $data['description'] = trans("affiliate_links") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("affiliate_links") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'affiliate_links';
        $numRows = $this->commonModel->getUserAffiliateLinksCount(user()->id);
        $data['pager'] = paginate($this->baseVars->perPage, $numRows);
        $data['links'] = $this->commonModel->getUserAffiliateLinksPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);

        echo view('partials/_header', $data);
        echo view('settings/affiliate_links', $data);
        echo view('partials/_footer');
    }

    /**
     * Delete Affiliate Link
     */
    public function deleteAffiliateLinkPost()
    {
        $id = inputPost('link_id');
        if ($this->commonModel->deleteAffiliateLink($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        exit();
    }

    /**
     * Social Media
     */
    public function socialMedia()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("social_media") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'social_media';
        
        echo view('partials/_header', $data);
        echo view('settings/social_media', $data);
        echo view('partials/_footer');
    }

    /**
     * Social Media Post
     */
    public function socialMediaPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->updateSocialMedia()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('settings', 'social_media'));
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("change_password") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'change_password';
        
        echo view('partials/_header', $data);
        echo view('settings/change_password', $data);
        echo view('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function changePasswordPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        if (!empty(user()->password)) {
            $val->setRule('old_password', trans("old_password"), 'required|max_length[255]');
        }
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[100]');
        $val->setRule('password_confirm', trans("password_confirm"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->profileModel->changePassword()) {
                setSuccessMessage(trans("msg_change_password_success"));
            } else {
                setErrorMessage(trans("msg_change_password_error"));
            }
        }
        return redirect()->to(generateUrl('settings', 'change_password'));
    }

    /**
     * Delete Account
     */
    public function deleteAccount()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("delete_account");
        $data['description'] = trans("delete_account") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("delete_account") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'delete_account';
        
        echo view('partials/_header', $data);
        echo view('settings/delete_account', $data);
        echo view('partials/_footer');
    }

    /**
     * Delete Account Post
     */
    public function deleteAccountPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[100]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if (!password_verify(inputPost('password'), user()->password)) {
                setErrorMessage(trans("wrong_password"));
            } else {
                $this->profileModel->addDeleteAccountRequest(user());
                setSuccessMessage(trans("msg_request_received"));
            }
        }
        return redirect()->to(generateUrl('settings', 'delete_account'));
    }

    /**
     * Follow Unfollow User
     */
    public function followUnfollowUser()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $this->profileModel->followUnfollowUser();
        redirectToBackUrl();
    }
}