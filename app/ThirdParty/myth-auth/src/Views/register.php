<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <div class="card">
                <h2 class="card-header"><?=lang('Auth.register')?></h2>
                <div class="card-body">

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <form action="<?= route_to('register') ?>" method="post" id="form-register">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="email"><?=lang('Auth.email')?></label>
                            <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                   name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                            <small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                        </div>

                        <div class="form-group">
                            <label for="username"><?=lang('Auth.username')?></label>
                            <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                        </div>

                        <div class="form-group">
                            <label for="password"><?=lang('Auth.password')?></label>
                            <input type="password" id="password" name="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                            <div id="password-requirements" class="mt-2" style="font-size: 13px;">
                                <div id="req-length" class="text-danger">&#10007; Ít nhất 6 ký tự</div>
                                <div id="req-lower" class="text-danger">&#10007; Ít nhất 1 chữ thường (a-z)</div>
                                <div id="req-upper" class="text-danger">&#10007; Ít nhất 1 chữ hoa (A-Z)</div>
                                <div id="req-number" class="text-danger">&#10007; Ít nhất 1 số (0-9)</div>
                                <div id="req-special" class="text-danger">&#10007; Ít nhất 1 ký tự đặc biệt (!@#$%^...)</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass_confirm"><?=lang('Auth.repeatPassword')?></label>
                            <input type="password" name="pass_confirm" class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.register')?></button>
                    </form>


                    <hr>

                    <p><?=lang('Auth.alreadyRegistered')?> <a href="<?= route_to('login') ?>"><?=lang('Auth.signIn')?></a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function() {
    var pwd = document.getElementById('password');
    var form = document.getElementById('form-register');
    if (!pwd || !form) return;

    function checkReq(id, passed) {
        var el = document.getElementById(id);
        if (!el) return;
        var text = el.textContent.replace(/^[\u2713\u2717]\s*/, '');
        el.className = passed ? 'text-success' : 'text-danger';
        el.textContent = (passed ? '\u2713 ' : '\u2717 ') + text;
    }

    function validatePassword(val) {
        var ok = true;
        var checks = {
            'req-length': val.length >= 6,
            'req-lower': /[a-z]/.test(val),
            'req-upper': /[A-Z]/.test(val),
            'req-number': /[0-9]/.test(val),
            'req-special': /[^a-zA-Z0-9]/.test(val)
        };
        for (var id in checks) {
            checkReq(id, checks[id]);
            if (!checks[id]) ok = false;
        }
        return ok;
    }

    pwd.addEventListener('input', function() { validatePassword(this.value); });

    form.addEventListener('submit', function(e) {
        if (!validatePassword(pwd.value)) {
            e.preventDefault();
            alert('Mật khẩu chưa đạt yêu cầu. Vui lòng kiểm tra lại.');
        }
    });
})();
</script>

<?= $this->endSection() ?>
