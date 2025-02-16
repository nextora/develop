<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateUrl('settings', 'edit_profile'); ?>"><?= trans("profile_settings"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= trans("profile_settings"); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= view("settings/_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="sidebar-tabs-content">
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('delete-account-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
                            <?php if (user()->account_delete_req == 1): ?>
                                <div class="alert alert-info" role="alert">
                                    <?= trans("delete_account_submit_exp"); ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= trans("delete_account_exp"); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("password"); ?></label>
                                    <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" minlength="4" maxlength="255" required>
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-md btn-custom m-t-10"><?= trans("delete_account") ?></button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>