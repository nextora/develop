<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                                    <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= trans("filter"); ?>
                                </button>
                                <div class="collapse navbar-collapse" id="collapseFilter">
                                    <form action="<?= adminUrl('bank-transfer-reports'); ?>" method="get">
                                        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                            <label><?= trans("show"); ?></label>
                                            <select name="show" class="form-control">
                                                <option value="15" <?= inputGet('show') == '15' ? 'selected' : ''; ?>>15</option>
                                                <option value="30" <?= inputGet('show') == '30' ? 'selected' : ''; ?>>30</option>
                                                <option value="60" <?= inputGet('show') == '60' ? 'selected' : ''; ?>>60</option>
                                                <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                            </select>
                                        </div>
                                        <div class="item-table-filter">
                                            <label><?= trans("status"); ?></label>
                                            <select name="status" class="form-control">
                                                <option value="" selected><?= trans("all"); ?></option>
                                                <option value="pending" <?= inputGet('status') == 'pending' ? 'selected' : ''; ?>><?= trans("pending"); ?></option>
                                                <option value="approved" <?= inputGet('status') == 'approved' ? 'selected' : ''; ?>><?= trans("approved"); ?></option>
                                                <option value="declined" <?= inputGet('status') == 'declined' ? 'selected' : ''; ?>><?= trans("declined"); ?></option>
                                            </select>
                                        </div>
                                        <div class="item-table-filter">
                                            <label><?= trans("search"); ?></label>
                                            <input name="q" class="form-control" placeholder="<?= trans("order_number"); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                                        </div>
                                        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                            <label style="display: block">&nbsp;</label>
                                            <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th><?= trans('id'); ?></th>
                            <th><?= trans('report_type'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('receipt'); ?></th>
                            <th><?= trans('payment_note'); ?></th>
                            <th><?= trans('status'); ?></th>
                            <th><?= trans('ip_address'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($bankTransfers)):
                            foreach ($bankTransfers as $item): ?>
                                <tr>
                                    <td><?= $item->id; ?></td>
                                    <td>
                                        <?= trans($item->report_type); ?>
                                        <?php if ($item->report_type == 'order'):
                                            $order = getOrderByOrderNumber($item->order_number);
                                            if (!empty($order)): ?>
                                                <a href="<?= adminUrl('order-details/' . $order->id); ?>" class="table-link" target="_blank">&nbsp;(#<?= $item->order_number; ?>)</a>
                                            <?php else: ?>
                                                &nbsp;(#<?= $item->order_number; ?>)
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->user_id == 0): ?>
                                            <label class="label bg-olive"><?= trans("guest"); ?></label>
                                        <?php else: ?>
                                            <a href="<?= generateProfileUrl($item->user_slug); ?>" target="_blank" class="table-link">
                                                <?= esc($item->user_username); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item->receipt_path)):
                                            if (pathinfo($item->receipt_path, PATHINFO_EXTENSION) === 'pdf'):?>
                                                <a href="<?= base_url($item->receipt_path); ?>" target="_blank"><?= trans("view_pdf_file"); ?></a>
                                            <?php else: ?>
                                                <a class="magnific-image-popup" href="<?= base_url($item->receipt_path); ?>">
                                                    <img src="<?= base_url($item->receipt_path); ?>" alt="" class="img-thumbnail" style="max-width: 60px; max-height: 60px;">
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="max-width: 300px;"><?= esc($item->payment_note); ?></td>
                                    <td>
                                        <?php if ($item->status == 'pending'): ?>
                                            <label class="label label-default"><?= trans("pending"); ?></label>
                                        <?php elseif ($item->status == 'approved'): ?>
                                            <label class="label label-success"><?= trans("approved"); ?></label>
                                        <?php elseif ($item->status == 'declined'): ?>
                                            <label class="label label-danger"><?= trans("declined"); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item->ip_address; ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <?php if ($item->status == 'pending'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="approveBankTransfer('<?= $item->id; ?>','<?= trans("confirm_action", true); ?>');"><i class="fa fa-check option-icon"></i><?= trans('approve'); ?></a>
                                                    </li>
                                                    <li>
                                                        <form action="<?= base_url('Admin/bankTransferOptionsPost'); ?>" method="post">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="report_id" value="<?= $item->id; ?>">
                                                            <button type="submit" name="option" value="declined" class="btn-list-button"><i class="fa fa-times option-icon"></i><?= trans('decline'); ?></button>
                                                        </form>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Admin/deleteBankTransferPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($bankTransfers)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>