<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_brand'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("brands"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('brands'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Category/editBrandPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $brand->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <?php foreach ($activeLanguages as $language): ?>
                            <input type="text" class="form-control m-b-5" name="name_lang_<?= $language->id; ?>" placeholder="<?= esc($language->name); ?>" value="<?= getBrandName($brand->name_data, $language->id); ?>" maxlength="255">
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <?= view("admin/includes/_category_picker", ['strCategoryIds' => $brand->category_data]); ?>
                    </div>
                    <div class="form-group">
                        <label><?= trans("show_on_slider"); ?></label>
                        <?= formRadio('show_on_slider', 1, 0, trans("yes"), trans("no"), $brand->show_on_slider, 'col-lg-4'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('logo'); ?>&nbsp;(<?= trans("optional"); ?>)</label>
                        <?php if (!empty($brand->image_path)): ?>
                            <div class="display-block m-b-10">
                                <img src="<?= base_url($brand->image_path); ?>" width="128">
                            </div>
                        <?php endif; ?>
                        <div class="display-block">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= trans('select_logo'); ?>
                                <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info<?= $brand->id; ?>').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                            (.png, .jpg, .jpeg, .gif)
                        </div>
                        <span class='label label-info' id="upload-file-info<?= $brand->id; ?>"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .select2-container {
        z-index: 99999999 !important;
    }

    .btn-select-category {
        display: none;
    }

    .btn-category-name:hover, .btn-category-name:focus, .btn-category-name:active {
        background-color: #f4f4f4 !important;
        color: #444 !important;
        border-color: #ddd !important;
    }

    .btn-group {
        margin-bottom: 5px;
        margin-right: 5px;
    }
</style>

