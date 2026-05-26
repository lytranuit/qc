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
                        <button type="button" class="btn btn-sm btn-warning float-right mr-2" data-toggle="modal" data-target="#password-modal"><i class="fas fa-lock"></i> Đổi mật khẩu</button>
                        <button type="button" id="btn-unlock" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-unlock"></i> Mở khóa đăng nhập</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Username:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type="text" name="username" readonly="" disabled placeholder="Username" aria-required="true">
                                </div>

                                <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm price" type="text" name="name" required="" placeholder="Tên" im-insert="true" aria-required="true">
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

<!-- THAY DOI MAT KHAU Modal-->
<div aria-hidden="true" aria-labelledby="password-modalLabel" class="modal fade" id="password-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="password-modalLabel">
                    Đổi mật khẩu
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-changepass">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <b class="form-label">Mật khẩu mới (ít nhất 6 ký tự):</b>
                        <div class="form-line">
                            <input type="password" class="form-control" id="newpassword" name="newpassword" minlength="6" required="" aria-required="true">
                        </div>
                        <div class="password-requirements mt-1" style="font-size: 12px;">
                            <div id="req-length" class="text-danger">&#10007; Ít nhất 6 ký tự</div>
                            <div id="req-lower" class="text-danger">&#10007; Ít nhất 1 chữ thường (a-z)</div>
                            <div id="req-upper" class="text-danger">&#10007; Ít nhất 1 chữ hoa (A-Z)</div>
                            <div id="req-number" class="text-danger">&#10007; Ít nhất 1 số (0-9)</div>
                            <div id="req-special" class="text-danger">&#10007; Ít nhất 1 ký tự đặc biệt</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <b class="form-label">Xác nhận mật khẩu mới:</b>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirmpassword" minlength="6" required="" aria-required="true">
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit" name="btn_changepass">Lưu lại</button>
                </form>
            </div>
        </div>
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

    var tin = <?= json_encode($tin) ?>;
    fillForm($("#form-dang-tin"), tin);
    $(document).ready(function() {
        $(".image_ft").imageFeature();

        $("select[name='groups[]'],select[name='factories[]']").chosen();

        $.validator.setDefaults({
            debug: true,
            success: "valid"
        });

        if (tin.image_url) {
            $(".image_ft").imageFeature("set_image", tin.image_url);
        }
        $("#form-dang-tin").validate({
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

        // Realtime password validation
        $('#newpassword').on('input', function() {
            validateStrongPassword($(this).val());
        });

        // Change password AJAX
        $("button[name='btn_changepass']").click(function(e) {
            e.preventDefault();

            var pwd = $('#newpassword').val();
            if (!validateStrongPassword(pwd)) {
                alert('Mật khẩu mới chưa đạt yêu cầu. Vui lòng kiểm tra lại.');
                return false;
            }

            $.ajax({
                url: path + "admin/user/changepass/" + tin.id,
                data: $("#form-changepass").serialize(),
                dataType: "JSON",
                type: "POST",
                success: function(data) {
                    alert(data.msg);
                    if (data.code == 400) {
                        $('#password-modal').modal('hide');
                        $('#form-changepass')[0].reset();
                        // Reset checklist
                        $('#newpassword').trigger('input');
                    }
                }
            });
            return false;
        });

        // Unlock login AJAX
        $('#btn-unlock').click(function() {
            if (!confirm('Bạn có chắc muốn mở khóa đăng nhập cho user này?')) return;
            $.ajax({
                url: path + "admin/user/unlock/" + tin.id,
                dataType: "JSON",
                type: "POST",
                data: { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
                success: function(data) {
                    alert(data.msg);
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>