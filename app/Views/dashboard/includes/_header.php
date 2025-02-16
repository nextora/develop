<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= escSls($title); ?> - <?= trans("dashboard"); ?> - <?= escSls($generalSettings->application_name); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>"/>
    <?= csrf_meta(); ?>
    <?= view('dashboard/includes/_fonts'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/datatables/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/datatables/jquery.dataTables_themeroller.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/pace/pace.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/magnific-popup/magnific-popup.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/plugins-2.5.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/skin-black-light.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/file-uploader/css/jquery.dm-uploader.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/file-uploader/css/styles.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/file-manager/file-manager.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/main-2.5.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/dashboard-2.5.min.css'); ?>">
    <?php if ($baseVars->rtl == true): ?>
        <link rel="stylesheet" href="<?= base_url('assets/admin/css/rtl-2.5.min.css'); ?>">
    <?php endif; ?>
    <script src="<?= base_url('assets/admin/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/file-uploader/js/jquery.dm-uploader.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/file-uploader/js/ui.js'); ?>"></script>
    <script>
        var MdsConfig = {
            baseURL: '<?= base_url(); ?>',
            csrfTokenName: '<?= csrf_token() ?>',
            sysLangId: '<?= $activeLang->id; ?>',
            directionality: <?= $baseVars->rtl ? 'true' : 'false'; ?>,
            thousandsSeparator: '<?= $baseVars->thousandsSeparator;?>',
            commissionRate: '<?= $paymentSettings->commission_rate; ?>',
            imageUploadLimit: parseInt('<?= $productSettings->product_image_limit; ?>'),
            textOk: "<?= trans("ok", true); ?>",
            textCancel: "<?= trans("cancel", true); ?>",
            textNone: "<?= trans("none", true); ?>",
            textProcessing: "<?= trans("processing", true); ?>",
            textNoResultsFound: "<?= trans("no_results_found", true); ?>",
            textAcceptTerms: "<?= trans("msg_accept_terms", true); ?>",
            textTagInput: "<?= clrDoubleQuotes(trans("type_tag")); ?>"
        }
    </script>
</head>
<body class="hold-transition skin-black-light sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <div class="main-header-inner">
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?= langBaseUrl(); ?>"><i class="fa fa-eye"></i> &nbsp;<span class="btn-site-prev-text"><?= trans("view_site"); ?></span></a>
                        </li>
                        <?php if ($generalSettings->multilingual_system == 1 && countItems($activeLanguages) > 1): ?>
                            <li class="nav-item dropdown language-dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    <img src="<?= base_url($activeLang->flag_path); ?>" class="flag"><?= esc($activeLang->name); ?> <i class="fa fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <?php if (!empty($activeLanguages)):
                                        foreach ($activeLanguages as $language): ?>
                                            <a href="<?= convertUrlByLanguage($language); ?>" class="<?= $language->id == $activeLang->id ? 'selected' : ''; ?> " class="dropdown-item">
                                                <img src="<?= base_url($language->flag_path); ?>" class="flag"><?= $language->name; ?>
                                            </a>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?= getUserAvatar(user()); ?>" class="user-image" alt="">
                                <span class="hidden-xs"><?= esc(getUsername(user())); ?></span>&nbsp;<i class="fa fa-caret-down caret-profile"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-main pull-right" role="menu" aria-labelledby="user-options">
                                <?php if (hasPermission('admin_panel')): ?>
                                    <li>
                                        <a href="<?= adminUrl(); ?>">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none"/>
                                                    <polyline points="32 176 128 232 224 176" fill="none" stroke="#747474" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                    <polyline points="32 128 128 184 224 128" fill="none" stroke="#747474" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                    <polygon points="32 80 128 136 224 80 128 24 32 80" fill="none" stroke="#747474" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                </svg>
                                            </div><?= trans("admin_panel"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?= generateProfileUrl(user()->slug); ?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="19" height="19" color="#747474" fill="none">
                                                <path d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z" stroke="#747474" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="#747474" stroke-width="1.5"/>
                                            </svg>
                                        </div><?= trans("profile"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= generateUrl('wallet'); ?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18.8" height="18.8" viewBox="0 0 24 24">
                                                <path stroke="#747474" stroke-width="0.5" fill="#747474" d="M19.5 7H18V6a3.003 3.003 0 0 0-3-3H4.5A2.5 2.5 0 0 0 2 5.5V18a3.003 3.003 0 0 0 3 3h14.5a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 19.5 7m-15-3H15a2.003 2.003 0 0 1 2 2v1H4.5a1.5 1.5 0 1 1 0-3M21 16h-2a2 2 0 0 1 0-4h2zm0-5h-2a3 3 0 1 0 0 6h2v1.5a1.5 1.5 0 0 1-1.5 1.5H5a2.003 2.003 0 0 1-2-2V7.499c.432.326.959.502 1.5.501h15A1.5 1.5 0 0 1 21 9.5z"/>
                                            </svg>
                                        </div><?= trans("wallet"); ?>
                                    </a>
                                </li>
                                <?php if (isSaleActive()): ?>
                                    <li>
                                        <a href="<?= generateUrl('orders'); ?>">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
                                                    <path d="M136,120v56a8,8,0,0,1-16,0V120a8,8,0,0,1,16,0Zm36.84-.8-5.6,56A8,8,0,0,0,174.4,184a7.32,7.32,0,0,0,.81,0,8,8,0,0,0,7.95-7.2l5.6-56a8,8,0,0,0-15.92-1.6Zm-89.68,0a8,8,0,0,0-15.92,1.6l5.6,56a8,8,0,0,0,8,7.2,7.32,7.32,0,0,0,.81,0,8,8,0,0,0,7.16-8.76ZM239.93,89.06,224.86,202.12A16.06,16.06,0,0,1,209,216H47a16.06,16.06,0,0,1-15.86-13.88L16.07,89.06A8,8,0,0,1,24,80H68.37L122,18.73a8,8,0,0,1,12,0L187.63,80H232a8,8,0,0,1,7.93,9.06ZM89.63,80h76.74L128,36.15ZM222.86,96H33.14L47,200H209Z"></path>
                                                </svg>
                                            </div><?= trans("orders"); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= generateUrl('my_coupons'); ?>">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="19" height="19" color="#747474" fill="none">
                                                    <circle cx="1.5" cy="1.5" r="1.5" transform="matrix(1 0 0 -1 16 8.00024)" stroke="#747474" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M2.77423 11.1439C1.77108 12.2643 1.7495 13.9546 2.67016 15.1437C4.49711 17.5033 6.49674 19.5029 8.85633 21.3298C10.0454 22.2505 11.7357 22.2289 12.8561 21.2258C15.8979 18.5022 18.6835 15.6559 21.3719 12.5279C21.6377 12.2187 21.8039 11.8397 21.8412 11.4336C22.0062 9.63798 22.3452 4.46467 20.9403 3.05974C19.5353 1.65481 14.362 1.99377 12.5664 2.15876C12.1603 2.19608 11.7813 2.36233 11.472 2.62811C8.34412 5.31646 5.49781 8.10211 2.77423 11.1439Z" stroke="#747474" stroke-width="1.5"/>
                                                    <path d="M7.00002 14.0002L10 17.0002" stroke="#747474" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div><?= trans("my_coupons"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?= generateUrl('messages'); ?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 32 32">
                                                <path fill="#747474" d="M17.74 30L16 29l4-7h6a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9v2H6a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4h-4.84Z"/>
                                                <path fill="#747474" d="M8 10h16v2H8zm0 6h10v2H8z"/>
                                            </svg>
                                        </div><?= trans("messages"); ?>&nbsp;
                                        <?php $unreadMessageCount = getUnreadChatsCount(user()->id);
                                        if ($unreadMessageCount > 0): ?>
                                            (<?= $unreadMessageCount; ?>)
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= generateUrl('settings', 'edit_profile'); ?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
                                                <path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"></path>
                                            </svg>
                                        </div><?= trans("profile_settings"); ?>
                                    </a>
                                </li>
                                <li>
                                    <form action="<?= base_url('logout'); ?>" method="post" class="form-logout">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
                                        <button type="submit" class="btn-logout" aria-label="btn-logout">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
                                                    <path d="M120,216a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H56V208h56A8,8,0,0,1,120,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L204.69,120H112a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,229.66,122.34Z"></path>
                                                </svg>
                                            </div><?= trans("logout"); ?>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="sidebar-scrollbar">
                <div class="logo">
                    <a href="<?= dashboardUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo"></a>
                </div>
                <div class="user-panel">
                    <div class="image">
                        <img src="<?= getUserAvatar(user()); ?>" class="img-circle" alt="">
                    </div>
                    <div class="username">
                        <p><?= trans("hi") . ', ' . esc(getUsername(user())); ?></p>
                    </div>
                </div>
                <?php if (isVendor()): ?>
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header"><?= trans("navigation"); ?></li>
                        <li class="nav-home">
                            <a href="<?= dashboardUrl(); ?>">
                                <i class="fa fa-home"></i> <span><?= trans("dashboard"); ?></span>
                            </a>
                        </li>
                        <li class="header"><?= trans("products"); ?></li>
                        <li class="nav-add-product">
                            <a href="<?= generateDashUrl('add_product'); ?>">
                                <i class="fa fa-file"></i>
                                <span><?= trans("add_product"); ?></span>
                            </a>
                        </li>
                        <?php if (hasPermission('products') || (!hasPermission('products') && $generalSettings->vendor_bulk_product_upload == 1)): ?>
                            <li class="nav-bulk-product-upload">
                                <a href="<?= generateDashUrl("bulk_product_upload"); ?>">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span><?= trans("bulk_product_upload"); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="treeview<?php isAdminNavActive(['products', 'pending-products', 'hidden-products', 'sold-products', 'drafts']); ?>">
                            <a href="#">
                                <i class="fa fa-shopping-basket"></i>
                                <span><?= trans("products"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-products"><a href="<?= generateDashUrl('products'); ?>"><?= trans("products"); ?></a></li>
                                <li class="nav-pending-products"><a href="<?= generateDashUrl('products'); ?>?st=pending"><?= trans("pending_products"); ?></a></li>
                                <li class="nav-hidden-products"><a href="<?= generateDashUrl('products'); ?>?st=hidden"><?= trans("hidden_products"); ?></a></li>
                                <li class="nav-sold-products"><a href="<?= generateDashUrl('products'); ?>?st=sold"><?= trans("sold_products"); ?></a></li>
                                <li class="nav-drafts"><a href="<?= generateDashUrl('products'); ?>?st=draft"><?= trans("drafts"); ?></a></li>
                            </ul>
                        </li>
                        <?php if ($baseVars->isSaleActive): ?>
                            <li class="header"><?= trans("sales"); ?></li>
                            <li class="treeview<?php isAdminNavActive(['sales', 'completed-sales', 'cancelled-sales', 'sale']); ?>">
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span><?= trans("sales"); ?></span>
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="nav-sales"><a href="<?= generateDashUrl('sales'); ?>"><?= trans("active_sales"); ?></a></li>
                                    <li class="nav-completed-sales"><a href="<?= generateDashUrl('sales'); ?>?st=completed"><?= trans("completed_sales"); ?></a></li>
                                    <li class="nav-cancelled-sales"><a href="<?= generateDashUrl('sales'); ?>?st=cancelled"><?= trans("cancelled_sales"); ?></a></li>
                                </ul>
                            </li>
                        <?php endif;
                        if ($generalSettings->bidding_system == 1): ?>
                            <li class="nav-quote-requests">
                                <a href="<?= generateDashUrl('quote_requests'); ?>">
                                    <i class="fa fa-tag"></i>
                                    <span><?= trans("quote_requests"); ?></span>
                                    <?php $newQuoteCount = getNewQuoteRequestsCount(user()->id);
                                    if (!empty($newQuoteCount)):?>
                                        <span class="pull-right-container">
                              <small class="label label-success pull-right"><?= $newQuoteCount; ?></small>
                            </span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif;
                        if ($baseVars->isSaleActive): ?>
                            <li class="nav-coupons">
                                <a href="<?= generateDashUrl("coupons"); ?>">
                                    <i class="fa fa-ticket"></i>
                                    <span><?= trans("coupons"); ?></span>
                                </a>
                            </li>
                            <?php if ($generalSettings->refund_system == 1): ?>
                                <li class="nav-refund-requests">
                                    <a href="<?= generateDashUrl("refund_requests"); ?>">
                                        <i class="fa fa-flag"></i>
                                        <span><?= trans("refund_requests"); ?></span>
                                        <?php $refundCount = getSellerActiveRefundRequestCount(user()->id);
                                        if (!empty($refundCount)):?>
                                            <span class="pull-right-container">
                              <small class="label label-success pull-right"><?= $refundCount; ?></small>
                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif;
                        endif;
                        if ($paymentSettings->cash_on_delivery_enabled == 1): ?>
                            <li class="nav-cash-on-delivery">
                                <a href="<?= generateDashUrl('cash_on_delivery'); ?>">
                                    <i class="fa fa-money"></i>
                                    <span><?= trans("cash_on_delivery"); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="header"><?= trans("payments"); ?></li>
                        <li class="treeview<?php isAdminNavActive(['payments']); ?>">
                            <a href="#">
                                <i class="fa fa-credit-card"></i>
                                <span><?= trans("payments"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($generalSettings->membership_plans_system == 1): ?>
                                    <li class="nav-payment-history"><a href="<?= generateDashUrl('payments'); ?>?payment=membership"><?= trans("membership_payments"); ?></a></li>
                                <?php endif; ?>
                                <li class="nav-payment-history"><a href="<?= generateDashUrl('payments'); ?>?payment=promotion"><?= trans("promotion_payments"); ?></a></li>
                            </ul>
                        </li>
                        <?php if ($generalSettings->affiliate_status == 1 && $generalSettings->affiliate_type == 'seller_based'): ?>
                            <li class="header"><?= trans("affiliate_program"); ?></li>
                            <li class="nav-affiliate-program">
                                <a href="<?= generateDashUrl('affiliate-program'); ?>"><i class="fa fa-link" aria-hidden="true"></i><span><?= trans("affiliate_program"); ?></span></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($generalSettings->product_comments == 1 || $generalSettings->reviews == 1): ?>
                            <li class="header"><?= trans("comments"); ?></li>
                            <?php if ($generalSettings->product_comments == 1): ?>
                                <li class="nav-comments">
                                    <a href="<?= generateDashUrl('comments'); ?>">
                                        <i class="fa fa-comments"></i>
                                        <span><?= trans("comments"); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($generalSettings->reviews == 1): ?>
                                <li class="nav-reviews">
                                    <a href="<?= generateDashUrl('reviews'); ?>">
                                        <i class="fa fa-star"></i>
                                        <span><?= trans("reviews"); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li class="header"><?= trans("settings"); ?></li>
                        <li class="nav-shop-settings">
                            <a href="<?= generateDashUrl('shop_settings'); ?>">
                                <i class="fa fa-cog"></i>
                                <span><?= trans("shop_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-shop-policies">
                            <a href="<?= generateDashUrl('shop_policies'); ?>">
                                <i class="fa fa-file-text"></i>
                                <span><?= trans("shop_policies"); ?></span></a>
                        </li>
                        <?php if ($baseVars->isSaleActive && $generalSettings->physical_products_system == 1): ?>
                            <li class="nav-shipping-settings">
                                <a href="<?= generateDashUrl('shipping_settings'); ?>">
                                    <i class="fa fa-truck"></i>
                                    <span><?= trans("shipping_settings"); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
    </aside>
    <?php
    $segment2 = $segment = getSegmentValue(2);
    $segment3 = $segment = getSegmentValue(3);
    $uriString = $segment2;
    if (!empty($segment3)) {
        $uriString .= '-' . $segment3;
    } ?>
    <style>
        <?php if(!empty($uriString)):
        echo '.nav-'.$uriString.' > a{color: #2C344C !important; background-color:#F7F8FC;}';
        else:
        echo '.nav-home > a{color: #2C344C !important; background-color:#F7F8FC;}';
        endif;?>
    </style>
    <div class="content-wrapper">
        <section class="content">