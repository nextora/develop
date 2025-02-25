<div class="modal fade" id="rateProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <form action="<?= base_url('add-review-post'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
                <div class="modal-header">
                    <div class="modal-title"><?= trans("rate_this_product"); ?></div>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row-custom">
                                <div class="rate-product">
                                    <span><?= trans("your_rating"); ?></span>
                                    <div class="rating-stars rating-stars-modal" onclick="$('.rate-product label').css('color', '#dddddd')">
                                        <label class="label-star" data-star="5" for="star5"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="4" for="star4"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="3" for="star3"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="2" for="star2"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="1" for="star1"><i class="icon-star-o"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="review" id="user_review" class="form-control form-input form-textarea m-b-5" placeholder="<?= trans("write_review"); ?>" required></textarea>
                                <small class="text-muted">*<?= trans("if_review_already_added"); ?></small>
                                <input type="hidden" name="rating" id="user_rating" value="">
                                <input type="hidden" name="product_id" id="review_product_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-md btn-gray" data-dismiss="modal"><?= trans("close"); ?></button>
                    <button type="submit" class="btn btn-md btn-custom" onclick="if($('#user_rating').val() == ''){ $('.rate-product label').css('color', '#FF0000'); return false; }"><?= trans("submit"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>