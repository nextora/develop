<?php $paddingStyle = '';
if (!empty($padding)) {
    if ($baseVars->rtl == true) {
        $paddingStyle = 'padding-right: 30px;';
    } else {
        $paddingStyle = 'padding-left: 30px;';
    }
}

$padding = !empty($paddingLeft) ? 'padding-left: 30px;' : '';
if (!empty($categories)):
    foreach ($categories as $category):?>
        <div class="panel-group" draggable="false" style="<?= $paddingStyle; ?>">
            <div data-item-id="<?= $category->id; ?>" class="panel panel-default">
                <div id="panel_heading_parent_<?= $category->id; ?>" class="panel-heading <?= !empty($category->has_subcategory) ? 'panel-heading-parent' : ''; ?>" data-item-id="<?= $category->id; ?>" href="#collapse_<?= $category->id; ?>">
                    <div class="left">
                        <?php if (!empty($category->has_subcategory)): ?>
                            <i class="fa fa-caret-right"></i>
                        <?php else: ?>
                            <i class="fa fa-circle" style="font-size: 8px;"></i>
                        <?php endif; ?>
                        <?= getCategoryName($category, $activeLang->id); ?> <span class="id">( <?= trans("id") . ': ' . $category->id; ?>)</span></div>
                    <div class="right">
                        <?php if ($category->is_featured == 1): ?>
                            <label class="label bg-teal"><?= trans("featured"); ?></label>
                        <?php endif; ?>
                        <?php if ($category->visibility == 1): ?>
                            <label class="label bg-olive"><?= trans("visible"); ?></label>
                        <?php else: ?>
                            <label class="label bg-danger"><?= trans("hidden"); ?></label>
                        <?php endif; ?>
                        <div class="btn-group">
                            <a href="<?= adminUrl('edit-category/' . $category->id); ?>" target="_blank" class="btn btn-sm btn-default btn-edit"><?= trans("edit"); ?></a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-item-id="<?= $category->id; ?>"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>
                </div>
                <?php if (!empty($category->has_subcategory)): ?>
                    <div id="collapse_<?= $category->id; ?>" class="panel-collapse collapse" aria-expanded="true" style="">
                        <div class="panel-body" style="padding: 20px 0;">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach;
endif; ?>