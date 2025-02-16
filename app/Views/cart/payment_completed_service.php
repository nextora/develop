<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm">
                    <div class="circle-loader">
                        <div class="checkmark draw"></div>
                    </div>
                    <?php if (empty($bankTransactionNumber)): ?>
                        <h1 class="title"><?= trans("msg_payment_completed"); ?></h1>
                    <?php endif; ?>

                    <?php if ($paymentType == 'membership'): ?>
                        <div>
                            <?php if (empty($bankTransactionNumber)): ?>
                                <?php if (!empty(helperGetSession('modesy_membership_request_type')) && helperGetSession('modesy_membership_request_type') == 'renew'): ?>
                                    <p class="m-t-15 text-success"><?= trans("msg_membership_renewed"); ?></p>
                                <?php else: ?>
                                    <p class="m-t-15 text-success"><?= trans("msg_membership_activated"); ?></p>
                                <?php endif;
                            else: ?>
                                <p class="p-order-number"><strong class="text-danger"><?= trans("awaiting_payment"); ?></strong></p>
                                <p class="p-order-number"><?= trans("transaction_number"); ?><br><?= esc($bankTransactionNumber); ?></p>
                            <?php endif;
                            if ($method != 'gtw'): ?>
                                <p class="p-complete-payment"><?= trans("msg_bank_transfer_text_transaction_completed"); ?></p>
                                <div class="bank-account-container">
                                    <?= $paymentSettings->bank_transfer_accounts; ?>
                                </div>
                            <?php endif; ?>
                            <div class="m-t-45 text-center">
                                <a href="<?= base_url('invoice-membership/' . $transaction->id); ?>" class="btn btn-lg btn-info color-white" target="_blank"><i class="icon-text-o"></i>&nbsp;&nbsp;<?= trans("view_invoice"); ?></a>
                                <?php if (!empty(helperGetSession('modesy_membership_request_type')) && helperGetSession('modesy_membership_request_type') == 'renew'): ?>
                                    <a href="<?= generateDashUrl('shop_settings'); ?>" class="btn btn-lg btn-custom"><?= trans("go_back_to_shop_settings"); ?>&nbsp;&nbsp;
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= generateDashUrl('shop_settings'); ?>" class="btn btn-lg btn-custom"><?= trans("go_back_to_shop_settings"); ?>&nbsp;&nbsp;
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif ($paymentType == 'promote'): ?>
                        <?php if (!empty($bankTransactionNumber)): ?>
                            <p class="p-order-number"><strong class="text-danger"><?= trans("awaiting_payment"); ?></strong></p>
                            <p class="p-order-number"><?= trans("transaction_number"); ?><br><?= $bankTransactionNumber; ?></p>
                        <?php endif;
                        if ($method != 'gtw'): ?>
                            <p class="p-complete-payment"><?= trans("msg_bank_transfer_text_transaction_completed"); ?></p>
                            <div class="bank-account-container">
                                <?= $paymentSettings->bank_transfer_accounts; ?>
                            </div>
                        <?php endif; ?>
                        <div class="m-t-45 text-center">
                            <a href="<?= base_url('invoice-promotion/' . $transaction->id); ?>" class="btn btn-lg btn-info color-white" target="_blank"><i class="icon-text-o"></i>&nbsp;&nbsp;<?= trans("view_invoice"); ?></a>
                            <a href="<?= generateDashUrl('products'); ?>" class="btn btn-lg btn-custom">
                                <?= trans("go_back_to_products") ?>&nbsp;&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </a>
                        </div>
                    <?php elseif ($paymentType == 'add_funds'): ?>
                        <?php if (!empty($bankTransactionNumber)): ?>
                            <p class="p-order-number"><strong class="text-danger"><?= trans("awaiting_payment"); ?></strong></p>
                            <p class="p-order-number"><?= trans("transaction_number"); ?><br><?= $bankTransactionNumber; ?></p>
                        <?php endif;
                        if ($method != 'gtw'): ?>
                            <p class="p-complete-payment"><?= trans("msg_bank_transfer_text_transaction_completed"); ?></p>
                            <div class="bank-account-container">
                                <?= $paymentSettings->bank_transfer_accounts; ?>
                            </div>
                        <?php endif; ?>
                        <div class="m-t-45 text-center">
                            <a href="<?= base_url('invoice-wallet-deposit/' . $transaction->id); ?>" class="btn btn-lg btn-info color-white" target="_blank"><i class="icon-text-o"></i>&nbsp;&nbsp;<?= trans("view_invoice"); ?></a>
                            <a href="<?= generateUrl('wallet'); ?>?tab=deposits" class="btn btn-lg btn-custom"><?= trans("wallet") ?>&nbsp;&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .circle-loader {
        margin-bottom: 3.5em;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-left-color: #5cb85c;
        animation: loader-spin 1.2s infinite linear;
        position: relative;
        display: inline-block;
        vertical-align: top;
        border-radius: 50%;
        width: 7em;
        height: 7em
    }

    .load-complete {
        -webkit-animation: none;
        animation: none;
        border-color: #5cb85c;
        transition: border 500ms ease-out
    }

    .checkmark {
        display: none
    }

    .checkmark.draw:after {
        animation-duration: 800ms;
        animation-timing-function: ease;
        animation-name: checkmark;
        transform: scaleX(-1) rotate(135deg)
    }

    .checkmark:after {
        opacity: 1;
        height: 3.5em;
        width: 1.75em;
        transform-origin: left top;
        border-right: 3px solid #5cb85c;
        border-top: 3px solid #5cb85c;
        content: '';
        left: 1.75em;
        top: 3.5em;
        position: absolute
    }

    @keyframes loader-spin {
        0% {
            transform: rotate(0deg)
        }
        100% {
            transform: rotate(360deg)
        }
    }

    @keyframes checkmark {
        0% {
            height: 0;
            width: 0;
            opacity: 1
        }
        20% {
            height: 0;
            width: 1.75em;
            opacity: 1
        }
        40% {
            height: 3.5em;
            width: 1.75em;
            opacity: 1
        }
        100% {
            height: 3.5em;
            width: 1.75em;
            opacity: 1
        }
    }

    .error-circle {
        margin-bottom: 3.5em;
        border: 1px solid #dc3545;
        position: relative;
        display: inline-block;
        vertical-align: top;
        border-radius: 50%;
        width: 7em;
        height: 7em;
        line-height: 7em;
        color: #dc3545
    }

    .error-circle i {
        font-size: 30px
    }
</style>
<?php helperDeleteSession('mds_service_payment');
helperDeleteSession('mds_cart_payment_method');
helperDeleteSession('mds_bank_transaction_number'); ?>