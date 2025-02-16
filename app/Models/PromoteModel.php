<?php namespace App\Models;

class PromoteModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('promoted_transactions');
    }

    //add promote transaction
    public function addPromoteTransaction($dataTransaction, $serviceData)
    {
        if (!empty($dataTransaction) && !empty($serviceData)) {
            $data = [
                'payment_method' => $dataTransaction['payment_method'],
                'payment_id' => $dataTransaction['payment_id'],
                'user_id' => user()->id,
                'product_id' => $serviceData->productId,
                'currency' => $dataTransaction['currency'],
                'payment_amount' => $dataTransaction['payment_amount'],
                'payment_status' => $dataTransaction['payment_status'],
                'purchased_plan' => $serviceData->purchasedPlan,
                'day_count' => $serviceData->dayCount,
                'ip_address' => getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            if (!empty($serviceData->globalTaxesArray)) {
                $cartModel = new CartModel();
                $array = $cartModel->convertServiceTaxesCurrency($serviceData->globalTaxesArray, $dataTransaction['currency']);
                $data['global_taxes_data'] = serialize($array);
            }
            if ($this->builder->insert($data)) {
                return $this->db->insertID();
            }
        }
        return false;
    }

    //add to promoted products
    public function addToPromotedProducts($serviceData)
    {
        if (!empty($serviceData)) {
            $product = getProduct($serviceData->productId);
            if (!empty($product)) {
                $date = date('Y-m-d H:i:s');
                $endDate = date('Y-m-d H:i:s', strtotime($date . ' + ' . $serviceData->dayCount . ' days'));
                $data = [
                    'promote_plan' => $serviceData->purchasedPlan,
                    'promote_day' => $serviceData->dayCount,
                    'is_promoted' => 1,
                    'promote_start_date' => $date,
                    'promote_end_date' => $endDate
                ];
                return $this->db->table('products')->where('id', $product->id)->update($data);
            }
        }
        return false;
    }

    //get transactions count
    public function getTransactionsCount($userId)
    {
        $this->filterTransactions($userId);
        return $this->builder->countAllResults();
    }

    //get transactions paginated
    public function getTransactionsPaginated($userId, $perPage, $offset)
    {
        $this->filterTransactions($userId);
        return $this->builder->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter transactions
    public function filterTransactions($userId)
    {
        $q = inputGet('q');
        $paymentStatus = inputGet('payment_status');
        if (!empty($q)) {
            $this->builder->where('promoted_transactions.payment_id', $q);
        }
        if (!empty($userId)) {
            $this->builder->where('user_id', clrNum($userId));
        }
        if (!empty($paymentStatus)) {
            if ($paymentStatus == 'awaiting_payment') {
                $this->builder->where('payment_status', 'awaiting_payment');
            } else {
                $this->builder->where('payment_status !=', 'awaiting_payment');
            }
        }
        $this->builder->join('users', 'users.id = promoted_transactions.user_id')
            ->select('promoted_transactions.*, users.slug AS user_slug, users.username AS user_username');
    }

    //get transaction
    public function getTransaction($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    //set transaction as payment receved
    public function setTransactionAsPaymentReceived($id)
    {
        $transaction = $this->getTransaction($id);
        if (!empty($transaction)) {
            $this->db->table('promoted_transactions')->where('id', $transaction->id)->update(['payment_status' => "Completed"]);
        }
    }

    //delete transaction
    public function deleteTransaction($id)
    {
        $transaction = $this->getTransaction($id);
        if (!empty($transaction)) {
            return $this->builder->where('id', $transaction->id)->delete();
        }
        return false;
    }

}
