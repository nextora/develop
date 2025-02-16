<link rel="stylesheet" href="<?= base_url('assets/vendor/file-uploader/css/jquery.dm-uploader.min.css'); ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/vendor/file-uploader/css/styles.css'); ?>"/>
<script src="<?= base_url('assets/vendor/file-uploader/js/jquery.dm-uploader.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/file-uploader/js/ui.js'); ?>"></script>

<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $title; ?></h3><br>
                    <small><?= trans("bulk_product_upload_exp"); ?></small>
                </div>
            </div>
            <div id="tabsBox" class="box-body tabs-box-add">
                <ul class="nav nav-tabs nav-tabs-action">
                    <li class="active" data-action="add"><a data-toggle="tab" href="#tab1" data-action="add"><?= trans("add_products"); ?></a></li>
                    <li data-action="edit"><a data-toggle="tab" href="#tab2" data-action="edit"><?= trans("edit_products"); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane in active">
                        <div class="form-group">
                            <label class="control-label"><?= trans("listing_type"); ?></label>
                            <select id="select_listing_type" name="listing_type" class="form-control custom-select" required>
                                <option value=""><?= trans("select"); ?></option>
                                <?php if ($generalSettings->marketplace_system == 1): ?>
                                    <option value="sell_on_site"><?= trans('add_product_for_sale'); ?></option>
                                <?php endif;
                                if ($generalSettings->classified_ads_system == 1): ?>
                                    <option value="ordinary_listing"><?= trans('add_product_services_listing'); ?></option>
                                <?php endif;
                                if ($generalSettings->bidding_system == 1): ?>
                                    <option value="bidding"><?= trans('add_product_get_price_requests'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans("currency"); ?></label>
                            <select id="select_currency" name="currency" class="form-control custom-select" required>
                                <option value=""><?= trans("select"); ?></option>
                                <?php if (!empty($currencies)):
                                    foreach ($currencies as $key => $value): ?>
                                        <option value="<?= $key; ?>" <?= $key == $defaultCurrency->code ? 'class="default"' : ''; ?>><?= $key . ' (' . $value->symbol . ')'; ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane"></div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('csv_file'); ?></label>
                    <div class="dm-uploader-container">
                        <div id="drag-and-drop-zone" class="dm-uploader dm-uploader-csv text-center">
                            <p class="dm-upload-icon">
                                <i class="fa fa-cloud-upload"></i>
                            </p>
                            <p class="dm-upload-text"><?= trans("drag_drop_file_here"); ?></p>
                            <p class="text-center">
                                <button class="btn btn-default btn-browse-files"><?= trans('browse_files'); ?></button>
                            </p>
                            <a class='btn btn-md dm-btn-select-files'>
                                <input type="file" name="file" size="40" multiple="multiple">
                            </a>
                            <ul class="dm-uploaded-files" id="files-file"></ul>
                            <button type="button" id="btn_reset_upload" class="btn btn-reset-upload"><?= trans("reset"); ?></button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="csv_upload_spinner" class="csv-upload-spinner">
                                <strong class="text-csv-importing"><?= trans("processing"); ?></strong>
                                <strong class="text-csv-import-completed"><?= trans("completed"); ?>!</strong>
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="csv-uploaded-files-container">
                                <ul id="csv_uploaded_files" class="list-group csv-uploaded-files"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('help_documents'); ?></h3><br>
                    <small><?= trans("help_documents_exp"); ?></small>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <form action="<?= base_url('Dashboard/downloadCsvFilePost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <button class="btn btn-success btn-block" name="submit" value="csv_template"><?= trans("download_csv_template"); ?></button>
                        <button class="btn btn-blue btn-block" name="submit" value="csv_example"><?= trans("download_csv_example"); ?></button>
                        <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDocumentation"><?= trans("documentation"); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('category_id_finder'); ?></h3><br>
                    <small><?= trans("category_id_finder_exp"); ?></small>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group form-group-category">
                    <select id="categories" name="category_id[]" class="select2 form-control subcategory-select m-0" onchange="getSubCategoriesDashboard(this.value, 1, <?= selectedLangId(); ?>);" required>
                        <option value=""><?= trans('select_category'); ?></option>
                        <?php if (!empty($parentCategories)):
                            foreach ($parentCategories as $item): ?>
                                <option value="<?= esc($item->id); ?>"><?= getCategoryName($item, $activeLang->id); ?>&nbsp;(ID: <?= $item->id; ?>)</option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                    <div id="category_select_container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDocumentation" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0;">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?= trans('bulk_product_upload'); ?></h4>
            </div>
            <div class="modal-body">
                <?= $baseSettings->bulk_upload_documentation; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var obj_csv = {
        action: '',
        listing_type: '',
        currency: ''
    };
    $(function () {
        $('#drag-and-drop-zone').dmUploader({
            url: '<?= base_url('Dashboard/generateCsvObjectPost'); ?>',
            multiple: false,
            extFilter: ["csv"],
            extraData: function (id) {
                return {
                    '<?= csrf_token() ?>': '<?= csrf_hash(); ?>'
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function (id, file) {
                obj_csv.action = $('.nav-tabs .active').attr('data-action');
                if (obj_csv.action != 'edit') {
                    var listing = $("#select_listing_type").val();
                    if (listing.length < 1) {
                        $('#select_listing_type').addClass("is-invalid");
                        return false;
                    } else {
                        $('#select_listing_type').removeClass("is-invalid");
                    }
                    var currency = $("#select_currency").val();
                    if (currency.length < 1) {
                        $('#select_currency').addClass("is-invalid");
                        return false;
                    } else {
                        $('#select_currency').removeClass("is-invalid");
                    }
                }
                $("#csv_upload_spinner").show();
                $("#csv_upload_spinner .spinner").show();
                $("#csv_upload_spinner .text-csv-importing").show();
                $("#csv_upload_spinner .text-csv-import-completed").hide();
                $("#csv_uploaded_files").empty();

                $('#csv_upload_spinner').removeClass('tab-element-add');
                $('#csv_upload_spinner').removeClass('tab-element-edit');
                $('#csv_uploaded_files').removeClass('tab-element-add');
                $('#csv_uploaded_files').removeClass('tab-element-edit');
                $('#csv_upload_spinner').addClass('tab-element-' + obj_csv.action);
                $('#csv_uploaded_files').addClass('tab-element-' + obj_csv.action);
            },
            onUploadSuccess: function (id, response) {
                //set form values
                obj_csv.currency = $("#select_currency").val();
                obj_csv.listing_type = $("#select_listing_type").val();
                var number_of_items = 0;
                var txt_file_name = "";
                try {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        number_of_items = obj.number_of_items;
                        txt_file_name = obj.txt_file_name;
                        if (number_of_items > 0) {
                            add_csv_item(number_of_items, txt_file_name, 1);
                        } else {
                            $("#csv_upload_spinner").hide();
                        }
                    } else {
                        $("#csv_upload_spinner").hide();
                    }
                } catch (e) {
                    alert("Invalid CSV file! Make sure there are no double quotes in your content. Double quotes can brake the CSV structure.");
                }
            }
        });
    });

    function add_csv_item(number_of_items, txt_file_name, index) {
        if (index <= number_of_items) {
            var data = {
                'txt_file_name': txt_file_name,
                'index': index,
                'action': obj_csv.action,
                'listing_type': obj_csv.listing_type,
                'currency': obj_csv.currency
            };
            $.ajax({
                type: 'POST',
                url: MdsConfig.baseURL + '/Dashboard/importCsvItemPost',
                data: setAjaxData(data),
                success: function (response) {
                    try {
                        var obj_sub = JSON.parse(response);
                        if (obj_sub.result == 1) {
                            var indexLabel = '';
                            if (obj_sub.show_index) {
                                indexLabel = obj_sub.index + '.&nbsp;'
                            }
                            $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-success"><i class="fa fa-check"></i>&nbsp;' + indexLabel + obj_sub.name + '</li>');
                        } else if (obj_sub.result == 2) {
                            $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-danger"><i class="fa fa-times"></i>&nbsp;' + obj_sub.index + '.&nbsp;' + obj_sub.name + '</li>');
                        } else {
                            $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-danger"><i class="fa fa-times"></i>&nbsp;' + obj_sub.index + '.</li>');
                        }
                        if (obj_sub.index == number_of_items) {
                            $("#csv_upload_spinner .text-csv-importing").hide();
                            $("#csv_upload_spinner .spinner").hide();
                            $("#csv_upload_spinner .text-csv-import-completed").css('display', 'block');
                        }
                    } catch (e) {
                        alert(response);
                    }
                    index = index + 1;
                    add_csv_item(number_of_items, txt_file_name, index);
                },
                error: function (response) {
                    $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-danger"><i class="fa fa-times"></i>&nbsp;' + index + '.</li>');
                    if (index == number_of_items) {
                        $("#csv_upload_spinner .text-csv-importing").hide();
                        $("#csv_upload_spinner .spinner").hide();
                        $("#csv_upload_spinner .text-csv-import-completed").css('display', 'block');
                    }
                    index = index + 1;
                    add_csv_item(number_of_items, txt_file_name, index);
                }
            });
        }
    }

    $(document).on("input", "#input_category_name", function () {
        var val = $(this).val();
        val = val.trim();
        if (val.length > 1) {
            var data = {
                'category_name': val
            };
            $.ajax({
                type: 'POST',
                url: MdsConfig.baseURL + '/Ajax/searchCategories',
                data: setAjaxData(data),
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        document.getElementById("category_search_result").innerHTML = obj.content;
                    }
                }
            });
        } else {
            document.getElementById("category_search_result").innerHTML = "";
        }
    });

    $(document).on("change", "#select_listing_type", function () {
        var val = $(this).val();
        if (val == "ordinary_listing") {
            $("#select_currency").addClass("select-currency-all");
            $("#select_currency").removeClass("select-currency-default");
        } else {
            $("#select_currency").removeClass("select-currency-all");
            $("#select_currency").addClass("select-currency-default");
        }
        $("#select_listing_type").removeClass("is-invalid");
        $("#select_currency").prop('selectedIndex', 0);
    });
    $(document).on("change", "#select_currency", function () {
        $("#select_currency").removeClass("is-invalid");
    });

    function getSubCategoriesDashboard(parentId, level, langId) {
        level = parseInt(level);
        var newLevel = level + 1;
        var data = {
            'parent_id': parentId,
            'lang_id': langId,
            'show_ids': true
        };
        $.ajax({
            type: 'POST',
            url: MdsConfig.baseURL + '/Ajax/getSubCategories',
            data: setAjaxData(data),
            success: function (response) {
                $('.subcategory-select-container').each(function () {
                    if (parseInt($(this).attr('data-level')) > level) {
                        $(this).remove();
                    }
                });
                var obj = JSON.parse(response);
                if (obj.result == 1 && obj.htmlContent != '') {
                    var selectTag = '<div class="subcategory-select-container m-t-5" data-level="' + newLevel + '"><select class="select2 form-control subcategory-select" data-level="' + newLevel + '" name="category_id[]" onchange="getSubCategoriesDashboard(this.value,' + newLevel + ',' + langId + ');">' +
                        '<option value=""><?= trans('select_category'); ?></option>' + obj.htmlContent + '</select></div>';
                    $('#category_select_container').append(selectTag);
                }
            }
        });
    }

    $(document).on('click', '.nav-tabs-action li a', function () {
        var action = $(this).attr('data-action');
        $("#tabsBox").removeClass('tabs-box-add');
        $("#tabsBox").removeClass('tabs-box-edit');
        $("#tabsBox").addClass('tabs-box-' + action);
    });
</script>

<style>
    #select_currency option {
        display: none;
    }

    .select-currency-default .default {
        display: block !important;
    }

    .select-currency-all option {
        display: block !important;
    }

    .nav-tabs {
        margin-bottom: 30px;
    }

    .nav-tabs li a {
        color: #414456 !important;
        padding: 10px 30px;
        font-weight: 600;
    }

    .tabs-box-add .tab-element-edit {
        display: none !important;
    }

    .tabs-box-edit .tab-element-add {
        display: none !important;
    }


    .tab-content > .tab-pane {
        transition: none !important;
    }
</style>