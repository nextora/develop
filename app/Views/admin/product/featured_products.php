<?php $categoryModel = new \App\Models\CategoryModel(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/product/_filter_products', ['categoryModel' => $categoryModel]); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('product'); ?></th>
                            <th><?= trans('sku'); ?></th>
                            <th><?= trans('product_type'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('purchased_plan'); ?></th>
                            <th><?= trans('remaining_days'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= $item->id; ?></td>
                                    <td class="td-product">
                                        <?php if ($item->is_promoted == 1): ?>
                                            <label class="label label-success"><?= trans("featured"); ?></label>
                                        <?php endif; ?>
                                        <div class="img-table">
                                            <a href="<?= generateProductUrl($item); ?>" target="_blank">
                                                <img src="<?= getProductItemImage($item); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                            </a>
                                        </div>
                                        <a href="<?= generateProductUrl($item); ?>" target="_blank" class="table-product-title">
                                            <?= getProductTitle($item); ?>
                                        </a>
                                    </td>
                                    <td><?= $item->sku; ?></td>
                                    <td><?= trans($item->product_type); ?></td>
                                    <td>
                                        <?php $category = new stdClass();
                                        $category->name = $item->category_name;
                                        echo getCategoryName($category, $activeLang->id); ?>
                                    </td>
                                    <td>
                                        <?php if ($item->is_promoted == 1) {
                                            echo esc($item->promote_plan);
                                        } ?>
                                    </td>
                                    <td style="min-width: 120px;">
                                        <?php if ($item->is_promoted == 1): ?>
                                            <strong><?= dateDifference($item->promote_end_date, date('Y-m-d H:i:s')); ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= generateProfileUrl($item->user_slug); ?>" target="_blank" class="table-username">
                                            <?= esc($item->user_username); ?>
                                        </a>
                                    </td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans("select_option"); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('product-details/' . $item->id); ?>"><i class="fa fa-info option-icon"></i><?= trans("view_details"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="removeFromFeatured('<?= $item->id; ?>');"><i class="fa fa-minus option-icon"></i><?= trans("remove_from_featured"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?= generateDashUrl('edit_product') . '/' . $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?= trans("edit"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProduct','<?= $item->id; ?>','<?= trans("confirm_product", true); ?>');"><i class="fa fa-times option-icon"></i><?= trans('delete'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProductPermanently','<?= $item->id; ?>','<?= trans("confirm_product_permanent", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete_permanently'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                            <?php if (count($products) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><?= trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>