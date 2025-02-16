<div class="reviews-container">
    <div class="row">
        <div class="col-12">
            <div class="review-total">
                <?php if (!empty($reviews)):
                    echo view('partials/_review_stars', ['rating' => $product->rating]);
                    echo '&nbsp;&nbsp;';
                endif; ?>
                <label class="label-review"><?= trans("reviews"); ?>&nbsp;(<?= $reviewsCount; ?>)</label>
                <?php $btnAddReview = false;
                if (authCheck() && $product->user_id != user()->id) {
                    if ($product->listing_type == 'ordinary_listing') {
                        $btnAddReview = true;
                    } else {
                        if ($product->is_free_product) {
                            $btnAddReview = true;
                        } else {
                            if (checkUserBoughtProduct(user()->id, $product->id)) {
                                $btnAddReview = true;
                            }
                        }
                    }
                } ?>
                <?php if ($btnAddReview): ?>
                    <button type="button" data-product-id="<?= $product->id; ?>" class="btn btn-sm btn-custom display-flex align-items-center m-l-15" data-toggle="modal" data-target="#rateProductModal" onclick="$('#review_product_id').val(<?= $product->id; ?>);">
                        <?= trans("add_review"); ?>
                    </button>
                <?php endif; ?>
            </div>
            <?php if (empty($reviews)): ?>
                <p class="no-comments-found"><?= trans("no_reviews_found"); ?></p>
            <?php else: ?>
                <ul id="productReviewsListContainer" class="list-unstyled list-reviews">
                    <?= view('product/details/_reviews_list', ['reviews' => $reviews]); ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if (REVIEWS_LOAD_LIMIT < $reviewsCount): ?>
            <div class="col-12 text-center">
                <button type="button" id="btnLoadMoreProductReviews" data-product="<?= $product->id; ?>" data-total="<?= $reviewsCount; ?>" class="btn-load-more btn-load-more-product">
                    <?= trans("load_more_reviews"); ?>&nbsp;
                    <svg width="14" height="14" viewBox="0 0 1792 1792" fill="#333" class="m-l-5" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1664 256v448q0 26-19 45t-45 19h-448q-42 0-59-40-17-39 14-69l138-138q-148-137-349-137-104 0-198.5 40.5t-163.5 109.5-109.5 163.5-40.5 198.5 40.5 198.5 109.5 163.5 163.5 109.5 198.5 40.5q119 0 225-52t179-147q7-10 23-12 15 0 25 9l137 138q9 8 9.5 20.5t-7.5 22.5q-109 132-264 204.5t-327 72.5q-156 0-298-61t-245-164-164-245-61-298 61-298 164-245 245-164 298-61q147 0 284.5 55.5t244.5 156.5l130-129q29-31 70-14 39 17 39 59z"></path>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (authCheck() && user()->id == $product->user_id): ?>
    <div class="modal fade" id="reportReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <form id="form_report_review" method="post">
                    <div class="modal-header">
                        <h2 class="modal-title"><?= trans("report_review"); ?></h2>
                        <button type="button" class="close" data-dismiss="modal">
                            <span><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="response_form_report_review" class="col-12"></div>
                            <div class="col-12">
                                <input type="hidden" id="report_review_id" name="id" value="">
                                <div class="form-group m-0">
                                    <label class="control-label"><?= trans("description"); ?></label>
                                    <textarea name="description" class="form-control form-textarea" placeholder="<?= trans("abuse_report_exp"); ?>" minlength="5" maxlength="<?= REVIEW_CHARACTER_LIMIT; ?>" required></textarea>
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
<?php endif;
echo view('partials/_modal_rate_product'); ?>