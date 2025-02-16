<div class="section-slider">
    <?php if (!empty($sliderItems) && $generalSettings->slider_status == 1):
        echo view('partials/_main_slider');
    endif; ?>
</div>
<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row">
            <h1 class="index-title"><?= esc($baseSettings->site_title); ?></h1>
            <?php if (countItems($featuredCategories) > 0 && $generalSettings->featured_categories == 1):
                echo view('partials/_featured_categories');
            endif;
            echo view('product/_index_banners', ['bannerLocation' => 'featured_categories']);
            echo view('partials/_ad_spaces', ['adSpace' => 'index_1', 'class' => 'mb-3']);
            echo view('product/_special_offers', ['specialOffers' => $specialOffers]);
            echo view("product/_index_banners", ['bannerLocation' => 'special_offers']);
            if ($generalSettings->index_promoted_products == 1 && $generalSettings->promoted_products == 1 && !empty($promotedProducts)): ?>
                <div class="col-12 section section-promoted">
                    <?= view('product/_featured_products'); ?>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'featured_products']);
            if ($generalSettings->index_latest_products == 1 && !empty($latestProducts)): ?>
                <div class="col-12 section section-latest-products">
                    <div class="section-header display-flex justify-content-between">
                        <h3 class="title"><a href="<?= generateUrl('products'); ?>"><?= trans("new_arrivals"); ?></a></h3>
                        <a href="<?= generateUrl('products'); ?>" class="font-600"><?= trans("view_all"); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="row row-product">
                        <?php foreach ($latestProducts as $item): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?= view('product/_product_item', ['product' => $item, 'promotedBadge' => false, 'isSlider' => 0, 'discountLabel' => 0]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'new_arrivals']);
            echo view('product/_index_category_products', ['indexCategories' => $indexCategories]);
            echo view('partials/_ad_spaces', ['adSpace' => 'index_2', 'class' => 'mb-3']); ?>
            <div class="container">
        <!-- Feature Cards Section -->
        <div class="row">
            <!-- Free Delivery -->
            <div class="col-12 col-md-3">
                <div class="card">
                    <!-- SVG for Free Delivery -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="icon-size">
                        <path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z" />
                    </svg>
                    <div class="card-content">
                        <h3 class="card-title">Free Delivery</h3>
                        <p class="card-text">Free shipping on all orders</p>
                    </div>
                </div>
            </div>

            <!-- Money Guarantee -->
            <div class="col-12 col-md-3">
                <div class="card">
                    <!-- SVG for Money Guarantee -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-size" viewBox="0 0 512 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L80 128c-8.8 0-16-7.2-16-16s7.2-16 16-16l368 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L64 32zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                    <div class="card-content">
                        <h3 class="card-title">Money Guarantee</h3>
                        <p class="card-text">7 days money back guarantee</p>
                    </div>
                </div>
            </div>

            <!-- Safe Shopping -->
            <div class="col-12 col-md-3">
                <div class="card">
                    <!-- SVG for Safe Shopping -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-size" viewBox="0 0 512 512">
                        <path d="M466.5 83.7l-192-80a48.2 48.2 0 0 0 -36.9 0l-192 80C27.7 91.1 16 108.6 16 128c0 198.5 114.5 335.7 221.5 380.3 11.8 4.9 25.1 4.9 36.9 0C360.1 472.6 496 349.3 496 128c0-19.4-11.7-36.9-29.5-44.3zM256.1 446.3l-.1-381 175.9 73.3c-3.3 151.4-82.1 261.1-175.8 307.7z" />
                    </svg>
                    <div class="card-content">
                        <h3 class="card-title">Safe Shopping</h3>
                        <p class="card-text">Secure and protected transactions</p>
                    </div>
                </div>
            </div>

            <!-- Online Support -->
            <div class="col-12 col-md-3">
                <div class="card">
                    <!-- SVG for Online Support -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-size" viewBox="0 0 512 512">
                        <path d="M256 48C141.1 48 48 141.1 48 256l0 40c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-40C0 114.6 114.6 0 256 0S512 114.6 512 256l0 144.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24l-32 0c-26.5 0-48-21.5-48-48s21.5-48 48-48l32 0c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40L464 256c0-114.9-93.1-208-208-208zM144 208l16 0c17.7 0 32 14.3 32 32l0 112c0 17.7-14.3 32-32 32l-16 0c-35.3 0-64-28.7-64-64l0-48c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64l0 48c0 35.3-28.7 64-64 64l-16 0c-17.7 0-32-14.3-32-32l0-112c0-17.7 14.3-32 32-32l16 0z" />
                    </svg>
                    <div class="card-content">
                        <h3 class="card-title">Online Support</h3>
                        <p class="card-text">Support available 24/7</p>
                    </div>
                </div>
            </div>
        </div>
        
       


    </div>
            <?php if ($productSettings->brand_status == 1 && !empty($brands)): ?>
                <div class="col-12 section section-blog m-0">
                    <div class="section-header section-header-slider">
                        <h3 class="title"><?= trans("shop_by_brand"); ?></h3>
                        <div class="section-slider-nav" id="brand-slider-nav">
                            <button class="prev" aria-label="btn-prev-brand"><i class="icon-arrow-left"></i></button>
                            <button class="next" aria-label="btn-next-brand"><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="brand-slider-container" <?= $baseVars->rtl == true ? 'dir="rtl"' : ''; ?>>
                        <div id="brand-slider" class="brand-slider">
                            <?php foreach ($brands as $item):
                                if (!empty($item->image_path)):?>
                                    <a href="<?= generateUrl('products'); ?>?brand=<?= $item->id; ?>">
                                        <div class="brand-item">
                                            <div class="item">
                                                <img src="<?= IMG_BASE64_1x1; ?>" data-lazy="<?= base_url($item->image_path); ?>" alt="<?= getBrandName($item->name_data, selectedLangId()); ?>" width="216" height="104"/>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="container mt-5">
  <h2 class="text-primary text-center mb-4">Frequently Asked Questions</h2>
  <div class="accordion" id="faqAccordion">
    <!-- Accordion Item 1 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        What is Nextora, and how does it work?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        Nextora is a leading marketplace connecting buyers and sellers across multiple categories. You can explore products, compare prices, and place orders seamlessly using our platform.
      </div>
    </details>
    <!-- Accordion Item 2 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        How do I place an order on Nextora?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        To place an order, browse our product categories, add items to your cart, and proceed to checkout. You can make payments securely through various methods, including cards, UPI, and more.
      </div>
    </details>
    <!-- Accordion Item 3 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        What payment methods do you accept?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        We accept a variety of payment methods, including credit and debit cards, UPI, net banking, and digital wallets. All transactions are processed securely.
      </div>
    </details>
    <!-- Accordion Item 4 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        Does Nextora offer international shipping?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        Yes, Nextora offers international shipping to select countries. Shipping charges and delivery times vary depending on the destination.
      </div>
    </details>
    <!-- Accordion Item 5 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        How can I track my order?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        Once your order is shipped, you will receive a tracking link via email or SMS. You can also track your order directly on the Nextora platform under "My Orders."
      </div>
    </details>
    <!-- Accordion Item 6 -->
    <details class="border mb-3 rounded bg-light">
      <summary class="accordion-header d-flex justify-content-between align-items-center p-3">
        What is Nextora's return policy?
        <img class="accordion-icon" src="https://img.icons8.com/material-outlined/24/000000/plus-math.png" alt="Toggle Icon" />
      </summary>
      <div class="accordion-content p-3 bg-white border-top">
        Nextora allows returns within 7 days of delivery for most products. Please ensure the product is in its original condition and packaging when returning. Check the product's return policy on the product page for specific details.
      </div>
    </details>
  </div>
</div>
            <?php if ($generalSettings->index_blog_slider == 1 && !empty($blogSliderPosts)): ?>
                <div class="col-12 section section-blog m-0">
                    <div class="section-header section-header-slider">
                        <h3 class="title"><a href="<?= generateUrl('blog'); ?>"><?= trans("latest_blog_posts"); ?></a></h3>
                        <div class="section-slider-nav" id="blog-slider-nav">
                            <button class="prev" aria-label="btn-prev-blog"><i class="icon-arrow-left"></i></button>
                            <button class="next" aria-label="btn-next-blog"><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="row-custom">
                        <div class="blog-slider-container">
                            <div id="blog-slider" class="blog-slider">
                                <?php foreach ($blogSliderPosts as $item):
                                    echo view('blog/_blog_item', ['item' => $item]);
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= view('partials/_json_ld', ['jLDType' => 'index']); ?>

<style>
    .accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f8f9fa;
  }
  .accordion-header:hover {
    background-color: #e9ecef;
  }
  .accordion-content {
    overflow: hidden;
    padding: 0 1rem;
    background-color: #fff;
    border: 1px solid #ddd;
    border-top: none;
    border-radius: 0 0 5px 5px;
  }
  .accordion-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
  }
    .card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    .card i {
        font-size: 30px;
        color: #1d4ed8;
        /* Primary blue */
    }

    .card-content {
        margin-left: 15px;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .card-text {
        font-size: 14px;
        color: #6c757d;
        margin: 5px 0 0;
    }

    /* Set fixed height and width for the SVG icon */
    .icon-size {
        width: 50px;
        /* Adjust the width as needed */
        height: 50px;
        /* Adjust the height as needed */
        margin-bottom: 15px;
        /* Space between icon and text */
        fill: #007bff;
        /* Optional: Change icon color */
    }

    /* Optionally, adjust the icon size based on screen width */
    @media (max-width: 576px) {
        .icon-size {
            width: 40px;
            height: 40px;
        }
    }
</style>
<script>
  document.querySelectorAll("details").forEach((el) => {
    const summary = el.querySelector("summary");
    const icon = summary.querySelector(".accordion-icon");

    // Listen to the 'toggle' event which is triggered when the details element is opened/closed
    el.addEventListener("toggle", () => {
      // Check if the current element is open
      if (el.open) {
        icon.src = "https://img.icons8.com/material-outlined/24/000000/minus-math.png";  // Change icon to minus
        icon.style.transform = "rotate(180deg)"; // Rotate icon when open
      } else {
        icon.src = "https://img.icons8.com/material-outlined/24/000000/plus-math.png";  // Change icon to plus
        icon.style.transform = "rotate(0deg)"; // Reset rotation when closed
      }

      // Close all other accordion items when one is opened
      document.querySelectorAll("details").forEach((otherEl) => {
        if (otherEl !== el && otherEl.open) {
          otherEl.removeAttribute("open");
          const otherIcon = otherEl.querySelector(".accordion-icon");
          otherIcon.src = "https://img.icons8.com/material-outlined/24/000000/plus-math.png";  // Change icon to plus
          otherIcon.style.transform = "rotate(0deg)"; // Reset rotation when closed
        }
      });
    });
  });
</script>
