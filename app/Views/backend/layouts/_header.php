<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src text-center"><img src="<?= base_url("assets/images/logo.png") ?>" width="80%" /></div>
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
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="mb-2 mr-2 btn-group b-dropdown dropdown" id="__BVID__8137">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= session()->factory_name ?>
                </button>
                <div role="menu" tabindex="-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php foreach ($list_factories as $factory) : ?>
                        <?php if ($factory->factory_id != session()->factory_id) : ?>
                            <a type="button" tabindex="0" class="dropdown-item select_factory" href="<?= base_url("admin/factory/change/$factory->factory_id") ?>"><?= $factory->name ?></a>
                        <?php else : ?>
                            <h6 tabindex="-1" class="dropdown-header"><?= $factory->name ?></h6>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="app-header-right">
            <div class="header-dots">
            </div>
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">

                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <?= user()->name ?>
                            </div>
                            <div class="widget-subheading">

                            </div>
                        </div>
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a type="button" tabindex="0" class="dropdown-item" href="<?= base_url("admin/account") ?>"><?= lang("Custom.info") ?></a>
                                    <a type="button" tabindex="0" class="dropdown-item" href="<?= route_to("logout") ?>"><?= lang("Custom.logout") ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>