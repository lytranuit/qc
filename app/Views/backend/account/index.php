<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-fluid">
    <div class="card-header drag-handle">
        <?= lang("Custom.info") ?>
    </div>
    <div class="card-body">
        <form id="form_advanced_validation" method="POST" novalidate="novalidate">
            <?= csrf_field() ?>
            <div class="form-group">
                <b class="form-label"><?= lang("Custom.login_identity_label") ?></b>
                <div class="form-line">
                    <input type="text" class="form-control" value="<?= $user->username ?>" name="username" required="" aria-required="true" disabled="">
                </div>
                <div class="help-info"></div>
            </div>
            <div class="form-group">
                <b class="form-label"><?= lang("Custom.login_name_label") ?></b>
                <div class="form-line">
                    <input type="text" class="form-control" value="<?= $user->name ?>" name="name" minlength="3" required="" aria-required="true">
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <a href="#" data-target="#password-modal" data-toggle="modal">
                    <i class="fas fa-lock" style='font-size: 20px;vertical-align: middle;'></i>
                    <span><?= lang("Custom.thay_doi_password") ?></span>
                </a>
            </div>
            <button class="btn btn-primary waves-effect" type="submit" name="edit_user"><?= lang("Custom.change_password_submit_btn") ?></button>
        </form>
    </div>
</div>
<!-- THAY DOI MAT KHAU Modal-->
<div aria-hidden="true" aria-labelledby="password-modalLabel" class="modal fade" id="password-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="comment-modalLabel">
                    <?= lang("Custom.thay_doi_password") ?>
                </div>
            </div>
            <div class="modal-body">
                <div class="main">
                    <!--<p>Sign up once and watch any of our free demos.</p>-->
                    <form id="form-password">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <b class="form-label"><?= lang("Custom.change_password_old_password_label") ?></b>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" required="" aria-required="true">
                            </div>
                            <div class="help-info"></div>
                        </div>
                        <div class="form-group">
                            <b class="form-label"><?= lang("Custom.change_password_new_password_label", [6]) ?></b>
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
                            <b class="form-label"><?= lang("Custom.change_password_new_password_confirm_label") ?></b>
                            <div class="form-line">
                                <input type="password" class="form-control" name="confirmpassword" minlength="6" required="" aria-required="true">
                            </div>
                        </div>
                        <button class="btn btn-primary waves-effect" type="submit" name="edit_password"><?= lang("Custom.change_password_submit_btn") ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>
<script>
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
        // Realtime password validation
        $('#newpassword').on('input', function() {
            validateStrongPassword($(this).val());
        });

        $("button[name='edit_password']").click(function(e) {
            e.preventDefault();

            // Validate strong password before submit
            var pwd = $('#newpassword').val();
            if (!validateStrongPassword(pwd)) {
                alert('Mật khẩu mới chưa đạt yêu cầu. Vui lòng kiểm tra lại.');
                return false;
            }

            $.ajax({
                url: path + "admin/account/changepass",
                data: $("#form-password").serialize(),
                dataType: "JSON",
                type: "POST",
                success: function(data) {
                    alert(data.msg);
                    if (data.code == 400) {
                        location.reload();
                    }
                }
            });
            return false;
        });
    })
</script>
<?= $this->endSection() ?>