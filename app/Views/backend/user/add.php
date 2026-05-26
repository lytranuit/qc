<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>

            <input type="hidden" name="parent_id" value="0" />
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Username:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type="text" name="username" required="" placeholder="Username" aria-required="true">
                                </div>

                                <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm price" type="text" name="name" required="" placeholder="Tên" im-insert="true" aria-required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mât khẩu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input type="password" id="password" class="form-control" name="password" minlength="6" required="" aria-required="true">
                                    <div class="password-requirements mt-1" style="font-size: 12px;">
                                        <div id="req-length" class="text-danger">&#10007; Ít nhất 6 ký tự</div>
                                        <div id="req-lower" class="text-danger">&#10007; Ít nhất 1 chữ thường (a-z)</div>
                                        <div id="req-upper" class="text-danger">&#10007; Ít nhất 1 chữ hoa (A-Z)</div>
                                        <div id="req-number" class="text-danger">&#10007; Ít nhất 1 số (0-9)</div>
                                        <div id="req-special" class="text-danger">&#10007; Ít nhất 1 ký tự đặc biệt</div>
                                    </div>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Xác nhận mật khẩu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input type="password" class="form-control" name="confirmpassword" minlength="6" data-rule-equalTo="#password" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group row">

                                <b class="col-12 col-lg-2 col-form-label">Số điện thoại:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm price" type="text" name="phone" placeholder="Số điện thoại" im-insert="true" aria-required="true">
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Địa chỉ:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm price" type="text" name="address" placeholder="Địa chỉ" im-insert="true" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-12 col-form-label">Mô tả:</b>
                                <div class="col-12 col-lg-12 pt-1">
                                    <textarea class="form-control form-control-sm" type="text" name="description" placeholder="Mô tả" aria-required="true"></textarea>
                                </div>

                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Nhóm:</b>
                                <div class="col-lg-4 pt-1">
                                    <select name="groups[]" style="width: 200px;" multiple="">
                                        <?php foreach ($groups as $row) : ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['description'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label text-sm-right">Active:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <div class="switch-button switch-button-success">
                                        <input type="hidden" name="active" value="0" class="input-tmp">
                                        <input type="checkbox" checked="" name="active" id="switch19" value="1">
                                        <span>
                                            <label for="switch19"></label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Nhà máy:</b>
                                <div class="col-lg-4 pt-1">
                                    <select name="factories[]" style="width: 200px;" multiple="">
                                        <?php foreach ($factories as $row) : ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-12 pt-2 text-center">
                                    <div class="card no-shadow border">
                                        <div class="card-header">
                                            Image
                                        </div>
                                        <div class="card-body">
                                            <div id="image_url" class="image_ft"></div>
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


<!-- Script --->
<?= $this->section('style') ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/chosen/chosen.min.css") ?> " ?>
<?= $this->endSection() ?>
<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/ckfinder/ckfinder.js") ?>"></script>
<script src="<?= base_url("assets/lib/image_feature/jquery.image_v2.js") ?>"></script>
<script src="<?= base_url("assets/lib/chosen/chosen.jquery.js") ?>"></script>
<script type='text/javascript'>
    function checkPasswordReq(id, passed) {
        var el = document.getElementById(id);
        if (!el) return;
        var text = el.textContent.replace(/^[\u2713\u2717]\s*/, '');
        el.className = passed ? 'text-success' : 'text-danger';
        el.textContent = (passed ? '\u2713 ' : '\u2717 ') + text;
    }

    function validateStrongPassword(val) {
        var ok = true;
        var checks = {
            'req-length': val.length >= 6,
            'req-lower': /[a-z]/.test(val),
            'req-upper': /[A-Z]/.test(val),
            'req-number': /[0-9]/.test(val),
            'req-special': /[^a-zA-Z0-9]/.test(val)
        };
        for (var id in checks) {
            checkPasswordReq(id, checks[id]);
            if (!checks[id]) ok = false;
        }
        return ok;
    }

    $(document).ready(function() {
        $(".image_ft").imageFeature();

        $("select[name='factories[]']").chosen();
        $("select[name='groups[]']").val(2).chosen();

        // Realtime password validation
        $('#password').on('input', function() {
            validateStrongPassword($(this).val());
        });

        // Add custom validator method
        $.validator.addMethod('strongPassword', function(value, element) {
            return this.optional(element) || validateStrongPassword(value);
        }, 'Mật khẩu phải có ít nhất 6 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');

        $.validator.setDefaults({
            debug: true,
            success: "valid",
        });
        $("#form-dang-tin").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                    strongPassword: true
                }
            },
            highlight: function(input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function(input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function(error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function(form) {
                form.submit();
                return false;
            }
        });
    });
</script>

<?= $this->endSection() ?>