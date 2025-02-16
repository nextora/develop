<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_user'); ?></h3>
                </div>
            </div>
            <form action="<?= base_url('Membership/editUserPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($user->id); ?>">
                <div class="box-body">
                    <?php $role = getRoleById($user->role_id);
                    if (!empty($role)): ?>
                        <div class="form-group">
                            <label class="label label-success"><?= esc(getRoleName($role)); ?></label>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-profile">
                                <img src="<?= getUserAvatar($user); ?>" alt="avatar" class="thumbnail img-responsive img-update" style="max-width: 200px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-profile">
                                <p>
                                    <a class="btn btn-success btn-sm btn-file-upload">
                                        <?= trans('select_image'); ?>
                                        <input name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));" type="file">
                                    </a>
                                </p>
                                <p class='label label-info' id="upload-file-info"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= trans('email'); ?></label>
                        <input type="email" class="form-control form-input" name="email" placeholder="<?= trans('email'); ?>" value="<?= esc($user->email); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('shop_name'); ?>&nbsp;(<?= trans("username"); ?>)</label>
                        <input type="text" class="form-control form-input" name="username" placeholder="<?= trans('shop_name'); ?>" value="<?= esc($user->username); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('slug'); ?></label>
                        <input type="text" class="form-control form-input" name="slug" placeholder="<?= trans('slug'); ?>" value="<?= esc($user->slug); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('first_name'); ?></label>
                        <input type="text" class="form-control form-input" name="first_name" placeholder="<?= trans('first_name'); ?>" value="<?= esc($user->first_name); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('last_name'); ?></label>
                        <input type="text" class="form-control form-input" name="last_name" placeholder="<?= trans('last_name'); ?>" value="<?= esc($user->last_name); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('phone_number'); ?></label>
                        <input type="text" class="form-control form-input" name="phone_number" placeholder="<?= trans('phone_number'); ?>" value="<?= esc($user->phone_number); ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('shop_description'); ?></label>
                        <textarea class="form-control text-area" name="about_me" placeholder="<?= trans('shop_description'); ?>"><?= esc($user->about_me); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('location'); ?></label>
                        <?= view('partials/_location', ['countries' => $countries, 'countryId' => $user->country_id, 'stateId' => $user->state_id, 'cityId' => $user->city_id, 'isLocationOptional' => true]); ?>
                        <div class="row">
                            <div class="col-12 col-sm-6 m-b-sm-15">
                                <input type="text" name="address" class="form-control form-input" value="<?= esc($user->address); ?>" placeholder="<?= trans("address") ?>">
                            </div>
                            <div class="col-12 col-sm-3">
                                <input type="text" name="zip_code" class="form-control form-input" value="<?= esc($user->zip_code); ?>" placeholder="<?= trans("zip_code") ?>">
                            </div>
                        </div>
                    </div>
                    <?php $socialArray = getSocialLinksArray($user, true);
                    foreach ($socialArray as $item):?>
                        <div class="form-group">
                            <label class="control-label"><?= trans($item['inputName']); ?></label>
                            <input type="text" class="form-control" name="<?= $item['inputName']; ?>" placeholder="<?= trans($item['inputName']); ?>" value="<?= esc($item['value']); ?>" maxlength="1000">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function getStates(val) {
        $('#select_states').children('option').remove();
        $('#select_cities').children('option').remove();
        $('#get_states_container').hide();
        $('#get_cities_container').hide();
        var data = {
            'country_id': val
        };
        $.ajax({
            type: 'POST',
            url: MdsConfig.baseURL + '/Ajax/getStates',
            data: setAjaxData(data),
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_states").innerHTML = obj.content;
                    $('#get_states_container').show();
                } else {
                    document.getElementById("select_states").innerHTML = '';
                    $('#get_states_container').hide();
                }
            }
        });
    }

    function getCities(val) {
        var data = {
            "state_id": val
        };
        $.ajax({
            type: 'POST',
            url: MdsConfig.baseURL + '/Ajax/getCities',
            data: setAjaxData(data),
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_cities").innerHTML = obj.content;
                    $('#get_cities_container').show();
                } else {
                    document.getElementById("select_cities").innerHTML = '';
                    $('#get_cities_container').hide();
                }
            }
        });
    }
</script>