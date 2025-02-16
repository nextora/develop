<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?= trans("summary"); ?></h2>
    <div class="right">
        <?php if (!empty($servicePayment)): ?>
            <div class="row-custom m-b-15"><strong><?= $servicePayment->paymentName; ?></strong></div>
            <?php
            if ($servicePayment->paymentType == 'membership'):
                $plan = getMembershipPlan($servicePayment->planId);
                if (!empty($plan)): ?>
                    <div class="cart-order-details">
                        <div class="item">
                            <div class="item-right">
                                <div class="list-item m-t-15">
                                    <label><?= trans("membership_plan"); ?>:</label>
                                    <strong class="lbl-price"><?= getMembershipPlanName($plan->title_array, selectedLangId()); ?></strong>
                                </div>
                                <div class="list-item">
                                    <label><?= trans("price"); ?>:</label>
                                    <strong class="lbl-price"><?= priceDecimal($servicePayment->paymentAmountBeforeTaxes, $selectedCurrency->code, true); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            elseif ($servicePayment->paymentType == 'promote'):
                $product = getActiveProduct($servicePayment->productId);
                if (!empty($product)):?>
                    <div class="cart-order-details">
                        <div class="item">
                            <div class="item-left">
                                <div class="img-cart-product">
                                    <a href="<?= generateProductUrl($product); ?>">
                                        <img src="<?= base_url(IMG_BG_PRODUCT_SMALL); ?>" data-src="<?= getProductMainImage($product->id, 'image_small'); ?>" alt="<?= getProductTitle($product); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?= base_url(IMG_BG_PRODUCT_SMALL); ?>'">
                                    </a>
                                </div>
                            </div>
                            <div class="item-right">
                                <div class="list-item">
                                    <a href="<?= generateProductUrl($product); ?>"><?= getProductTitle($product); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-right">
                                <div class="list-item m-t-15">
                                    <label><?= trans("promote_plan"); ?>:</label>
                                    <strong class="lbl-price"><?= $servicePayment->purchasedPlan; ?></strong>
                                </div>
                                <div class="list-item">
                                    <label><?= trans("price"); ?>:</label>
                                    <strong class="lbl-price"><?= priceDecimal($servicePayment->paymentAmountBeforeTaxes, $servicePayment->currency); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            elseif ($servicePayment->paymentType == 'add_funds'): ?>
                <div class="cart-order-details">
                    <div class="item">
                        <div class="item-right">
                            <div class="list-item">
                                <label><?= trans("deposit_amount"); ?>:</label>
                                <strong class="lbl-price"><?= priceDecimal($servicePayment->paymentAmount, $servicePayment->currency, true); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
        endif; ?>
        <div class="row-custom m-t-30 m-b-10">
            <strong><?= trans("subtotal"); ?><span class="float-right"><?= priceDecimal($servicePayment->paymentAmountBeforeTaxes, $selectedCurrency->code, true); ?></span></strong>
        </div>
        <?php if (!empty($servicePayment->globalTaxesArray)):
            foreach ($servicePayment->globalTaxesArray as $taxItem):?>
                <div class="row-custom m-b-10">
                    <strong><?= esc(getTaxName($taxItem['taxNameArray'], selectedLangId())); ?>&nbsp;(<?= $taxItem['taxRate']; ?>%)<span class="float-right"><?= priceDecimal($taxItem['taxTotal'], $selectedCurrency->code, true); ?></span></strong>
                </div>
            <?php endforeach;
        endif; ?>
        <div class="row-custom">
            <p class="line-seperator"></p>
        </div>
        <div class="row-custom">
            <strong><?= trans("total"); ?><span class="float-right"><?= priceDecimal($servicePayment->paymentAmount, $selectedCurrency->code, true); ?></span></strong>
        </div>
    </div>
</div>