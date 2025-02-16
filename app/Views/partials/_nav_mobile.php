<div id="navMobile" class="nav-mobile">
<div class="nav-mobile-sc">
<div class="nav-mobile-inner">
<div class="row">
<div class="col-sm-12 mobile-nav-buttons">
<?php if ($generalSettings->multi_vendor_system == 1):
if (authCheck()): ?>
<a href="<?= generateDashUrl("add_product"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
<?php else: ?>
<button type="button" class="btn btn-md btn-custom btn-block close-menu-click" data-toggle="modal" data-target="#loginModal" aria-label="mobile-sell-now"><?= trans("sell_now"); ?></button>
<?php endif;
endif; ?>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="nav nav-tabs nav-tabs-mobile-menu" id="nav-tab">
<button class="nav-link active" data-toggle="tab" data-target="#tabMobileMainMenu" type="button" aria-label="button-open-main-menu"><?= trans("main_menu"); ?></button>
<button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#tabMobileCategories" type="button" aria-label="button-open-categories"><?= trans("categories"); ?></button>
</div>
<div class="tab-content tab-content-mobile-menu nav-mobile-links">
<div class="tab-pane fade show active" id="tabMobileMainMenu" role="tabpanel">
<ul id="navbar_mobile_links" class="navbar-nav">
<?php if (authCheck()): ?>
<li class="dropdown profile-dropdown nav-item">
<a href="#" class="dropdown-toggle image-profile-drop nav-link" data-toggle="dropdown" aria-expanded="false">
<?php if ($baseVars->unreadMessageCount > 0): ?>
<span class="message-notification message-notification-mobile"><?= $baseVars->unreadMessageCount; ?></span>
<?php endif; ?>
<img src="<?= getUserAvatar(user()); ?>" alt="<?= esc(getUsername(user())); ?>" width="42" height="42">
<?= esc(getUsername(user())); ?> <span class="icon-arrow-down"></span>
</a>
<ul class="dropdown-menu">
<?php if (isAdmin()): ?>
<li>
<a href="<?= adminUrl(); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
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
<li>
<a href="<?= dashboardUrl(); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill="none" stroke="#747474" stroke-width="1.5" d="M14 20.4v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6Zm-11 0v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6Zm11-11V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6Zm-11 0V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6Z"/>
</svg>
</div><?= trans("dashboard"); ?>
</a>
</li>
<?php endif; ?>
<li>
<a href="<?= generateProfileUrl(user()->slug); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" color="#747474" fill="none">
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
<?php if ($baseVars->unreadMessageCount > 0): ?>
<span class="span-message-count">(<?= $baseVars->unreadMessageCount; ?>)</span>
<?php endif; ?>
</a>
</li>
<li>
<a href="<?= generateUrl('settings', 'edit_profile'); ?>">
<div class="icon">
<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#747474" viewBox="0 0 256 256">
<path
d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"></path>
</svg>
</div><?= trans("profile_settings"); ?>
</a>
</li>
<li>
<form action="<?= base_url('logout'); ?>" method="post" class="form-logout">
<?= csrf_field(); ?>
<input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
<button type="submit" class="btn-logout" aria-label="btn-logout-mobile">
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
<?php endif; ?>
<li class="nav-item"><a href="<?= langBaseUrl(); ?>" class="nav-link"><?= trans("home"); ?></a></li>
<li class="nav-item"><a href="<?= generateUrl('wishlist'); ?>" class="nav-link"><?= trans("wishlist"); ?></a></li>
<?php if (!empty($menuLinks)):
foreach ($menuLinks as $menuLink):
if ($menuLink->page_default_name == 'blog' || $menuLink->page_default_name == 'contact' || $menuLink->location == 'top_menu'):
$itemLink = generateMenuItemUrl($menuLink);
if (!empty($menuLink->page_default_name)):
$itemLink = generateUrl($menuLink->page_default_name);
endif; ?>
<li class="nav-item"><a href="<?= $itemLink; ?>" class="nav-link"><?= esc($menuLink->title); ?></a></li>
<?php endif;
endforeach;
endif;
if (!authCheck()): ?>
<li class="nav-item">
<button type="button" data-toggle="modal" data-target="#loginModal" class="nav-link close-menu-click button-link" aria-label="nav-login-menu"><?= trans("login"); ?></button>
</li>
<li class="nav-item"><a href="<?= generateUrl('register'); ?>" class="nav-link"><?= trans("register"); ?></a></li>
<?php endif;
if ($generalSettings->location_search_header == 1 && countItems($activeCountries) > 0): ?>
<li class="nav-item nav-item-messages">
<button type="button" data-toggle="modal" data-target="#locationModal" class="nav-link btn-modal-location close-menu-click button-link" aria-label="nav-location-menu">
<i class="icon-map-marker float-left"></i>&nbsp;<?= !empty($baseVars->defaultLocationInput) ? $baseVars->defaultLocationInput : trans("location"); ?>
</button>
<?php if (!empty($baseVars->defaultLocationInput)): ?>
<form action="<?= base_url('Home/setDefaultLocationPost'); ?>" method="post" class="display-inline-block m-b-10">
<?= csrf_field(); ?>
<button type="submit" name="submit" value="reset" class="btn-reset-location"><?= trans("reset"); ?></button>
</form>
<?php endif; ?>
</li>
<?php endif; ?>
<li class="d-flex justify-content-center mobile-flex-dropdowns">
<?php if ($generalSettings->multilingual_system == 1 && countItems($activeLanguages) > 1): ?>
<div class="nav-item dropdown top-menu-dropdown">
<button type="button" class="nav-link dropdown-toggle button-link" data-toggle="dropdown" aria-label="nav-flag-menu">
<img src="<?= base_url($activeLang->flag_path); ?>" class="flag" alt="<?= esc($activeLang->name)." ".trans("active") ; ?>-mb" style="width: 18px; height: auto;"><?= esc($activeLang->name); ?>&nbsp;<i class="icon-arrow-down"></i>
</button>
<ul class="dropdown-menu dropdown-menu-lang">
<?php foreach ($activeLanguages as $language): ?>
<li>
<a href="<?= convertUrlByLanguage($language); ?>" class="dropdown-item <?= $language->id == $activeLang->id ? 'selected' : ''; ?>">
<img src="<?= base_url($language->flag_path); ?>" class="flag" alt="<?= esc($language->name); ?>-mb" style="width: 18px; height: auto;"><?= esc($language->name); ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</div>
<?php endif;
if ($paymentSettings->currency_converter == 1 && !empty($currencies)): ?>
<div class="nav-item dropdown top-menu-dropdown">
<button type="button" class="nav-link dropdown-toggle button-link" data-toggle="dropdown" aria-label="nav-currency-menu">
<?= getSelectedCurrency()->code; ?>&nbsp;(<?= getSelectedCurrency()->symbol; ?>)&nbsp;<i class="icon-arrow-down"></i>
</button>
<form action="<?= base_url('set-selected-currency-post'); ?>" method="post">
<?= csrf_field(); ?>
<ul class="dropdown-menu">
<?php foreach ($currencies as $currency):
if ($currency->status == 1):?>
<li>
<button type="submit" name="currency" value="<?= $currency->code; ?>"><?= $currency->code; ?>&nbsp;(<?= $currency->symbol; ?>)</button>
</li>
<?php endif;
endforeach; ?>
</ul>
</form>
</div>
<?php endif; ?>
</li>
</ul>
</div>
<div class="tab-pane fade" id="tabMobileCategories" role="tabpanel">
<div id="navbar_mobile_back_button"></div>
<ul id="navbar_mobile_categories" class="navbar-nav navbar-mobile-categories">
<?php if (!empty($parentCategories)):
foreach ($parentCategories as $category):
if ($category->show_on_main_menu == 1):
if ($category->has_subcategory > 0): ?>
<li class="nav-item">
<button type="button" class="nav-link button-link" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>" aria-label="nav-category-<?= $category->id; ?>"><?= getCategoryName($category, $activeLang->id); ?><i class="icon-arrow-right"></i></button>
</li>
<?php else: ?>
<li class="nav-item"><a href="<?= generateCategoryUrl($category); ?>" class="nav-link"><?= getCategoryName($category, $activeLang->id); ?></a></li>
<?php endif;
endif; ?>
<?php endforeach;
endif; ?>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>