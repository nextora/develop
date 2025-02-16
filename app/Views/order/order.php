<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateUrl('orders'); ?>"><?= trans("orders"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <?= view('partials/_messages'); ?>
                    </div>
                </div>
                <div class="order-details-container">
                    <div class="order-head">
                        <div class="row justify-content-center row-title">
                            <div class="col-12 col-sm-6">
                                <h1 class="page-title m-b-5"><?= trans("order"); ?>:&nbsp;#<?= esc($order->order_number); ?></h1>
                            </div>
                            <div class="col-12 col-sm-6">
                                <a href="<?= generateUrl('orders'); ?>" class="btn btn-custom color-white float-right m-b-5">
                                    <svg width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                                        <path d="M384 1408q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm0-512q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm1408 416v192q0 13-9.5 22.5t-22.5 9.5h-1216q-13 0-22.5-9.5t-9.5-22.5v-192q0-13 9.5-22.5t22.5-9.5h1216q13 0 22.5 9.5t9.5 22.5zm-1408-928q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm1408 416v192q0 13-9.5 22.5t-22.5 9.5h-1216q-13 0-22.5-9.5t-9.5-22.5v-192q0-13 9.5-22.5t22.5-9.5h1216q13 0 22.5 9.5t9.5 22.5zm0-512v192q0 13-9.5 22.5t-22.5 9.5h-1216q-13 0-22.5-9.5t-9.5-22.5v-192q0-13 9.5-22.5t22.5-9.5h1216q13 0 22.5 9.5t9.5 22.5z"/>
                                    </svg>&nbsp;&nbsp;<?= trans("orders"); ?>
                                </a>
                                <?php if ($order->status != 2):
                                    if ($order->payment_status == 'payment_received'): ?>
                                        <a href="<?= langBaseUrl(); ?>/invoice/<?= esc($order->order_number); ?>?type=buyer" target="_blank" class="btn btn-info color-white float-right m-b-5 m-r-5"><i class="icon-text-o"></i>&nbsp;&nbsp;<?= trans('view_invoice'); ?></a>
                                    <?php else: ?>
                                        <?php if ($order->payment_method != "Cash On Delivery" || ($order->payment_method == 'Cash On Delivery' && dateDifferenceInHours(date('Y-m-d H:i:s'), $order->created_at) <= 24)): ?>
                                            <button type="button" class="btn btn-light float-right m-b-5 m-r-5" onclick='cancelOrder(<?= $order->id; ?>,"<?= trans("confirm_action", true); ?>");'><i class="icon-times m-0"></i>&nbsp;&nbsp;<?= trans("cancel_order"); ?></button>
                                        <?php endif;
                                    endif;
                                endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row order-row-item">
                                    <div class="col-3">
                                        <b class="font-600"><?= trans("status"); ?></b>
                                    </div>
                                    <div class="col-9">
                                        <?php if ($order->status == 1): ?>
                                            <span class="badge badge-success-light"><?= trans("completed"); ?></span>
                                        <?php elseif ($order->status == 2): ?>
                                            <span class="badge badge-danger-light"><?= trans("cancelled"); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-primary-light"><?= trans("order_processing"); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($order->status != 2): ?>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <b class="font-600"><?= trans("payment_status"); ?></b>
                                        </div>
                                        <div class="col-9">
                                            <?= trans($order->payment_status); ?>
                                            <?php if ($order->payment_method == 'Bank Transfer' && $order->payment_status == 'awaiting_payment'):
                                                $lastBankTransfer = getLastBankTransfer('order', $order->order_number);
                                                if (isset($lastBankTransfer)):
                                                    if ($lastBankTransfer->status == 'pending'): ?>
                                                        <span class="text-info">(<?= trans("pending"); ?>)</span>
                                                    <?php elseif ($lastBankTransfer->status == 'declined'): ?>
                                                        <span class="text-danger">(<?= trans("bank_transfer_declined"); ?>)</span>
                                                        <button type="button" class="btn btn-sm btn-info color-white m-l-15" data-toggle="modal" data-target="#reportBankTransferModal">
                                                            <svg width="14" height="14" viewBox="0 0 1792 1792" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1764 11q33 24 27 64l-256 1536q-5 29-32 45-14 8-31 8-11 0-24-5l-453-185-242 295q-18 23-49 23-13 0-22-4-19-7-30.5-23.5t-11.5-36.5v-349l864-1059-1069 925-395-162q-37-14-40-55-2-40 32-59l1664-960q15-9 32-9 20 0 36 11z"/>
                                                            </svg>&nbsp;&nbsp;<?= trans("report_bank_transfer"); ?>
                                                        </button>
                                                    <?php endif;
                                                else: ?>
                                                    <button type="button" class="btn btn-sm btn-info color-white m-l-15" data-toggle="modal" data-target="#reportBankTransferModal">
                                                        <svg width="14" height="14" viewBox="0 0 1792 1792" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1764 11q33 24 27 64l-256 1536q-5 29-32 45-14 8-31 8-11 0-24-5l-453-185-242 295q-18 23-49 23-13 0-22-4-19-7-30.5-23.5t-11.5-36.5v-349l864-1059-1069 925-395-162q-37-14-40-55-2-40 32-59l1664-960q15-9 32-9 20 0 36 11z"/>
                                                        </svg>&nbsp;&nbsp;<?= trans("report_bank_transfer"); ?>
                                                    </button>
                                                <?php endif;
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <b class="font-600"><?= trans("payment_method"); ?></b>
                                        </div>
                                        <div class="col-9">
                                            <?= getPaymentMethod($order->payment_method); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                        <b class="font-600"><?= trans("date"); ?></b>
                                    </div>
                                    <div class="col-9">
                                        <?= formatDate($order->created_at); ?>
                                    </div>
                                </div>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                        <b class="font-600"><?= trans("updated"); ?></b>
                                    </div>
                                    <div class="col-9">
                                        <?= timeAgo($order->updated_at); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $shipping = unserializeData($order->shipping);
                        if (!empty($shipping)):?>
                            <div class="row shipping-container">
                                <div class="col-md-12 col-lg-6 m-b-sm-15">
                                    <div class="order-address-box">
                                        <h3 class="block-title"><?= trans("shipping_address"); ?></h3>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("first_name"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sFirstName) ? esc($shipping->sFirstName) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("last_name"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sLastName) ? esc($shipping->sLastName) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("email"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sEmail) ? esc($shipping->sEmail) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("phone_number"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sPhoneNumber) ? esc($shipping->sPhoneNumber) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("address"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sAddress) ? esc($shipping->sAddress) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("country"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sCountry) ? esc($shipping->sCountry) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("state"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sState) ? esc($shipping->sState) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("city"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sCity) ? esc($shipping->sCity) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item mb-0">
                                            <div class="col-5"><?= trans("zip_code"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->sZipCode) ? esc($shipping->sZipCode) : ''; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="order-address-box">
                                        <h3 class="block-title"><?= trans("billing_address"); ?></h3>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("first_name"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bFirstName) ? esc($shipping->bFirstName) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("last_name"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bLastName) ? esc($shipping->bLastName) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("email"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bEmail) ? esc($shipping->bEmail) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("phone_number"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bPhoneNumber) ? esc($shipping->bPhoneNumber) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("address"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bAddress) ? esc($shipping->bAddress) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("country"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bCountry) ? esc($shipping->bCountry) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("state"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bState) ? esc($shipping->bState) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5"><?= trans("city"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bCity) ? esc($shipping->bCity) : ''; ?></div>
                                        </div>
                                        <div class="row shipping-row-item mb-0">
                                            <div class="col-5"><?= trans("zip_code"); ?></div>
                                            <div class="col-7"><?= !empty($shipping->bZipCode) ? esc($shipping->bZipCode) : ''; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                        $isOrderHasPhysicalProduct = false; ?>
                        <div class="row table-orders-container m-t-30">
                            <div class="col-6 col-table-orders">
                                <h3 class="block-title"><?= trans("products"); ?></h3>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive table-custom table-orders-products">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col"><?= trans("product"); ?></th>
                                            <th scope="col"><?= trans("status"); ?></th>
                                            <th scope="col"><?= trans("updated"); ?></th>
                                            <th scope="col"><?= trans("options"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0;
                                        if (!empty($orderProducts)):
                                            foreach ($orderProducts as $item):
                                                if ($item->product_type == 'physical') {
                                                    $isOrderHasPhysicalProduct = true;
                                                }
                                                if ($i != 0):?>
                                                    <tr class="tr-shipping-seperator">
                                                        <td colspan="4">
                                                            <div class="row-seperator"></div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td style="width: 50%">
                                                        <div class="table-item-product">
                                                            <div class="left">
                                                                <div class="img-table">
                                                                    <a href="<?= generateProductUrlBySlug($item->product_slug); ?>" target="_blank">
                                                                        <img src="<?= getProductVariationImage($item->variation_option_ids, $item->product_id); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="right">
                                                                <div class="m-b-5">
                                                                    <a href="<?= generateProductUrlBySlug($item->product_slug); ?>" target="_blank" class="table-product-title font-600"><?= esc($item->product_title); ?></a>
                                                                </div>
                                                                <div class="m-b-5">
                                                                    <span class="span-product-dtl-table"><?= trans("seller"); ?>:</span>
                                                                    <?php $seller = getUser($item->seller_id); ?>
                                                                    <?php if (!empty($seller)): ?>
                                                                        <a href="<?= generateProfileUrl($seller->slug); ?>" target="_blank" class="table-product-title">
                                                                            <strong class="font-600"><?= esc(getUsername($seller)); ?></strong>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="m-b-5"><span class="span-product-dtl-table"><?= trans("unit_price"); ?>:</span><strong class="font-600"><?= priceFormatted($item->product_unit_price, $item->product_currency); ?></strong></div>
                                                                <div class="m-b-5"><span class="span-product-dtl-table"><?= trans("quantity"); ?>:</span><strong class="font-600"><?= $item->product_quantity; ?></strong></div>
                                                                <?php if (!empty($item->product_vat)): ?>
                                                                    <div class="m-b-5"><span class="span-product-dtl-table"><?= trans("vat"); ?>&nbsp;(<?= $item->product_vat_rate; ?>%):</span><strong class="font-600"><?= priceFormatted($item->product_vat, $item->product_currency); ?></strong></div>
                                                                    <div class="m-b-5"><span class="span-product-dtl-table"><?= trans("total"); ?>:</span><strong class="font-600"><?= priceFormatted($item->product_total_price, $item->product_currency); ?></strong></div>
                                                                <?php else: ?>
                                                                    <div class="m-b-5"><span class="span-product-dtl-table"><?= trans("total"); ?>:</span><strong class="font-600"><?= priceFormatted($item->product_total_price, $item->product_currency); ?></strong></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <strong class="no-wrap"><?= trans($item->order_status) ?></strong>
                                                    </td>
                                                    <td style="width: 15%;">
                                                        <?php if ($item->product_type == 'physical') {
                                                            echo timeAgo($item->updated_at);
                                                        } ?>
                                                    </td>
                                                    <td style="width: 25%; position: relative">
                                                        <?php if ($item->order_status == 'shipped'): ?>
                                                            <button type="submit" class="btn btn-md btn-custom" onclick=" approveOrderProduct('<?= $item->id; ?>','<?= trans("confirm_approve_order", true); ?>');"><i class="icon-check"></i><?= trans("confirm_order_received"); ?></button>
                                                            <small class="text-confirm-order-table"><?= trans("confirm_order_received_exp"); ?></small>
                                                        <?php elseif ($item->order_status == 'completed'):
                                                            if ($item->product_type == 'digital'):
                                                                $digitalSale = getDigitalSaleByOrderId($item->buyer_id, $item->product_id, $item->order_id);
                                                                if (!empty($digitalSale)):
                                                                    if ($item->listing_type == 'license_key'):?>
                                                                        <div class="row-custom">
                                                                            <form action="<?= base_url('download-purchased-digital-file-post'); ?>" method="post">
                                                                                <?= csrf_field(); ?>
                                                                                <input type="hidden" name="sale_id" value="<?= $digitalSale->id; ?>">
                                                                                <div class="dropdown">
                                                                                    <button class="btn btn-md btn-custom dropdown-toggle w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                                                                            <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                                                                            <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                                                                                        </svg>&nbsp;&nbsp;<?= trans("download"); ?>
                                                                                    </button>
                                                                                    <div class="dropdown-menu digital-download-dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                        <button type="submit" name="submit" value="license_certificate" class="dropdown-item"><?= trans("license_certificate"); ?></button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="row-custom">
                                                                            <form action="<?= base_url('download-purchased-digital-file-post'); ?>" method="post">
                                                                                <?= csrf_field(); ?>
                                                                                <input type="hidden" name="sale_id" value="<?= $digitalSale->id; ?>">
                                                                                <div class="dropdown">
                                                                                    <button class="btn btn-md btn-custom dropdown-toggle w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                                                                            <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                                                                            <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                                                                                        </svg>&nbsp;&nbsp;<?= trans("download"); ?>
                                                                                    </button>
                                                                                    <div class="dropdown-menu digital-download-dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                        <?php $product = getProduct($item->product_id);
                                                                                        if (!empty($product) && !empty($product->digital_file_download_link)): ?>
                                                                                            <a href="<?= esc($product->digital_file_download_link); ?>" class="dropdown-item" target="_blank"><?= trans("main_files"); ?></a>
                                                                                        <?php else: ?>
                                                                                            <button type="submit" name="submit" value="main_files" class="dropdown-item"><?= trans("main_files"); ?></button>
                                                                                        <?php endif; ?>
                                                                                        <button type="submit" name="submit" value="license_certificate" class="dropdown-item"><?= trans("license_certificate"); ?></button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    <?php endif;
                                                                endif;
                                                            endif;
                                                            if ($generalSettings->reviews == 1 && $item->seller_id != $item->buyer_id): ?>
                                                                <div class="row-custom m-t-10">
                                                                    <div class="rate-product">
                                                                        <p class="p-rate-product"><?= trans("rate_this_product"); ?></p>
                                                                        <div class="rating-stars">
                                                                            <?php $review = getReview($item->product_id, user()->id); ?>
                                                                            <label class="label-star label-star-open-modal label-rating-<?= $item->product_id; ?>" data-star="5" data-product-id="<?= $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?= !empty($review) && $review->rating >= 5 ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal label-rating-<?= $item->product_id; ?>" data-star="4" data-product-id="<?= $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?= !empty($review) && $review->rating >= 4 ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal label-rating-<?= $item->product_id; ?>" data-star="3" data-product-id="<?= $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?= !empty($review) && $review->rating >= 3 ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal label-rating-<?= $item->product_id; ?>" data-star="2" data-product-id="<?= $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?= !empty($review) && $review->rating >= 2 ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal label-rating-<?= $item->product_id; ?>" data-star="1" data-product-id="<?= $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?= !empty($review) && $review->rating >= 1 ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif;
                                                        endif; ?>
                                                    </td>
                                                </tr>
                                                <?php if ($item->product_type == 'physical'): ?>
                                                <tr class="tr-shipping">
                                                    <td colspan="4">
                                                        <div class="order-shipping-tracking-number">
                                                            <p><strong><?= trans("shipping") ?></strong></p>
                                                            <p class="font-600 m-t-5"><?= trans("shipping_method") ?>:&nbsp;<?= esc($item->shipping_method); ?></p>
                                                            <?php if ($item->order_status == 'shipped'): ?>
                                                                <p class="font-600 m-t-15"><?= trans("order_has_been_shipped"); ?></p>
                                                                <p><?= trans("tracking_code") ?>:&nbsp;<?= esc($item->shipping_tracking_number); ?></p>
                                                                <p class="m-0"><?= trans("tracking_url") ?>: <a href="<?= esc($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?= esc($item->shipping_tracking_url); ?></a></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif;
                                                $i++;
                                            endforeach;
                                        endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="order-total">
                                    <div class="row">
                                        <div class="col-6 col-left">
                                            <?= trans("subtotal"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong><?= priceFormatted($order->price_subtotal, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                    <?php $affiliate = unserializeData($order->affiliate_data);
                                    if (!empty($affiliate) && !empty($affiliate['discount'])): ?>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?= trans("referral_discount"); ?>&nbsp;(<?= $affiliate['discountRate']; ?>%)
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong>-&nbsp;<?= priceCurrencyFormat($affiliate['discount'], $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($order->price_vat)): ?>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?= trans("vat"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong><?= priceFormatted($order->price_vat, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($isOrderHasPhysicalProduct): ?>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?= trans("shipping"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong><?= priceFormatted($order->price_shipping, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($order->coupon_discount > 0): ?>
                                        <div class="row row-details">
                                            <div class="col-xs-12 col-sm-6 col-left">
                                                <strong><?= trans("coupon"); ?>&nbsp;&nbsp;[<?= esc($order->coupon_code); ?>]</strong>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-right text-right">
                                                <strong class="font-right">-&nbsp;<?= priceFormatted($order->coupon_discount, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif;
                                    if (!empty($order->global_taxes_data)):
                                        $globalTaxesArray = unserializeData($order->global_taxes_data);
                                        if (!empty($globalTaxesArray)):
                                            foreach ($globalTaxesArray as $taxItem):
                                                if (!empty($taxItem['taxNameArray']) && is_string($taxItem['taxNameArray'])):?>
                                                    <div class="row">
                                                        <div class="col-6 col-left">
                                                            <?= esc(getTaxName($taxItem['taxNameArray'], selectedLangId())); ?>&nbsp;(<?= $taxItem['taxRate']; ?>%)
                                                        </div>
                                                        <div class="col-6 col-right">
                                                            <strong><?= priceDecimal($taxItem['taxTotal'], $order->price_currency); ?></strong>
                                                        </div>
                                                    </div>
                                                <?php endif;
                                            endforeach;
                                        endif;
                                    endif;
                                    if (!empty($order->transaction_fee)): ?>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?= trans("transaction_fee"); ?><?= $order->transaction_fee_rate ? ' (' . $order->transaction_fee_rate . '%)' : ''; ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong><?= priceFormatted($order->transaction_fee, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row-seperator"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-left">
                                            <?= trans("total"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <?php $priceSecondCurrency = '';
                                            $transaction = getTransactionByOrderId($order->id);
                                            if (!empty($transaction) && $transaction->currency != $order->price_currency):
                                                $priceSecondCurrency = priceCurrencyFormat($transaction->payment_amount, $transaction->currency);
                                            endif; ?>
                                            <strong>
                                                <?= priceFormatted($order->price_total, $order->price_currency);
                                                if (!empty($priceSecondCurrency)):?>
                                                    <br><span style="font-weight: 400;white-space: nowrap;">(<?= trans("paid"); ?>:&nbsp;<?= $priceSecondCurrency; ?>&nbsp;<?= $transaction->currency; ?>)</span>
                                                <?php endif; ?>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($order->payment_method != 'Cash On Delivery' || $order->payment_status == 'payment_received'):
                    if (!empty($shipping)): ?>
                        <p class="text-confirm-order">*<?= trans("confirm_order_received_warning"); ?></p>
                    <?php endif;
                endif;
                if ($order->payment_method == 'Cash On Delivery' && dateDifferenceInHours(date('Y-m-d H:i:s'), $order->created_at) <= 24):
                    if ($order->status != 2):?>
                        <p class="text-confirm-order text-danger">*<?= trans("cod_cancel_exp"); ?></p>
                    <?php endif;
                endif; ?>
            </div>
        </div>
    </div>
</div>

<?= view('partials/_modal_rate_product'); ?>
<?= view('partials/_modal_bank_transfer', ['modalBankTransferId' => 'reportBankTransferModal', 'reportType' => 'order', 'reportItemId' => $order->id, 'orderNumber' => $order->order_number]); ?>