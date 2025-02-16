<!DOCTYPE html>
<html lang="<?= $activeLang->short_form; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <title>
    <?php if (strtolower($title) == "home"): ?>
        <?= escSls($baseSettings->site_title); ?>
        
    <?php else: ?>
        <?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?>
    <?php endif; ?>
</title>
<?php if (strtolower($title) == "home"): ?>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org/", 
                  "@type": "BreadcrumbList", 
                  "itemListElement": [{
                    "@type": "ListItem", 
                    "position": 1, 
                    "name": "Shop",
                    "item": "https://nextora.co.in/products"  
                  },{
                    "@type": "ListItem", 
                    "position": 2, 
                    "name": "Contact",
                    "item": "https://nextora.co.in/contact"  
                  },{
                    "@type": "ListItem", 
                    "position": 3, 
                    "name": "About Us",
                    "item": "https://nextora.co.in/About-us"  
                  },{
                    "@type": "ListItem", 
                    "position": 4, 
                    "name": "Blog",
                    "item": "https://nextora.co.in/blog"  
                  }]
                }
                </script>
       
    <?php endif; ?>
<meta name="description" content="<?= escSls($description); ?>"/>
<meta name="keywords" content="<?= escSls($keywords); ?>"/>
<meta name="author" content="<?= escSls($generalSettings->application_name); ?>"/>
<link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>"/>
<meta property="og:locale" content="<?= escSls($activeLang->language_code); ?>"/>
<meta property="og:site_name" content="<?= escSls($generalSettings->application_name); ?>"/>
<?php if (isset($showOgTags)): ?>
<meta property="og:type" content="<?= !empty($ogType) ? escSls($ogType) : 'website'; ?>"/>
<meta property="og:title" content="<?= !empty($ogTitle) ? escSls($ogTitle) : 'index'; ?>"/>
<meta property="og:description" content="<?= escSls($ogDescription); ?>"/>
<meta property="og:url" content="<?= escSls($ogUrl); ?>"/>
<meta property="og:image" content="<?= escSls($ogImage); ?>"/>
<meta property="og:image:width" content="<?= !empty($ogWidth) ? $ogWidth : 250; ?>"/>
<meta property="og:image:height" content="<?= !empty($ogHeight) ? $ogHeight : 250; ?>"/>
<meta property="article:author" content="<?= !empty($ogAuthor) ? escSls($ogAuthor) : ''; ?>"/>
<meta property="fb:app_id" content="<?= escSls($generalSettings->facebook_app_id); ?>"/>
<?php if (!empty($ogTags)):foreach ($ogTags as $tag): ?>
<meta property="article:tag" content="<?= escSls($tag->tag); ?>"/>
<?php endforeach; endif; ?>
<meta property="article:published_time" content="<?= !empty($ogPublishedTime) ? $ogPublishedTime : ''; ?>"/>
<meta property="article:modified_time" content="<?= !empty($ogModifiedTime) ? $ogModifiedTime : ''; ?>"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@<?= escSls($generalSettings->application_name); ?>"/>
<meta name="twitter:creator" content="@<?= escSls($ogCreator); ?>"/>
<meta name="twitter:title" content="<?= escSls($ogTitle); ?>"/>
<meta name="twitter:description" content="<?= escSls($ogDescription); ?>"/>
<meta name="twitter:image" content="<?= escSls($ogImage); ?>"/>
<?php else: ?>
<meta property="og:image" content="<?= getLogo(); ?>"/>
<meta property="og:image:width" content="<?= $baseVars->logoWidth; ?>"/>
<meta property="og:image:height" content="<?= $baseVars->logoHeight; ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?>"/>
<meta property="og:description" content="<?= escSls($description); ?>"/>
<meta property="og:url" content="<?= base_url(); ?>"/>
<meta property="fb:app_id" content="<?= escSls($generalSettings->facebook_app_id); ?>"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@<?= escSls($generalSettings->application_name); ?>"/>
<meta name="twitter:title" content="<?= escSls($title); ?> - <?= escSls($baseSettings->site_title); ?>"/>
<meta name="twitter:description" content="<?= escSls($description); ?>"/>
<?php endif;
if ($generalSettings->pwa_status == 1): ?>
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="<?= escSls($generalSettings->application_name); ?>">
<meta name="msapplication-TileImage" content="<?= base_url(getPwaLogo($generalSettings, 'sm')); ?>">
<meta name="msapplication-TileColor" content="#2F3BA2">
<link rel="manifest" href="<?= base_url('manifest.json'); ?>">
<link rel="apple-touch-icon" href="<?= base_url(getPwaLogo($generalSettings, 'sm')); ?>">
<?php endif; ?>
<link rel="canonical" href="<?= escSls(base_url(uri_string())); ?>"/>
<link rel="alternate" href="<?= getCurrentUrl(); ?>" hreflang="<?= $activeLang->language_code; ?>"/>
<?= csrf_meta(); ?>

<?= view('partials/_fonts'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/style-2.5.min.css'); ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/plugins-2.5.css'); ?>"/>
<?= view('partials/_css_js_header');
if ($baseVars->rtl == true): ?>
<link rel="stylesheet" href="<?= base_url('assets/css/rtl-2.5.min.css'); ?>">
<?php endif; ?>
<?= $generalSettings->google_adsense_code; ?>
<?= $generalSettings->custom_header_codes; ?>
</head>
<body>
<header id="header">
<?= view('partials/_top_bar'); ?>
<div class="main-menu">
<div class="container-fluid">
<div class="row">
<div class="nav-top">
<div class="container">
<div class="row align-items-center">
<div class="col-md-7 nav-top-left">
<div class="row-align-items-center">
<div class="logo">
<!--<a href="<?= langBaseUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo" width="<?= $baseVars->logoWidth; ?>" height="<?= $baseVars->logoHeight; ?>"></a>-->
</div>
<div class="logo">
                    <a href="<?php echo langBaseUrl(); ?>">
                        <img src="<?= getLogo(); ?>" 
                             alt="Nextora logo" class="img-fluid" style="max-width: 150px;">
                    </a>
                </div>
<div class="top-search-bar">
<form action="<?= generateUrl('products'); ?>" method="get" id="form_validate_search" class="form_search_main">
<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search_main" class="form-control input-search" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
<button class="btn btn-default btn-search" aria-label="search"><i class="icon-search"></i></button>
<div id="response_search_results" class="search-results-ajax mds-scrollbar"></div>
</form>
</div>
</div>
</div>
<div class="col-md-5 nav-top-right">
<ul class="nav align-items-center">
<?php if (isSaleActive()): ?>
<li class="nav-item nav-item-cart li-main-nav-right">
<a href="<?= generateUrl('cart'); ?>">
<i class="icon-cart"></i>
<span class="label-nav-icon"><?= trans("cart"); ?></span>
<?php $cartProductCount = getCartProductCount(); ?>
<span class="notification span_cart_product_count <?= $cartProductCount <= 0 ? 'visibility-hidden' : ''; ?>"><?= $cartProductCount; ?></span>
</a>
</li>
<?php endif; ?>
<li class="nav-item li-main-nav-right"><a href="<?= generateUrl('wishlist'); ?>"><i class="icon-heart-o"></i><span class="label-nav-icon"><?= trans("wishlist"); ?></span></a></li>

<?php if (authCheck()): ?>
<li class="nav-item dropdown profile-dropdown p-r-0">
<button type="button" class="nav-link button-link" data-toggle="dropdown" aria-expanded="false" aria-label="select-language">
<img src="<?= getUserAvatar(user()); ?>" alt="<?= esc(getUsername(user())); ?>" style="border-radius: 50%;" width="40" height="40">
<?= characterLimiter(esc(getUsername(user())), 15, '..'); ?>
<i class="icon-arrow-down"></i>
<?php if ($baseVars->unreadMessageCount > 0): ?>
<span class="message-notification"><?= $baseVars->unreadMessageCount; ?></span>
<?php endif; ?>
</button>
<ul class="dropdown-menu">
<?php if (hasPermission('admin_panel')): ?>
<li class="w-100">
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
<?php endif;

if (isVendor()): ?>
<li class="w-100">
<a href="<?= dashboardUrl(); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
<path fill="none" stroke="#747474" stroke-width="1.5" d="M14 20.4v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6Zm-11 0v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6Zm11-11V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6Zm-11 0V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6Z"/>
</svg>
</div><?= trans("dashboard"); ?>
</a>
</li>
<?php endif; ?>
<li class="w-100">
<a href="<?= generateProfileUrl(user()->slug); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="19" height="19" color="#747474" fill="none">
<path d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z" stroke="#747474" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="#747474" stroke-width="1.5"/>
</svg>
</div><?= trans("profile"); ?>
</a>
</li>
<li class="w-100">
<a href="<?= generateUrl('wallet'); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="18.8" height="18.8" viewBox="0 0 24 24">
<path stroke="#747474" stroke-width="0.5" fill="#747474" d="M19.5 7H18V6a3.003 3.003 0 0 0-3-3H4.5A2.5 2.5 0 0 0 2 5.5V18a3.003 3.003 0 0 0 3 3h14.5a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 19.5 7m-15-3H15a2.003 2.003 0 0 1 2 2v1H4.5a1.5 1.5 0 1 1 0-3M21 16h-2a2 2 0 0 1 0-4h2zm0-5h-2a3 3 0 1 0 0 6h2v1.5a1.5 1.5 0 0 1-1.5 1.5H5a2.003 2.003 0 0 1-2-2V7.499c.432.326.959.502 1.5.501h15A1.5 1.5 0 0 1 21 9.5z"/>
</svg>
</div><?= trans("wallet"); ?>
</a>
</li>
<?php if (isSaleActive()): ?>
<li class="w-100">
<a href="<?= generateUrl('orders'); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
<path d="M136,120v56a8,8,0,0,1-16,0V120a8,8,0,0,1,16,0Zm36.84-.8-5.6,56A8,8,0,0,0,174.4,184a7.32,7.32,0,0,0,.81,0,8,8,0,0,0,7.95-7.2l5.6-56a8,8,0,0,0-15.92-1.6Zm-89.68,0a8,8,0,0,0-15.92,1.6l5.6,56a8,8,0,0,0,8,7.2,7.32,7.32,0,0,0,.81,0,8,8,0,0,0,7.16-8.76ZM239.93,89.06,224.86,202.12A16.06,16.06,0,0,1,209,216H47a16.06,16.06,0,0,1-15.86-13.88L16.07,89.06A8,8,0,0,1,24,80H68.37L122,18.73a8,8,0,0,1,12,0L187.63,80H232a8,8,0,0,1,7.93,9.06ZM89.63,80h76.74L128,36.15ZM222.86,96H33.14L47,200H209Z"></path>
</svg>
</div><?= trans("orders"); ?>
</a>
</li>
<li class="w-100">
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
<li class="w-100">
<a href="<?= generateUrl('messages'); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 32 32">
<path fill="#747474" d="M17.74 30L16 29l4-7h6a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9v2H6a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4h-4.84Z"/>
<path fill="#747474" d="M8 10h16v2H8zm0 6h10v2H8z"/>
</svg>
</div><?= trans("messages"); ?>&nbsp;
<?php if ($baseVars->unreadMessageCount > 0): ?>
(<?= $baseVars->unreadMessageCount; ?>)
<?php endif; ?>
</a>
</li>
<li class="w-100">
<a href="<?= generateUrl('settings', 'edit_profile'); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
<path
d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"></path>
</svg>
</div><?= trans("profile_settings"); ?>
</a>
</li>
<li class="w-100">
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
<?php else: ?>
<li class="nav-item d-flex align-items-center">
   <a href="javascript:void(0)" class="gi-header-btn gi-header-user d-flex align-items-center" title="Account" data-toggle="modal" data-target="#loginModal">
    <div class="d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 50%; box-shadow: 0px 2px 5px rgba(0,0,0,0.1);">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#666">
            <circle cx="12" cy="8" r="4"></circle>
            <path d="M12 14c-5 0-8 2.5-8 5v1h16v-1c0-2.5-3-5-8-5z"></path>
        </svg>
    </div>
    <div class="gi-btn-desc ml-2">
        <span class="gi-btn-title font-weight-bold" style="font-size: 14px; color: #333;">Account</span><br/>
        <span class="gi-btn-stitle text-muted" style="font-size: 12px;"><?php echo trans("login"); ?>/<?php echo trans("register"); ?></span>
    </div>
</a>
</a>
</li>
<?php endif; ?>
<?php if (authCheck()): ?>
<?php if ($generalSettings->multi_vendor_system == 1): ?>
<li class="nav-item m-r-0"><a href="<?= generateDashUrl("add_product"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0"><?= trans("sell_now"); ?></a></li>
<?php endif;
else: ?>
<?php if ($generalSettings->multi_vendor_system == 1): ?>
<li class="nav-item m-r-0">
<button type="button" class="btn btn-md btn-custom btn-sell-now m-r-0" data-toggle="modal" data-target="#loginModal" aria-label="sell-now"><?= trans("sell_now"); ?></button>
</li>

<?php endif; ?>

<?php endif; ?>
</ul>
</div>
</div>
</div>
</div>
<div class="nav-main">
<?= view("partials/_nav_main"); ?>
</div>
</div>
</div>
</div>
<div class="mobile-nav-container">
<div class="nav-mobile-header">
<div class="container-fluid">
<div class="row">
<div class="nav-mobile-header-container">
<div class="d-flex justify-content-between">
<div class="flex-item flex-item-left item-menu-icon justify-content-start">
<button type="button" class="btn-open-mobile-nav button-link" aria-label="open-mobile-menu"><i class="icon-menu"></i></button>
</div>
<div class="flex-item flex-item-mid justify-content-center">
<div class="mobile-logo">
<a href="<?= langBaseUrl(); ?>" class="logo"><img src="<?= getLogo(); ?>" alt="logo" width="<?= $baseVars->logoWidth; ?>" height="<?= $baseVars->logoHeight; ?>"></a>
</div>
</div>
<div class="flex-item flex-item-right justify-content-end">
<button type="button" class="button-link a-search-icon" aria-label="button-mobile-search-icon"><i id="searchIconMobile" class="icon-search"></i></button>
<?php if (isSaleActive()): ?>
<a href="<?= generateUrl('cart'); ?>" class="a-mobile-cart"><i class="icon-cart"></i><span class="notification span_cart_product_count"><?= getCartProductCount(); ?></span></a>
<?php endif; ?>
</div>
</div>
</div>
</div>
<div class="row">
<div class="top-search-bar mobile-search-form">
<form action="<?= generateUrl('products'); ?>" method="get">
<input type="text" id="input_search_mobile" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
<button class="btn btn-default btn-search"><i class="icon-search"></i></button>
<div id="response_search_results_mobile" class="search-results-ajax mds-scrollbar"></div>
</form>
</div>
</div>
</div>
</div>
</div>
</header>
<div id="overlay_bg" class="overlay-bg"></div>
<?= view("partials/_nav_mobile"); ?>
<input type="hidden" class="search_type_input" name="search_type" value="product">
<?php if (!authCheck()): ?><div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content custom-modal-content">
        <div class="d-flex justify-content-center align-items-center auth-container1">
            <div class="row border rounded-5 p-3 bg-white shadow-lg w-100 position-relative">

                <!-- Register Section -->
                <div class="col-md-5 d-flex flex-column justify-content-center align-items-center text-center p-4 auth-left-box">
                    <div class="register-box fade-in">
                        <h2 class="text-white">Create Account</h2>
                        <p class="text-white">Join us today!</p>
                        <form id="form_register">
                            <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
                            <input type="email" name="email" class="form-control mb-3" placeholder="Email address" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                            <button type="submit" class="btn btn-light w-100">Register</button>
                            <p class="mt-3 text-white">Already have an account? <a href="#" id="goToLogin" class="text-light">Login</a></p>
                        </form>
                    </div>
                    <div class="register-info fade-in">
                        <img src="images/1.png" class="img-fluid mb-3" style="width: 200px;">
                        <h2 class="text-white">Be Verified</h2>
                        <p class="text-white">Join experienced Designers on this platform.</p>
                        <button id="showRegister" class="btn btn-light mt-4">Register</button>
                    </div>
                </div>

                <!-- Login Section -->
                <div class="col-md-7 auth-right-box">
                    <div class="login-box fade-in">
                        <h2 class="mb-3">Hello, Again</h2>
                        <p>We are happy to have you back.</p>
                        <form id="form_login">
                            <input type="email" name="email" class="form-control mb-3" placeholder="Email address" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                            <div class="d-flex justify-content-between mb-3">
                                <label><input type="checkbox"> Remember Me</label>
                                <a href="#">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                            <p class="mt-3">Don't have an account? <a href="#" id="goToRegister">Register</a></p>
                        </form>
                    </div>
                    <div class="login-info fade-in">
                        <h2>Welcome Back!</h2>
                        <p>Login to continue enjoying our services.</p>
                        <button id="showLogin" class="btn btn-primary mt-3">Login</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Full Height Container */
.auth-container1 {
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.6s ease-in-out;
}

/* Left Box (Register) */
.auth-left-box {
    background: linear-gradient(135deg, #103cbe, #0a2a7b);
    color: white;
    border-radius: 10px 0 0 10px;
    padding: 20px;
    width: 40%;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.5s ease-in-out;
}

/* Right Box (Login) */
.auth-right-box {
    padding: 40px;
    width: 60%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: all 0.5s ease-in-out;
}

/* Animations */
.register-box, .login-info {
    display: none;
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}
.show-register .register-box,
.show-login .login-box {
    display: block;
    opacity: 1;
}
.show-register .login-box, 
.show-register .login-info, 
.show-login .register-box, 
.show-login .register-info {
    display: none;
    opacity: 0;
}
.fade-in {
    animation: fadeIn 0.6s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Mobile View Adjustments */
@media (max-width: 768px) {
    .auth-container1 {
        flex-direction: column;
        height: auto;
        padding: 20px;
    }
    .auth-left-box, .auth-right-box {
        width: 100%;
        border-radius: 10px;
        padding: 20px;
    }
    .auth-left-box {
        border-radius: 10px 10px 0 0;
    }
    .auth-right-box {
        border-radius: 0 0 10px 10px;
    }
    .register-info img {
        max-width: 100%;
        height: auto;
    }
    .btn {
        width: 100%;
    }
}
</style>

<script>
document.getElementById("showRegister").addEventListener("click", function () {
    toggleAuth("show-register");
});

document.getElementById("goToRegister").addEventListener("click", function (event) {
    event.preventDefault();
    toggleAuth("show-register");
});

document.getElementById("goToLogin").addEventListener("click", function (event) {
    event.preventDefault();
    toggleAuth("show-login");
});

document.getElementById("showLogin").addEventListener("click", function () {
    toggleAuth("show-login");
});
function toggleAuth(state) {
    const container = document.querySelector(".auth-container1");
    const registerBox = document.querySelector(".register-box");
    const loginBox = document.querySelector(".login-box");
    const registerInfo = document.querySelector(".register-info");
    const loginInfo = document.querySelector(".login-info");

    if (state === "show-register") {
        container.classList.add("show-register");
        container.classList.remove("show-login");

        registerBox.style.display = "block";
        registerBox.style.opacity = "1";

        loginBox.style.display = "none";
        loginBox.style.opacity = "0";

        registerInfo.style.display = "none";
        registerInfo.style.opacity = "0";

        loginInfo.style.display = "block";
        loginInfo.style.opacity = "1";
    } else if (state === "show-login") {
        container.classList.add("show-login");
        container.classList.remove("show-register");

        registerBox.style.display = "none";
        registerBox.style.opacity = "0";

        loginBox.style.display = "block";
        loginBox.style.opacity = "1";

        registerInfo.style.display = "block";
        registerInfo.style.opacity = "1";

        loginInfo.style.display = "none";
        loginInfo.style.opacity = "0";
    }
}


// Set initial state
toggleAuth("show-login");

</script>



</div>
<?php endif;
if ($generalSettings->location_search_header == 1): ?>
<div class="modal fade" id="locationModal" role="dialog">
<div class="modal-dialog modal-dialog-centered login-modal location-modal" role="document">
<div class="modal-content">
<div class="auth-box">
<button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
<div class="title"><?= trans("select_location"); ?></div>
<p class="location-modal-description"><?= trans("filter_products_location"); ?></p>
<form action="<?= base_url('Home/setDefaultLocationPost'); ?>" method="post">
<?= csrf_field(); ?>
<input type="hidden" name="form_type">
<div class="form-group m-b-20">
<?php $defaultCountryId = $generalSettings->single_country_mode == 1 ? $generalSettings->single_country_id : $baseVars->defaultLocation->country_id;
$filterStates = !empty($defaultCountryId) ? getStatesByCountry($defaultCountryId) : array();
$filterCities = !empty($baseVars->defaultLocation->state_id) ? getCitiesByState($baseVars->defaultLocation->state_id) : array(); ?>
<?php if ($generalSettings->single_country_mode != 1): ?>
<div class="m-b-5">
<select id="select_countries_filter" name="country_id" class="select2 form-control" onchange="getStates(this.value, 'filter');">
<option value=""><?= trans('country'); ?></option>
<?php if (!empty($activeCountries)):
foreach ($activeCountries as $item): ?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->country_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
<?php else: ?>
<input type="hidden" name="country_id" value="<?= $generalSettings->single_country_id; ?>">
<?php endif; ?>
<div id="get_states_container_filter" class="m-b-5 <?= !empty($filterStates) ? '' : 'display-none'; ?>">
<select id="select_states_filter" name="state_id" class="select2 form-control" onchange="getCities(this.value, 'filter');">
<option value=""><?= trans('state'); ?></option>
<?php if (!empty($filterStates)):
foreach ($filterStates as $item): ?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->state_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
<div id="get_cities_container_filter" class="m-b-5 <?= empty($filterCities) ? 'display-none' : ''; ?>">
<select id="select_cities_filter" name="city_id" class="select2 form-control">
<option value=""><?= trans('city'); ?></option>
<?php if (!empty($filterCities)):
foreach ($filterCities as $item):?>
<option value="<?= $item->id; ?>" <?= $item->id == $baseVars->defaultLocation->city_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
<?php endforeach;
endif; ?>
</select>
</div>
</div>
<div class="form-group">
<button type="submit" name="submit" value="set" class="btn btn-md btn-custom btn-block"><?= trans("select_location"); ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
<?php endif;
if ($generalSettings->newsletter_status == 1 && $generalSettings->newsletter_popup == 1): ?>
<div id="modal_newsletter" class="modal fade modal-center modal-newsletter" role="dialog">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<div class="row">
<div class="col-6 col-left">
<img src="<?= !empty($generalSettings->newsletter_image) ? base_url($generalSettings->newsletter_image) : base_url('assets/img/newsletter_bg.jpg'); ?>" alt="<?= trans("newsletter") ?>" class="newsletter-img" width="394" height="394">
</div>
<div class="col-6 col-right">
<div class="newsletter-form-container">
<button type="button" class="close modal-close-rounded" data-dismiss="modal"><i class="icon-close"></i></button>
<div class="newsletter-form">
<div class="modal-title"><?= trans("join_newsletter"); ?></div>
<p class="modal-desc"><?= trans("newsletter_desc"); ?></p>
<form id="form_newsletter_modal" class="form-newsletter" data-form-type="modal">
<div class="form-group">
<div class="modal-newsletter-inputs">
<input type="email" name="email" class="form-control form-input newsletter-input" placeholder="<?= trans('enter_email') ?>">
<button type="submit" class="btn"><?= trans("subscribe"); ?></button>
</div>
</div>
<input type="text" name="url">
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php endif; ?>
<div id="modalAddToCart" class="modal fade modal-product-cart" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<strong class="font-600 text-success" style="font-size: 16px;"> <i class="icon-check"></i>&nbsp;<?= trans("product_added_to_cart"); ?></strong>
<button type="button" class="close modal-close-rounded" data-dismiss="modal"><i class="icon-close"></i></button>
</div>
<div id="contentModalCartProduct" class="modal-body"></div>
</div>
</div>
</div>