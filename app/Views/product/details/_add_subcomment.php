<form id="formAddSubcomment<?= $parentComment->id; ?>">
    <?php if (!authCheck()): ?>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" name="name" class="form-control form-input form-comment-name" placeholder="<?= trans("name"); ?>" maxlength="255">
            </div>
            <div class="form-group col-md-6">
                <input type="email" name="email" class="form-control form-input form-comment-email" placeholder="<?= trans("email_address"); ?>" maxlength="255">
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <textarea name="comment" class="form-control form-input form-textarea form-comment-text" placeholder="<?= trans("comment"); ?>" maxlength="<?= COMMENT_CHARACTER_LIMIT; ?>"></textarea>
    </div>
    <?php if (!authCheck()): ?>
        <div class="form-group">
            <?php reCaptcha('generate'); ?>
        </div>
    <?php endif; ?>
    <input type="hidden" name="product_id" value="<?= $parentComment->product_id; ?>">
    <input type="hidden" name="parent_id" value="<?= $parentComment->id; ?>">
    <input type="text" name="comment_name">
    <button type="button" class="btn btn-md btn-custom btn-submit-subcomment" data-comment-id="<?= $parentComment->id; ?>"><?= trans("submit"); ?></button>
</form>