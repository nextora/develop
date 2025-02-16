<?php
/**
 * Export PHP library
 *
 **/

require_once APPPATH . "Libraries/SimpleXLSXGen.php";

class Export
{
    private $fields;
    private $rows;
    private $fileNamme;
    private $arrayExport;
    private $dataExportType;
    private $isRTL;
    private $csvDelimiter = ',';

    /**
     * Constructor
     *
     * @access public
     * @param array
     */
    public function __construct($fields, $rows, $fileName, $dataExportType, $isRTL)
    {
        $this->fields = $fields;
        $this->rows = $rows;
        $this->fileName = $fileName;
        $this->dataExportType = $dataExportType;
        $this->isRTL = $isRTL;
        $this->setExportArray();
    }

    //export as Excel
    public function exportAsExcel()
    {
        $this->fileName .= '.xlsx';
        $path = 'uploads/temp/' . $this->fileName;
        $xlsx = Shuchkin\SimpleXLSXGen::fromArray($this->arrayExport);
        if ($this->isRTL == true) {
            $xlsx->rightToLeft();
        }
        $xlsx->saveAs($path);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($this->fileName) . '"');
        flush();
        readfile(FCPATH . $path);
        if (file_exists(FCPATH . $path)) {
            @unlink(FCPATH . $path);
        }
        exit();
    }

    //export as CSV
    public function exportAsCsv()
    {
        $this->fileName .= '.csv';
        $path = 'uploads/temp/' . $this->fileName;
        try {
            $file = fopen(FCPATH . $path, 'w');
            if (!empty($this->arrayExport)) {
                foreach ($this->arrayExport as $array) {
                    fputcsv($file, $array, $this->csvDelimiter);
                }
            }
            fclose($file);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . basename($this->fileName) . '"');
            flush();
            readfile(FCPATH . $path);
        } catch (Exception $e) {
        }
        if (file_exists(FCPATH . $path)) {
            @unlink(FCPATH . $path);
        }
        exit();
    }

    //export as XML
    public function exportAsXml()
    {
        $this->fileName .= '.xml';
        $path = 'uploads/temp/' . $this->fileName;
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><root/>');
        if (!empty($this->fields) && !empty($this->rows)) {
            foreach ($this->rows as $row) {
                $child = $xml->addChild('item');
                foreach ($this->fields as $field) {
                    if (isset($row->$field)) {
                        $child->addChild($field, htmlspecialchars($row->$field));
                    }
                }
            }
        }
        $xml->saveXML(FCPATH . $path);
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="' . basename($this->fileName) . '"');
        flush();
        readfile(FCPATH . $path);
        if (file_exists(FCPATH . $path)) {
            @unlink(FCPATH . $path);
        }
        exit();
    }

    //set export data array
    private function setExportArray()
    {
        $this->arrayExport = [
            $this->fields
        ];
        if (!empty($this->fields) && !empty($this->rows)) {
            foreach ($this->rows as $row) {
                if ($this->dataExportType == 'products') {
                    $row = $this->formatProductData($row);
                } elseif ($this->dataExportType == 'orders') {
                    $row = $this->formatOrderData($row);
                } elseif ($this->dataExportType == 'transactions') {
                    $row = $this->formatTransactionData($row);
                } elseif ($this->dataExportType == 'digital_sales') {
                    $row = $this->formatDigitalSalesData($row);
                } elseif ($this->dataExportType == 'vendor_products') {
                    $row = $this->formatVendorProductsData($row);
                } elseif ($this->dataExportType == 'vendor_sales') {
                    $row = $this->formatSaleData($row);
                }
                $arrayLine = [];
                foreach ($this->fields as $field) {
                    $colValue = isset($row->$field) ? $row->$field : '';
                    array_push($arrayLine, $colValue);
                }
                array_push($this->arrayExport, $arrayLine);
            }
        }
    }

    //format product data
    private function formatProductData($row)
    {
        $row->title = getProductTitle($row, false);
        $row->listing_type = $this->getProductListingType($row->listing_type);
        $row->product_type = !empty($row->product_type) ? trans($row->product_type) : '';
        $row->price = !empty($row->price) ? getPrice($row->price, 'decimal') : '';
        $row->price_discounted = !empty($row->price_discounted) ? getPrice($row->price_discounted, 'decimal') : '';
        $row->category_name = $row->category_name;
        $row->username = $row->seller_username;
        $row->date = $row->created_at;
        if ($row->is_promoted != 1) {
            $row->promote_start_date = '';
            $row->promote_end_date = '';
        }
        $row->purchased_plan = '';
        if ($row->is_draft != 1 && $row->is_promoted == 1 && $row->promote_plan != 'none') {
            $row->purchased_plan = $row->promote_plan;
        }
        $row->location = getLocation($row);
        $row->tags = getProductTagsString($row, selectedLangId());
        return $this->setProductContentImages($row);
    }

    //format order data
    private function formatOrderData($row)
    {
        $status = trans("order_processing");
        if ($row->status == 1) {
            $status = trans("completed");
        } elseif ($row->status == 2) {
            $status = trans("cancelled");
        }
        $buyerName = $row->buyer_username;
        if ($row->buyer_id == 0) {
            $shipping = unserializeData($row->shipping);
            if (!empty($shipping)) {
                if (!empty($shipping->sFirstName)) {
                    $buyerName = $shipping->sFirstName;
                }
                if (!empty($shipping->sLastName)) {
                    $buyerName .= ' ' . $shipping->sLastName;
                }
            }
        }
        $row->order = '#' . $row->order_number;
        $row->buyer_id = $row->buyer_id;
        $row->buyer_name = $buyerName;
        $row->subtotal = !empty($row->price_subtotal) ? getPrice($row->price_subtotal, 'decimal') : '';
        $row->vat = !empty($row->price_vat) ? getPrice($row->price_vat, 'decimal') : '';
        $row->shipping_cost = !empty($row->price_shipping) ? getPrice($row->price_shipping, 'decimal') : '';
        $row->total = !empty($row->price_total) ? getPrice($row->price_total, 'decimal') : '';
        $row->currency = $row->price_currency;
        $row->coupon_discount = !empty($row->coupon_discount) ? getPrice($row->coupon_discount, 'decimal') : '';
        $row->transaction_fee = !empty($row->transaction_fee) ? getPrice($row->transaction_fee, 'decimal') : '';
        $row->payment_method = getPaymentMethod($row->payment_method);
        $row->payment_status = trans($row->payment_status);
        $row->status = $status;
        $row->updated = $row->updated_at;
        $row->date = $row->created_at;

        $orderProducts = getOrderProducts($row->id);
        $strProducts = '';
        if (!empty($orderProducts)) {
            foreach ($orderProducts as $item) {
                if (!empty($item)) {
                    if ($strProducts != '') {
                        $strProducts = $strProducts . ', ';
                    }
                    $strProducts .= $item->product_title;
                    $strProducts .= ' (ID: ' . $item->product_id;
                    if (!empty($item->product_quantity)) {
                        $strProducts .= ' ' . trans("quantity") . ': ' . $item->product_id;
                    }
                    $strProducts .= ')';
                }
            }
        }
        $row->products = $strProducts;
        return $row;
    }

    //format transaction data
    private function formatTransactionData($row)
    {
        $row->order = '#' . clrNum($row->order_id) + 10000;
        $row->username = !empty($row->user_username) ? $row->user_username : trans("guest");
        $row->date = $row->created_at;
        return $row;
    }

    //format digital sales data
    private function formatDigitalSalesData($row)
    {
        $row->order = '#' . clrNum($row->order_id) + 10000;
        $row->seller_name = $row->seller_username;
        $row->buyer_name = $row->buyer_username;
        $row->total = !empty($row->price) ? getPrice($row->price, 'decimal') : '';
        $row->date = $row->purchase_date;
        return $row;
    }

    //format vendor products data
    private function formatVendorProductsData($row)
    {
        $row->stock_status = getProductStockStatus($row, false);
        $row->listing_type = $this->getProductListingType($row->listing_type);
        $row->product_type = !empty($row->product_type) ? trans($row->product_type) : '';
        $row->purchased_plan = '';
        if ($row->is_draft != 1 && $row->is_promoted == 1 && $row->promote_plan != 'none') {
            $row->purchased_plan = $row->promote_plan;
        }
        $row->price = !empty($row->price) ? getPrice($row->price, 'decimal') : '';
        $row->price_discounted = !empty($row->price_discounted) ? getPrice($row->price_discounted, 'decimal') : '';
        $row->category_name = $row->category_name;
        $row->location = getLocation($row);
        $row->tags = getProductTagsString($row, selectedLangId());
        $row->date = $row->created_at;
        return $this->setProductContentImages($row);
    }

    //format order data
    private function formatSaleData($row)
    {
        $status = trans("order_processing");
        if ($row->status == 1) {
            $status = trans("completed");
        } elseif ($row->status == 2) {
            $status = trans("cancelled");
        }
        $row->sale = '#' . $row->order_number;
        $finalPrice = getSellerFinalPrice($row->id);
        $row->total = !empty($finalPrice) ? getPrice($finalPrice, 'decimal') : '';
        $row->currency = $row->price_currency;
        $row->payment_status = trans($row->payment_status);
        $row->status = $status;
        $row->date = $row->created_at;
        return $row;
    }

    //get product listing type
    private function getProductListingType($key)
    {
        if ($key == 'sell_on_site') {
            return trans("marketplace");
        } elseif ($key == 'ordinary_listing') {
            return trans("classified_ads");
        } elseif ($key == 'bidding') {
            return trans("bidding_system_request_quote");
        } elseif ($key == 'license_key') {
            return trans("license_key");
        } else {
            return '';
        }
    }

    //set product content and images
    private function setProductContentImages($row)
    {
        $shortDesc = '';
        $desc = '';
        $imageStr = '';
        if (!empty($row->product_content)) {
            $array = explode(':::', $row->product_content ?? '');
            if (!empty($array[0])) {
                $shortDesc = $array[0];
            }
            if (!empty($array[1])) {
                $desc = $array[1];
            }
        }
        if (!empty($row->images_big)) {
            $array = explode(',', $row->images_big ?? '');
            if (!empty($array) && countItems($array) > 0) {
                foreach ($array as $item) {
                    $imageArray = explode(':::', $item);
                    if (!empty($imageArray[0]) && !empty($imageArray[1])) {
                        if ($imageArray[0] == 'aws_s3') {
                            $imageStr .= ', ' . getAWSBaseUrl() . 'uploads/images/' . $imageArray[1];
                        } else {
                            $imageStr .= ', ' . base_url('uploads/images/' . $imageArray[1]);
                        }
                    }
                }
            }
            if (!empty($imageStr)) {
                $imageStr = trim($imageStr, ',');
            }
        }
        $row->short_description = $shortDesc;
        $row->description = $desc;
        $row->images = $imageStr;
        return $row;
    }
}