<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    <?php if (in_groups(array("admin", "editor"))): ?>
                        <div class="d-inline-block w-100">
                            <span>Chỉnh sửa khu vực lưu mẫu</span>
                            <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                        </div>
                    <?php endif ?>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div id="menu0" class="tab-pane active">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-1 col-form-label">Tên:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-3 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name"
                                                required="" placeholder="Tên khu vực" />
                                        </div>
                                        <b class="col-12 col-lg-1 col-form-label">Mã số:</b>
                                        <div class="col-12 col-lg-3 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="code"
                                                placeholder="Code" />
                                        </div>
                                        <b class="col-12 col-lg-1 col-form-label">Điều kiện lưu mẫu:</b>
                                        <div class="col-12 col-lg-3 pt-1">
                                            <select name="env_type" class="form-control form-control-sm">
                                                <option value="">-- Chọn loại --</option>
                                                <?php foreach ($list_env_type as $et): ?>
                                                    <option value="<?= $et->id ?>" <?= (isset($tin->env_type) && $tin->env_type == $et->id) ? 'selected' : '' ?>><?= $et->name ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
<?= $this->endSection() ?>


<!-- Style -->
<?= $this->section("style") ?>
<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script -->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>
<script type='text/javascript'>
    var tin = <?= json_encode($tin) ?>;
    var controller = '<?= $controller ?>';
    fillForm($("#form-dang-tin"), tin);
    $(document).ready(function () {
        $.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        $("#form-dang-tin").validate({
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function (form) {
                form.submit();
                return false;
            }
        });
    });
</script>

<?= $this->endSection() ?>