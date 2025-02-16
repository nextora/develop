<?php namespace App\Models;

class EarningsModel extends BaseModel
{
    protected $builder;
    protected $builderPayouts;
    protected $builderUsersPayoutAccounts;
    protected $builderAffiliateEarnings;
    protected $builderWalletExpenses;
    protected $builderWalletDeposits;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('earnings');
        $this->builderPayouts = $this->db->table('payouts');
        $this->builderUsersPayoutAccounts = $this->db->table('users_payout_accounts');
        $this->builderAffiliateEarnings = $this->db->table('affiliate_earnings');
        $this->builderWalletExpenses = $this->db->table('wallet_expenses');
        $this->builderWalletDeposits = $this->db->table('wallet_deposits');
    }

    //get earnings count
    public function getEarningsCount($userId)
    {
        $this->filterEarnings();
        return $this->builder->where('user_id', clrNum($userId))->countAllResults();
    }

    //get paginated earnings
    public function getEarningsPaginated($userId, $perPage, $offset)
    {
        $this->filterEarnings();
        return $this->builder->where('user_id', clrNum($userId))->orderBy('earnings.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get cod earnings count
    public function getCodEarningsCount($userId)
    {
        return $this->builder->select('earnings.*')->join('orders', 'orders.order_number = earnings.order_number')
            ->where('earnings.user_id', clrNum($userId))->where('orders.payment_method', 'Cash On Delivery')->countAllResults();
    }

    //get cod paginated earnings
    public function getCodEarningsPaginated($userId, $perPage, $offset)
    {
        return $this->builder->select('earnings.*')->join('orders', 'orders.order_number = earnings.order_number')
            ->where('earnings.user_id', clrNum($userId))->where('orders.payment_method', 'Cash On Delivery')
            ->orderBy('earnings.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter earnings
    public function filterEarnings()
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builder->like('earnings.order_number', $q);
        }
    }

    //add seller earnings
    public function addSellerEarnings($orderProduct)
    {
        if (!empty($orderProduct)) {
            $order = getOrder($orderProduct->order_id);
            if (!empty($order)) {
                //check if earning already added
                $row = $this->builder->where('order_number', $order->order_number)->where('order_product_id', $orderProduct->id)->where('user_id', $orderProduct->seller_id)->get()->getRow();
                if (empty($row)) {
                    $currencyCode = 'USD';
                    $exchangeRate = 1;
                    $currency = getCurrencyByCode($orderProduct->product_currency);
                    if (!empty($currency)) {
                        $currencyCode = $currency->code;
                        $exchangeRate = $currency->exchange_rate;
                    }

                    $saleAmount = getPrice($orderProduct->product_total_price, 'decimal');
                    $vat = 0;
                    if (!empty($orderProduct->product_vat)) {
                        $vat = getPrice($orderProduct->product_vat, 'decimal');
                    }
                    $saleAmount = $saleAmount - $vat;
                    //calculate earned amount
                    $earnedAmount = $saleAmount;
                    $couponDiscount = 0;
                    $productIds = getCouponProductsArray($order);
                    if (!empty($productIds) && in_array($orderProduct->product_id, $productIds)) {
                        if ($order->coupon_discount_rate > 0 && $order->coupon_seller_id == $orderProduct->seller_id) {
                            $couponDiscount = ($saleAmount * $order->coupon_discount_rate) / 100;
                            $earnedAmount = $earnedAmount - $couponDiscount;
                        }
                    }
                    $commission = ($saleAmount * $orderProduct->commission_rate) / 100;
                    $earnedAmount = $earnedAmount - $commission;
                    $shippingCost = $this->getSingleProductShippingCost($orderProduct->order_id, $orderProduct->seller_id);
                    if (!empty($shippingCost)) {
                        $earnedAmount = $earnedAmount + $shippingCost;
                    }
                    $earnedAmount = $earnedAmount + $vat;

                    //affiliate commission and discount
                    $objAffiliate = $this->addAffiliateEarnings($order, $orderProduct, $currencyCode, $exchangeRate);
                    if ($objAffiliate->isSellerBased == true) {
                        if (!empty($objAffiliate->commission) && $objAffiliate->commission > 0) {
                            $earnedAmount -= $objAffiliate->commission;
                        }
                        if (!empty($objAffiliate->discount) && $objAffiliate->discount > 0) {
                            $earnedAmount -= $objAffiliate->discount;
                        }
                    }
                    $earnedAmountDb = getPrice($earnedAmount, 'database');
                    //add earning
                    $data = [
                        'order_number' => $order->order_number,
                        'order_product_id' => $orderProduct->id,
                        'user_id' => $orderProduct->seller_id,
                        'sale_amount' => getPrice($saleAmount, 'database'),
                        'vat_rate' => $orderProduct->product_vat_rate,
                        'vat_amount' => $orderProduct->product_vat,
                        'commission_rate' => $orderProduct->commission_rate,
                        'commission' => getPrice($commission, 'database'),
                        'coupon_discount' => getPrice($couponDiscount, 'database'),
                        'shipping_cost' => getPrice($shippingCost, 'database'),
                        'earned_amount' => $earnedAmountDb,
                        'affiliate_commission_rate' => $objAffiliate->isSellerBased == true ? $objAffiliate->commissionRate : 0,
                        'affiliate_commission' => $objAffiliate->isSellerBased == true ? getPrice($objAffiliate->commission, 'database') : 0,
                        'affiliate_discount_rate' => $objAffiliate->isSellerBased == true ? $objAffiliate->discountRate : 0,
                        'affiliate_discount' => $objAffiliate->isSellerBased == true ? getPrice($objAffiliate->discount, 'database') : 0,
                        'currency' => $currencyCode,
                        'exchange_rate' => $exchangeRate,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->builder->insert($data);
                    //update seller balance and number of sales
                    $user = getUser($orderProduct->seller_id);
                    if (!empty($user)) {
                        $commission = convertToDefaultCurrency($commission, $currencyCode);
                        $earnedAmount = convertToDefaultCurrency($earnedAmount, $currencyCode);
                        $newBalance = $user->balance;
                        $commissionDebt = $user->commission_debt;
                        if ($order->payment_method == 'Cash On Delivery') {
                            if ($data['commission'] > 0) {
                                $commissionDebt += getPrice($commission, 'database');
                            }
                        } else {
                            $newBalance = $user->balance + getPrice($earnedAmount, 'database');
                        }
                        $sales = $user->number_of_sales;
                        $sales = $sales + 1;
                        $data = [
                            'balance' => $newBalance,
                            'number_of_sales' => $sales,
                            'commission_debt' => $commissionDebt
                        ];
                        $this->db->table('users')->where('id', $user->id)->update($data);
                    }
                }
            }
        }
    }

    //add affiliate earnings
    private function addAffiliateEarnings($order, $orderProduct, $currencyCode, $exchangeRate)
    {
        $objAff = new \stdClass();
        $objAff->commissionRate = 0;
        $objAff->discountRate = 0;
        $objAff->commission = 0;
        $objAff->discount = 0;
        $objAff->commissionDefaultCurrency = 0;
        $objAff->discountDefaultCurrency = 0;
        $objAff->isSellerBased = false;

        if (!empty($order) && !empty($orderProduct)) {
            $affiliate = unserializeData($order->affiliate_data);
            if ($this->generalSettings->affiliate_status == 1 && !empty($affiliate) && !empty($affiliate['productId']) && $affiliate['productId'] == $orderProduct->product_id) {
                //check if seller based
                if ($this->generalSettings->affiliate_type == 'seller_based') {
                    $objAff->isSellerBased = true;
                }
                if (!empty($affiliate['discount'])) {
                    $objAff->discountRate = $affiliate['discountRate'];
                    $objAff->discount = $affiliate['discount'];
                }
                if (!empty($affiliate['commission'])) {
                    $objAff->commissionRate = $affiliate['commissionRate'];
                    $objAff->commission = $affiliate['commission'];

                    $objAff->commissionDefaultCurrency = convertToDefaultCurrency($objAff->commission, $currencyCode);
                    $objAff->discountDefaultCurrency = convertToDefaultCurrency($objAff->discount, $currencyCode);

                    //add affiliate earning
                    $data = [
                        'order_id' => $order->id,
                        'referrer_id' => $affiliate['referrerId'],
                        'product_id' => $orderProduct->product_id,
                        'seller_id' => $orderProduct->seller_id,
                        'commission_rate' => $objAff->commissionRate,
                        'earned_amount' => getPrice($objAff->commission, 'database'),
                        'currency' => $currencyCode,
                        'exchange_rate' => $exchangeRate,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($this->db->table('affiliate_earnings')->insert($data)) {
                        //update referrer balance
                        $referrer = getUser($affiliate['referrerId']);
                        if (!empty($referrer)) {
                            $commission = getPrice($objAff->commissionDefaultCurrency, 'database');
                            if (!empty($commission) && $commission > 0) {
                                $balance = $referrer->balance + $commission;
                                $this->db->table('users')->where('id', $referrer->id)->update(['balance' => $balance]);
                            }
                        }
                    }
                }
            }
        }
        return $objAff;
    }

    //refund product
    public function refundProduct($orderProduct)
    {
        if (!empty($orderProduct)) {
            $order = getOrder($orderProduct->order_id);
            $earning = $this->getEarningByOrderProductId($orderProduct->id, $order->order_number);
            if (!empty($order) && !empty($earning) && $order->payment_method != 'Cash On Delivery') {
                //edit vendor balance
                $user = getUser($orderProduct->seller_id);
                if (!empty($user)) {
                    $this->db->table('users')->where('id', $user->id)->update(['balance' => $user->balance - $earning->earned_amount]);
                }
                //edit order product
                $this->db->table('order_products')->where('id', $orderProduct->id)->update(['order_status' => 'refund_approved', 'updated_at' => date('Y-m-d H:i:s')]);
                //edit refund request
                $this->db->table('refund_requests')->where('order_product_id', $orderProduct->id)->update(['is_completed' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                //update earning
                $this->builder->where('id', $earning->id)->update(['is_refunded' => 1]);
                //update order date
                $this->db->table('orders')->where('id', $orderProduct->order_id)->update(['updated_at' => date('Y-m-d H:i:s')]);
            } else {
                //edit order product
                $this->db->table('order_products')->where('id', $orderProduct->id)->update(['order_status' => 'refund_approved', 'updated_at' => date('Y-m-d H:i:s')]);
                //edit refund request
                $this->db->table('refund_requests')->where('order_product_id', $orderProduct->id)->update(['is_completed' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                //update order date
                $this->db->table('orders')->where('id', $orderProduct->order_id)->update(['updated_at' => date('Y-m-d H:i:s')]);
            }
            //delete if digital product
            if ($orderProduct->product_type == 'digital') {
                $digitalSale = $this->db->table('digital_sales')->where('order_id', $orderProduct->order_id)->where('product_id', $orderProduct->product_id)->where('buyer_id', $orderProduct->buyer_id)->get()->getRow();
                if (!empty($digitalSale)) {
                    $this->db->table('digital_sales')->where('id', $digitalSale->id)->delete();
                }
            }
        }
    }

    //get single product shipping cost
    public function getSingleProductShippingCost($orderId, $sellerId)
    {
        $numProducts = 0;
        $sellerShippingCost = 0;
        $orderModel = new OrderModel();
        $orderProducts = $orderModel->getOrderProducts($orderId);
        if (!empty($orderProducts)) {
            foreach ($orderProducts as $product) {
                if ($product->seller_id == $sellerId) {
                    $numProducts += 1;
                    $sellerShippingCost = $product->seller_shipping_cost;
                }
            }
        }
        if (!empty($numProducts)) {
            $cost = ($sellerShippingCost / 100) / $numProducts;
            if (!empty($cost)) {
                return number_format($cost, 2, '.', '');
            }
        }
        return 0;
    }

    //get earning by order product
    public function getEarningByOrderProductId($orderProductId, $orderNumber)
    {
        return $this->builder->where('order_number', $orderNumber)->where('order_product_id', clrNum($orderProductId))->get()->getRow();
    }

    //get user payout account
    public function getUserPayoutAccount($userId)
    {
        $row = $this->builderUsersPayoutAccounts->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($row)) {
            return $row;
        }
        $data = [
            'user_id' => clrNum($userId),
            'payout_paypal_email' => '',
            'iban_full_name' => '',
            'iban_country_id' => '',
            'iban_bank_name' => '',
            'iban_number' => '',
            'swift_full_name' => '',
            'swift_address' => '',
            'swift_state' => '',
            'swift_city' => '',
            'swift_postcode' => '',
            'swift_country_id' => '',
            'swift_bank_account_holder_name' => '',
            'swift_iban' => '',
            'swift_code' => '',
            'swift_bank_name' => '',
            'swift_bank_branch_city' => '',
            'swift_bank_branch_country_id' => ''
        ];
        $this->builderUsersPayoutAccounts->insert($data);
        return $this->builderUsersPayoutAccounts->where('user_id', clrNum($userId))->get()->getRow();
    }

    //set paypal payout account
    public function setPayoutAccount($userId, $submit)
    {
        if ($submit == 'paypal') {
            $data = ['payout_paypal_email' => inputPost('payout_paypal_email')];
        } elseif ($submit == 'bitcoin') {
            $data = ['payout_bitcoin_address' => inputPost('payout_bitcoin_address')];
        } elseif ($submit == 'bitcoin') {
            $data = ['payout_bitcoin_address' => inputPost('payout_bitcoin_address')];
        } elseif ($submit == 'iban') {
            $data = [
                'iban_full_name' => inputPost('iban_full_name'),
                'iban_country_id' => inputPost('iban_country_id'),
                'iban_bank_name' => inputPost('iban_bank_name'),
                'iban_number' => inputPost('iban_number')
            ];
        } elseif ($submit == 'swift') {
            $data = [
                'swift_full_name' => inputPost('swift_full_name'),
                'swift_address' => inputPost('swift_address'),
                'swift_state' => inputPost('swift_state'),
                'swift_city' => inputPost('swift_city'),
                'swift_postcode' => inputPost('swift_postcode'),
                'swift_country_id' => inputPost('swift_country_id'),
                'swift_bank_account_holder_name' => inputPost('swift_bank_account_holder_name'),
                'swift_iban' => inputPost('swift_iban'),
                'swift_code' => inputPost('swift_code'),
                'swift_bank_name' => inputPost('swift_bank_name'),
                'swift_bank_branch_city' => inputPost('swift_bank_branch_city'),
                'swift_bank_branch_country_id' => inputPost('swift_bank_branch_country_id')
            ];
        }
        if (!empty($data)) {
            return $this->builderUsersPayoutAccounts->where('user_id', clrNum($userId))->update($data);
        }
        return false;
    }

    //get payouts count
    public function getPayoutsCount($userId)
    {
        return $this->builderPayouts->where('user_id', clrNum($userId))->countAllResults();
    }

    //get paginated payouts
    public function getPaginatedPayouts($userId, $perPage, $offset)
    {
        return $this->builderPayouts->where('user_id', clrNum($userId))->orderBy('payouts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get active payouts
    public function getActivePayouts($userId)
    {
        return $this->builderPayouts->where('user_id', clrNum($userId))->where('status', 0)->orderBy('payouts.created_at DESC')->get()->getResult();
    }

    //withdraw money
    public function withdrawMoney($data)
    {
        return $this->builderPayouts->insert($data);
    }

    //referral earnings count
    public function getReferralEarningsCount($userId)
    {
        return $this->builderAffiliateEarnings->where('referrer_id', clrNum($userId))->countAllResults();
    }

    //get paginated referral earnings
    public function getReferralEarningsPaginated($userId, $perPage, $offset)
    {
        return $this->builderAffiliateEarnings->where('referrer_id', clrNum($userId))->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    /*
     * --------------------------------------------------------------------
     * Wallet
     * --------------------------------------------------------------------
     */

    //add wallet deposit transaction
    public function addWalletDeposit($dataTransaction, $serviceData)
    {
        if (authCheck() && !empty($dataTransaction) && !empty($serviceData)) {
            if ($serviceData->paymentType == 'add_funds') {
                $data = [
                    'user_id' => user()->id,
                    'payment_method' => $dataTransaction['payment_method'],
                    'payment_id' => $dataTransaction['payment_id'],
                    'deposit_amount' => $dataTransaction['payment_amount'],
                    'currency' => $dataTransaction['currency'],
                    'payment_status' => 1,
                    'ip_address' => getIPAddress(),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($dataTransaction['payment_status'] == 'awaiting_payment') {
                    $data['payment_status'] = 0;
                }
                if ($this->builderWalletDeposits->insert($data)) {
                    $lastId = $this->db->insertID();
                    if ($data['payment_status'] == 1) {
                        $this->addFundsWallet($dataTransaction['payment_amount'], $dataTransaction['currency'], user()->id);
                    }
                    return $lastId;
                }
            }
        }
        return false;
    }

    //add funds to wallet
    public function addFundsWallet($paymentAmount, $currency, $userId)
    {
        $user = getUser($userId);
        if (!empty($user)) {
            $total = convertToDefaultCurrency($paymentAmount, $currency, false);
            $total = getPrice($total, 'database');
            $balance = $user->balance + $total;
            $this->db->table('users')->where('id', $user->id)->update(['balance' => $balance]);
        }
    }

    //set deposit payment received
    public function setDepositPaymentReceived($deposit)
    {
        if (!empty($deposit)) {
            $this->builderWalletDeposits->where('id', $deposit->id)->update(['payment_status' => 1]);
        }
    }

    //get deposit transaction
    public function getDepositTransaction($id)
    {
        return $this->builderWalletDeposits->where('id', clrNum($id))->get()->getRow();
    }

    //get deposits count
    public function getDepositsCount($userId = null)
    {
        $this->filterDeposits($userId);
        return $this->builderWalletDeposits->countAllResults();
    }

    //get paginated deposits
    public function getPaginatedDeposits($perPage, $offset, $userId = null)
    {
        $this->filterDeposits($userId);
        return $this->builderWalletDeposits->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter deposits
    public function filterDeposits($userId = null)
    {
        if (!empty($userId)) {
            $this->builderWalletDeposits->where('user_id', clrNum($userId));
        } else {
            $q = inputGet('q');
            $paymentStatus = inputGet('payment_status');
            if (!empty($q)) {
                $this->builderWalletDeposits->like('payment_id', cleanStr($q));
            }
            if (!empty($paymentStatus)) {
                if ($paymentStatus == 'payment_received') {
                    $this->builderWalletDeposits->where('payment_status', 1);
                } elseif ($paymentStatus == 'awaiting_payment') {
                    $this->builderWalletDeposits->where('payment_status', 0);
                }
            }
        }
        $this->builderWalletDeposits->join('users', 'users.id = wallet_deposits.user_id')
            ->select('wallet_deposits.*, users.slug AS user_slug, users.username AS user_username');
    }

    //delete wallet deposit
    public function deleteWalletDeposit($id)
    {
        $transaction = $this->getDepositTransaction($id);
        if (!empty($transaction)) {
            return $this->builderWalletDeposits->where('id', $transaction->id)->delete();
        }
        return false;
    }

    //add expense
    public function addExpense($dataTransaction, $paymentType, $transactionId)
    {
        if (authCheck() && !empty($dataTransaction) && !empty($paymentType)) {
            //deduct from balance
            $total = convertToDefaultCurrency($dataTransaction['payment_amount'], $dataTransaction['currency']);
            $total = getPrice($total, 'database');
            $balance = user()->balance - $total;
            $this->db->table('users')->where('id', user()->id)->update(['balance' => $balance]);

            $data = [
                'user_id' => user()->id,
                'payment_id' => $dataTransaction['payment_id'],
                'expense_item_id' => $transactionId,
                'expense_type' => $paymentType,
                'expense_amount' => getPrice($dataTransaction['payment_amount'], 'database'),
                'expense_detail' => '',
                'currency' => $dataTransaction['currency'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            if ($paymentType == 'service') {
                $servicePayment = helperGetSession('mds_service_payment');
                if (!empty($servicePayment)) {
                    if ($servicePayment->paymentType == 'membership') {
                        $data['expense_type'] = 'membership';
                        $model = new MembershipModel();
                        $plan = $model->getPlan($servicePayment->planId);
                        if (!empty($plan)) {
                            if ($planName = getMembershipPlanName($plan->title_array, $this->activeLang->id)) {
                                $data['expense_detail'] = $planName;
                            }
                        }
                    } elseif ($servicePayment->paymentType == 'promote') {
                        $data['expense_type'] = 'promote';
                        $dataPlan = [
                            'plan_type' => $servicePayment->planType,
                            'product_id' => $servicePayment->productId,
                            'day_count' => $servicePayment->dayCount
                        ];
                        $data['expense_detail'] = serialize($dataPlan);
                    }
                }
            }
            return $this->builderWalletExpenses->insert($data);
        }
        return false;
    }

    //deduct commission debt from wallet
    public function deductCommissionDebtFromWallet()
    {
        if (authCheck()) {
            $user = user();
            if ($user->commission_debt > 0 && $user->balance > 0) {
                $debt = $user->commission_debt;
                $balance = $user->balance;
                $expenseAmount = 0;
                if ($debt > 0) {
                    if ($debt >= $balance) {
                        $expenseAmount = $balance;
                        $debt = $debt - $balance;
                        $balance = 0;
                    } else {
                        $expenseAmount = $debt;
                        $balance = $balance - $debt;
                        $debt = 0;
                    }
                }
                if ($this->db->table('users')->where('id', $user->id)->update(['balance' => $balance, 'commission_debt' => $debt])) {
                    $expense = [
                        'user_id' => $user->id,
                        'payment_id' => uniqid(),
                        'expense_type' => 'commission_debt',
                        'expense_amount' => $expenseAmount,
                        'expense_detail' => trans("commission_debt"),
                        'currency' => $this->defaultCurrency->code,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->builderWalletExpenses->insert($expense);
                }
            }
        }
    }

    //get expense
    public function getExpense($id)
    {
        return $this->builderWalletExpenses->where('id', clrNum($id))->get()->getRow();
    }

    //get expenses count
    public function getExpensesCount($userId)
    {
        return $this->builderWalletExpenses->where('user_id', clrNum($userId))->countAllResults();
    }

    //get paginated expenses
    public function getExpensesPaginated($userId, $perPage, $offset)
    {
        return $this->builderWalletExpenses->where('user_id', clrNum($userId))->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }
}
