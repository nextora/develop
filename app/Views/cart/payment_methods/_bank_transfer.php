<?php if ($cartPaymentMethod->payment_option == 'bank_transfer'):
    if ($mdsPaymentType == 'promote'): ?>
        <form action="<?= base_url('bank-transfer-payment-post'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="mds_payment_type" value="<?= $mdsPaymentType; ?>">
            <input type="hidden" name="payment_id" value="<?= $transactionNumber; ?>">
            <div class="bank-account-container">
                <?= $paymentSettings->bank_transfer_accounts; ?>
            </div>
            <div id="payment-button-container" class="payment-button-cnt">
                <p class="p-transaction-number"><span><?= trans("transaction_number"); ?>:&nbsp;<?= esc($transactionNumber); ?></span></p>
                <p class="p-complete-payment"><?= trans("msg_promote_bank_transfer_text"); ?></p>
                <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-payment"><?= trans("place_order") ?></button>
            </div>
        </form>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <?= view('partials/_messages'); ?>
            </div>
        </div>
        <div class="bank-account-container text-center">
            <?= $paymentSettings->bank_transfer_accounts; ?>
        </div>
        <form action="<?= base_url('bank-transfer-payment-post'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="mds_payment_type" value="<?= $mdsPaymentType; ?>">
            <div id="payment-button-container" class="payment-button-cnt">
                <p class="text-center m-b-30 font-600"><?= trans("msg_bank_transfer_text"); ?></p>
                <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-payment">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" style="margin-top: 1px;">
                        <path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"/>
                    </svg>&nbsp;&nbsp;<?= trans("place_order") ?>
                </button>
            </div>
        </form>
    <?php endif;
endif; ?>
<script>
    $('form').submit(function () {
        $(".btn-place-order").prop('disabled', true);
    });
</script>



