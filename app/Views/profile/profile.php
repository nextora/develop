<?= view('profile/_cover_image'); ?>
<div id="wrapper">
    <div class="container">
        <?php if (empty($user->cover_image)): ?>
            <div class="row">
                <div class="col-12">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= trans("profile"); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <?= view('profile/_profile_user_info'); ?>
                    <div class="row-custom report-seller-sidebar-mobile">
                        <?php if (authCheck()):
                            if ($user->id != user()->id):?>
                                <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-toggle="modal" data-target="#reportSellerModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512" fill="currentColor">
                                        <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                                    </svg>&nbsp;<?= trans("report_this_seller"); ?>
                                </button>
                            <?php endif;
                        else: ?>
                            <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-toggle="modal" data-target="#loginModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512" fill="currentColor">
                                    <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                                </svg>&nbsp;<?= trans("report_this_seller"); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= view('profile/_tabs'); ?>
            </div>
            <?php if (isVendor($user)):
                if (isAdmin() || $generalSettings->multi_vendor_system == 1):?>
                    <div class="col-12">
                        <?php if ($user->vacation_mode == 1): ?>
                            <div class="sidebar-tabs-content">
                                <div class="alert alert-info alert-large">
                                    <strong><?= trans("vendor_on_vacation"); ?>!</strong>&nbsp;&nbsp;<?= trans("vendor_on_vacation_exp"); ?>
                                </div>
                                <div class="m-t-30">
                                    <?= $user->vacation_message; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="sidebar-tabs-content">
                                <div class="row">
                                    <div class="col-12 m-b-20 container-filter-products-mobile">
                                        <div class="btn-filter-products-mobile">
                                            <button class="btn btn-md" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#666666" viewBox="0 0 256 256">
                                                    <path d="M200,136a8,8,0,0,1-8,8H64a8,8,0,0,1,0-16H192A8,8,0,0,1,200,136Zm32-56H24a8,8,0,0,0,0,16H232a8,8,0,0,0,0-16Zm-80,96H104a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Z"></path>
                                                </svg>&nbsp;&nbsp;<span class="text"><?= trans("filter_products"); ?></span>
                                            </button>
                                        </div>
                                        <div class="product-sort-by">
                                            <?php $filterSort = strSlug(inputGet('sort'));
                                            if ($filterSort != "most_recent" && $filterSort != "lowest_price" && $filterSort != "highest_price" && $filterSort != "highest_rating"):
                                                $filterSort = 'most_recent';
                                            endif; ?>
                                            <div class="dropdown">
                                                <button class="btn btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                        <path fill="#666666" d="M13.47 7.53a.75.75 0 0 0 1.06 0l.72-.72V17a.75.75 0 0 0 1.5 0V6.81l.72.72a.75.75 0 1 0 1.06-1.06l-2-2a.75.75 0 0 0-1.06 0l-2 2a.75.75 0 0 0 0 1.06m-4.72 9.66l.72-.72a.75.75 0 1 1 1.06 1.06l-2 2a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l.72.72V7a.75.75 0 0 1 1.5 0z"/>
                                                    </svg>&nbsp;&nbsp;<?= trans($filterSort); ?>&nbsp;&nbsp;<i class="icon-arrow-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdownSortOptions">
                                                    <button type="button" class="dropdown-item" data-action="most_recent"><?= trans("most_recent"); ?></button>
                                                    <button type="button" class="dropdown-item" data-action="lowest_price"><?= trans("lowest_price"); ?></button>
                                                    <button type="button" class="dropdown-item" data-action="highest_price"><?= trans("highest_price"); ?></button>
                                                    <button type="button" class="dropdown-item" data-action="highest_rating"><?= trans("highest_rating"); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 col-sidebar-products">
                                        <div class="sticky-lg-top">
                                            <div id="collapseFilters" class="product-filters">
                                                <?php if (!empty($categories) && !empty($categories[0])):
                                                    $categoryId = 0; ?>
                                                    <div class="filter-item filter-item-categories">
                                                        <h4 class="title"><?= trans("category"); ?></h4>
                                                        <?php if (!empty($category)):
                                                            $categoryId = $category->id;
                                                            $url = generateProfileUrl($user->slug) . generateFilterUrl($queryStringArray, 'rmv_p_cat', '');
                                                            if (!empty($parentCategory)) {
                                                                $url = generateProfileUrl($user->slug) . generateFilterUrl($queryStringArray, 'p_cat', $parentCategory->id);
                                                            } ?>
                                                            <a href="<?= $url . '#products'; ?>" class="filter-list-categories-parent">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                                                                </svg>
                                                                <span><?= getCategoryName($category, $activeLang->id); ?></span>
                                                            </a>
                                                        <?php endif; ?>
                                                        <div class="filter-list-container">
                                                            <ul class="filter-list filter-custom-scrollbar<?= !empty($category) ? ' filter-list-subcategories' : ' filter-list-categories'; ?>">
                                                                <?php foreach ($categories as $item):
                                                                    if ($categoryId != $item->id):?>
                                                                        <li>
                                                                            <a href="<?= generateProfileUrl($user->slug) . generateFilterUrl($queryStringArray, 'p_cat', $item->id) . '#products'; ?>" <?= !empty($category) && $category->id == $item->id ? 'class="active"' : ''; ?>><?= getCategoryName($item, $activeLang->id); ?></a>
                                                                        </li>
                                                                    <?php endif;
                                                                endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                <?php endif;
                                                if ($generalSettings->marketplace_system == 1 || $generalSettings->bidding_system == 1 || $productSettings->classified_price == 1):
                                                    $filterPmin = esc(inputGet('p_min'));
                                                    $filterPmax = esc(inputGet('p_max')); ?>
                                                    <div class="filter-item border-0">
                                                        <h4 class="title"><?= trans("price"); ?></h4>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="d-flex justify-content-between inputs-filter-price">
                                                                    <input type="number" id="price_min" value="<?= !empty($filterPmin) ? $filterPmin : ''; ?>" class="min-price form-control form-input" placeholder="<?= trans("min"); ?>" min="0" step="0.1">
                                                                    <span>-</span>
                                                                    <input type="number" id="price_max" value="<?= !empty($filterPmax) ? $filterPmax : ''; ?>" class="max-price form-control form-input" placeholder="<?= trans("max"); ?>" min="0" step="0.1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="filter-item">
                                                    <h4 class="title"><?= trans("filter_by_keyword"); ?></h4>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" id="input_filter_keyword" value="<?= esc(removeSpecialCharacters(urldecode(inputGet('search') ?? ''))); ?>" class="form-control form-input" placeholder="<?= trans("keyword"); ?>">
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button" id="btnFilterByKeyword" class="btn btn-md btn-filter-product"><i class="icon-search"></i>&nbsp;<?= trans("filter"); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-custom report-seller-sidebar">
                                                <?php if (authCheck()):
                                                    if ($user->id != user()->id):?>
                                                        <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-toggle="modal" data-target="#reportSellerModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512" fill="currentColor">
                                                                <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                                                            </svg>&nbsp;<?= trans("report_this_seller"); ?>
                                                        </button>
                                                    <?php endif;
                                                else: ?>
                                                    <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-toggle="modal" data-target="#loginModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512" fill="currentColor">
                                                            <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                                                        </svg>&nbsp;<?= trans("report_this_seller"); ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row-custom">
                                                <?= view('partials/_ad_spaces', ['adSpace' => 'profile_sidebar', 'class' => 'm-t-30']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="productListProfile" class="col-12 col-md-9 col-content-products">
                                        <div class="clearfix container-filter-products m-b-20">
                                            <div class="product-sort-by">
                                                <?php $filterSort = strSlug(inputGet('sort'));
                                                if ($filterSort != "most_recent" && $filterSort != "lowest_price" && $filterSort != "highest_price" && $filterSort != "highest_rating"):
                                                    $filterSort = 'most_recent';
                                                endif; ?>
                                                <div class="dropdown">
                                                    <button class="btn btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                            <path fill="#666666" d="M13.47 7.53a.75.75 0 0 0 1.06 0l.72-.72V17a.75.75 0 0 0 1.5 0V6.81l.72.72a.75.75 0 1 0 1.06-1.06l-2-2a.75.75 0 0 0-1.06 0l-2 2a.75.75 0 0 0 0 1.06m-4.72 9.66l.72-.72a.75.75 0 1 1 1.06 1.06l-2 2a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l.72.72V7a.75.75 0 0 1 1.5 0z"/>
                                                        </svg>&nbsp;&nbsp;<?= trans($filterSort); ?>&nbsp;&nbsp;<i class="icon-arrow-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdownSortOptions">
                                                        <button type="button" class="dropdown-item" data-action="most_recent"><?= trans("most_recent"); ?></button>
                                                        <button type="button" class="dropdown-item" data-action="lowest_price"><?= trans("lowest_price"); ?></button>
                                                        <button type="button" class="dropdown-item" data-action="highest_price"><?= trans("highest_price"); ?></button>
                                                        <button type="button" class="dropdown-item" data-action="highest_rating"><?= trans("highest_rating"); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="filter-reset-tag-container">
                                                    <?php if (!empty($queryStringObjectArray)):
                                                        foreach ($queryStringObjectArray as $filter):
                                                            if ($filter->key != 'sort' && $filter->key != 'p_cat'):
                                                                $filterDeleteUrl = current_url() . generateFilterUrl($queryStringArray, $filter->key, $filter->value) . '#products';
                                                                $showResetLink = true;
                                                                if ($filter->key == 'v_coupon'):
                                                                    $showResetLink = false;
                                                                    if (!empty($coupon)): ?>
                                                                        <div class="filter-reset-tag">
                                                                            <div class="left">
                                                                                <a href="<?= $filterDeleteUrl; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                            </div>
                                                                            <div class="right">
                                                                                <span class="reset-tag-title"><?= trans("coupon"); ?></span>
                                                                                <span><?= esc($coupon->coupon_code); ?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif;
                                                                elseif ($filter->key == "p_min"): ?>
                                                                    <div class="filter-reset-tag">
                                                                        <div class="left">
                                                                            <a href="<?= $filterDeleteUrl; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                        </div>
                                                                        <div class="right">
                                                                            <span class="reset-tag-title"><?= trans("price") . ' (' . $selectedCurrency->symbol . ')'; ?></span>
                                                                            <span><?= trans("min") . ': ' . esc($filter->value); ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php elseif ($filter->key == "p_max"): ?>
                                                                    <div class="filter-reset-tag">
                                                                        <div class="left">
                                                                            <a href="<?= $filterDeleteUrl; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                        </div>
                                                                        <div class="right">
                                                                            <span class="reset-tag-title"><?= trans("price") . ' (' . $selectedCurrency->symbol . ')'; ?></span>
                                                                            <span><?= trans("max") . ': ' . esc($filter->value); ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php elseif ($filter->key == 'search'): ?>
                                                                    <div class="filter-reset-tag">
                                                                        <div class="left">
                                                                            <a href="<?= $filterDeleteUrl; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                        </div>
                                                                        <div class="right">
                                                                            <span class="reset-tag-title"><?= trans("search"); ?></span>
                                                                            <span><?= esc($filter->value); ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php endif;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                    if (!empty($showResetLink) || !empty($coupon)): ?>
                                                        <a href="<?= current_url() . "#products"; ?>" class="link-reset-filters" rel="nofollow"><?= trans("reset_filters"); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (!empty($products) && getValidPageNumber(inputGet('page')) > 1): ?>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <button type="button" id="btnShowPreviousProducts" class="btn btn-lg btn-show-previous-products"><?= trans("show_previous_products"); ?></button>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div id="productListContent" class="product-list-content" data-category="<?= !empty($category) ? $category->id : ''; ?>" data-has-more="<?= countItems($products) > $productSettings->pagination_per_page ? 1 : 0; ?>" data-user-id="<?= $user->id; ?>" data-coupon-id="<?= !empty($coupon) ? $coupon->id : ''; ?>">
                                            <div id="productListResultContainer" class="row row-product">
                                                <?php $i = 0;
                                                if (!empty($products)):
                                                    foreach ($products as $product):
                                                        if ($i < $productSettings->pagination_per_page):
                                                            if ($i == 8):
                                                                echo view('partials/_ad_spaces', ['adSpace' => 'products_1', 'class' => 'mb-4']);
                                                            endif; ?>
                                                            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
                                                                <?= view('product/_product_item', ['product' => $product, 'promotedBadge' => true]); ?>
                                                            </div>
                                                        <?php endif;
                                                        $i++;
                                                    endforeach;
                                                endif;
                                                if (empty($products)): ?>
                                                    <div class="col-12">
                                                        <p class="no-records-found"><?= trans("no_products_found"); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div id="loadProductsSpinner" class="col-12 load-more-spinner">
                                                <div class="row">
                                                    <div class="spinner">
                                                        <div class="bounce1"></div>
                                                        <div class="bounce2"></div>
                                                        <div class="bounce3"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?= view('partials/_ad_spaces', ['adSpace' => 'products_2', 'class' => 'mt-3']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif;
            else: ?>
                <div class="col-12">
                    <div class="sidebar-tabs-content"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (authCheck() && !empty($user) && $user->id != user()->id): ?>
    <div class="modal fade" id="reportSellerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom modal-report-abuse">
                <form id="form_report_seller" method="post">
                    <input type="hidden" name="id" value="<?= $user->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= trans("report_this_seller"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="response_form_report_seller" class="col-12"></div>
                            <div class="col-12">
                                <div class="form-group m-0">
                                    <label class="control-label"><?= trans("description"); ?></label>
                                    <textarea name="description" class="form-control form-textarea" placeholder="<?= trans("abuse_report_exp"); ?>" minlength="5" maxlength="10000" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-md btn-custom"><?= trans("submit"); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    var pagination_links = document.querySelectorAll(".pagination a");
    var i;
    for (i = 0; i < pagination_links.length; i++) {
        pagination_links[i].href = pagination_links[i].href + "#products";
    }
</script>

