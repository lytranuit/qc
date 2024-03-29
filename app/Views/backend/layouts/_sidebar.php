<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div><img src="<?= base_url("assets/images/logo.png") ?>" width="150" /></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Tổng quan</li>
                <li>
                    <a href="<?= base_url() ?>/admin/" class="">
                        <i class="metismenu-icon far fa-chart-bar"></i>
                        Tổng quan
                    </a>
                </li>
                <li class="app-sidebar__heading">Lưu mẫu</li>
                <li class="">
                    <a href="<?= base_url() ?>/admin/sample" class="">
                        <i class="metismenu-icon fas fa-file"></i>
                        Mẫu
                    </a>
                </li>
                <li>
                    <a href="<?= base_url() ?>/admin/env" class="">
                        <i class="metismenu-icon fas fa-info-circle"></i>
                        Điều kiện
                    </a>
                </li>
                <li class="mm-active">
                    <a href="<?= base_url() ?>/admin/sample/take" class="">
                        <i class="metismenu-icon fas fa-file-excel"></i>
                        Xuất Excel
                    </a>
                    <ul class="mm-collapse mm-show">
                        <li>
                            <a href="<?= base_url() ?>/admin/export/month" class="">
                                Hàng tháng </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>/admin/export/year" class="">
                                Hàng năm </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>/admin/export/index" class="">
                                Tổng thể </a>
                        </li>
                    </ul>
                </li>
                <?php if (in_groups(array("admin"))) : ?>
                    <li>
                        <a href="<?= base_url() ?>/admin/history" class="">
                            <i class="metismenu-icon fas fa-history"></i>
                            AuditTrail
                        </a>
                    </li>
                <?php endif ?>
                <!-- <li class="">
                    <a href="<?= base_url() ?>/admin/sample/take" class="">
                        <i class="metismenu-icon fas fa-hand-holding"></i>
                        Lấy mẫu bằng QR
                    </a>
                </li> -->
                <!-- <li class="app-sidebar__heading">Auditrail</li>
                <li>
                    <a href="<?= base_url() ?>/admin/history" class="">
                        <i class="metismenu-icon fas fa-history"></i>
                        Auditrail
                    </a>
                </li> -->
                <?php if (in_groups("admin")) : ?>
                    <li class="app-sidebar__heading">Cài đặt</li>
                    <!-- <li>
                        <a href="<?= base_url() ?>/admin/settings" class="">
                            <i class="metismenu-icon fas fa-wrench"></i>
                            Cài đặt chung
                        </a>
                    </li> -->

                    <li>
                        <a href="<?= base_url() ?>/admin/factory" class="">
                            <i class="metismenu-icon fas fa-industry"></i>
                            Nhà máy
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url() ?>/admin/user/">
                            <i class="metismenu-icon fa fa-lock"></i>
                            Tài khoản
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>