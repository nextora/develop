<?php $imgSecond = getProductItemImage($product, true); ?>
<div class="product-item">
    <div class="row-custom<?= !empty($imgSecond) ? ' row-img-product-list' : ''; ?>">
        <div class="product-item-options">
            <button type="button" class="item-option btn-add-remove-wishlist" data-toggle="tooltip" data-placement="left" data-product-id="<?= $product->id; ?>" data-type="list" title="<?= trans("wishlist"); ?>" aria-label="add-remove-wishlist">
                <?php if (isProductInWishlist($product) == 1): ?>
                    <i class="icon-heart"></i>
                <?php else: ?>
                    <i class="icon-heart-o"></i>
                <?php endif; ?>
            </button>
            <?php if (($product->listing_type == 'sell_on_site' || $product->listing_type == 'bidding') && $product->is_free_product != 1):
                if (!empty($product->has_variation) || $product->listing_type == 'bidding'):?>
                    <a href="<?= generateProductUrl($product); ?>" class="item-option" data-toggle="tooltip" data-placement="left" data-product-id="<?= $product->id; ?>" data-reload="0" title="<?= trans("view_options"); ?>" aria-label="<?= trans("view_options"); ?>">
                        <i class="icon-cart"></i>
                    </a>
                <?php else:
                    $itemUniqueID = uniqid();
                    if ($product->stock > 0):?>
                        <button type="button" id="btn_add_cart_<?= $itemUniqueID; ?>" class="item-option btn-item-add-to-cart" data-id="<?= $itemUniqueID; ?>" data-toggle="tooltip" data-placement="left" data-product-id="<?= $product->id; ?>" data-reload="0" title="<?= trans("add_to_cart"); ?>" aria-label="add-to-cart">
                            <i class="icon-cart"></i>
                        </button>
                    <?php endif;
                endif;
            endif; ?>
        </div>
        <?php if (!empty($product->discount_rate) && !empty($discountLabel)): ?>
            <span class="badge badge-discount">-<?= $product->discount_rate; ?>%</span>
        <?php endif; ?>
        <div class="ratio ratio-product-box">
            <?php if (!empty($isSlider)): ?>
                <a href="<?= generateProductUrl($product); ?>">
                    <img src="<?= IMG_BASE64_1x1; ?>" data-lazy="<?= getProductItemImage($product); ?>" data-first="<?= getProductItemImage($product); ?>" data-second="<?= $imgSecond; ?>" class="img-fluid img-product" width="242" height="256" alt="<?= getProductTitle($product); ?>">
                </a>
            <?php else: ?>
                <a href="<?= generateProductUrl($product); ?>">
                    <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getProductItemImage($product); ?>" data-first="<?= getProductItemImage($product); ?>" data-second="<?= $imgSecond; ?>" class="lazyload img-fluid img-product" width="242" height="256" alt="<?= getProductTitle($product); ?>">
                </a>
            <?php endif; ?>
        </div>
        <?php if ($product->is_promoted && $generalSettings->promoted_products == 1 && !empty($promotedBadge)): ?>
            <span class="badge badge-dark badge-promoted"><?= trans("featured"); ?></span>
        <?php endif; ?>
    </div>
    <div class="row-custom item-details">
        <h3 class="product-title">
            <a href="<?= generateProductUrl($product); ?>"><?= getProductTitle($product); ?></a>
        </h3>
        <div class="product-user text-truncate">
            <a href="<?= generateProfileUrl($product->user_slug, true); ?>"><?= esc($product->user_username); ?></a>
        </div>
        <div class="product-item-rating">
            <?php if ($generalSettings->reviews == 1):
                echo view('partials/_review_stars', ['rating' => $product->rating]);
            endif; ?>
            <span class="item-wishlist"><i class="icon-heart-o"></i><?= numberFormatShort($product->wishlist_count); ?></span>
        </div>
        <div class="item-meta">
            <?= view('product/_price_product_item', ['product' => $product]); ?>
        </div>
    </div>
</div>