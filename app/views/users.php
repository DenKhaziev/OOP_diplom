<?php if( !session_id() ) {
    session_start();
}
use function Tamtamchik\SimpleFlash\flash;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->layout('layout'); ?>
</head>

    <body class="mod-bg-1 mod-nav-link">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/php/Diplom_OOP/users">Главная <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if(!$isAuth):?>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/Diplom_OOP/login">Войти</a>
                    </li>
                    <?php endif;?>
                    <?php if($isAuth):?>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/Diplom_OOP/logout">Выйти</a>
                    </li>
                    <?php endif;?>

                </ul>
            </div>
        </nav>

        <main id="js-page-content" role="main" class="page-content mt-3">
                <?php echo flash()->display();?>
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>
                <?php if($isAdmin):?>
                    <h2>Authorized user is ADMIN</h2>
                <?php endif;?>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <?php if($isAdmin):?>
                        <a class="btn btn-success" href="/php/Diplom_OOP/create_user">Добавить</a>
                    <?php endif;?>

                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="js-contacts">
                <?php foreach($AllUsers as $user):?>
                <?php if($id == $user['id']):?>
                <div class="col-xl-4 p-3 bg-info bg-opacity-10 border border-info border-start-0 rounded-end">
                <?php endif;?>
                <?php if($id != $user['id']):?>
                <div class="col-xl-4">
                <?php endif;?>

                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?php echo $user['username']?>">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                                <?php if($user['isActive'] == 'Онлайн') :?>
                                    <span class="status status-success mr-3">
                                <?php endif;?>
                                <?php if($user['isActive'] == 'Отошел') :?>
                                    <span class="status status-warning mr-3">
                                <?php endif;?>
                                <?php if($user['isActive'] == 'Не беспокоить') :?>
                                    <span class="status status-danger mr-3">
                                <?php endif;?>
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('app/uploads/<?php echo $user['avatar']?>'); background-size: cover;"></span>
                                </span>
                                <div class="info-card-text flex-1">
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        <?php echo $user['username']?>
                                        <?php if($isAdmin || ($id == $user['id'])):?>
                                            <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                            <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                        <?php endif;?>

                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/php/Diplom_OOP/edit<?php echo $user['id']?>">
                                            <i class="fa fa-edit"></i>
                                            Редактировать</a>
                                        <a class="dropdown-item" href="/php/Diplom_OOP/security<?php echo $user['id']?>">
                                            <i class="fa fa-lock"></i>
                                            Безопасность</a>
                                        <a class="dropdown-item" href="/php/Diplom_OOP/status<?php echo $user['id']?>">
                                            <i class="fa fa-sun"></i>
                                            Установить статус</a>
                                        <a class="dropdown-item" href="/php/Diplom_OOP/media<?php echo $user['id']?>">
                                            <i class="fa fa-camera"></i>
                                            Загрузить аватар
                                        </a>
                                        <a href="/php/Diplom_OOP/delete/<?php echo $user['id']?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                    </div>
                                    <span class="text-truncate text-truncate-xl"><?php echo $user['work']?></span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i><?php echo $user['telephone']?></a>
                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i><?php echo $user['email']?>></a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i><?php echo $user['adress']?></address>
                                <div class="d-flex flex-row">
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver kopyov">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-b.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Oliver Kopyov-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">IT Director, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 317-456-2564</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> oliver.kopyov@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 15 Charist St, Detroit, MI, 48212, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_2" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="alita gray">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-warning mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-c.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Alita Gray-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Project Manager, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_2 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-461-1347</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> Alita@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 134 Hamtrammac, Detroit, MI, 48314, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_3" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="dr john cook">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-danger mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-e.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Dr. John Cook PhD-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Human Resources, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_3 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-1347</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> john.cook@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 55 Smyth Rd, Detroit, MI, 48341, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_4" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="jim ketty">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-k.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Jim Ketty-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Staff Orgnizer, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_4 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-3314</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> jim.ketty@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 134 Tasy Rd, Detroit, MI, 48212, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_5" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="aaron tellus">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-g.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Dr. John Oliver-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Oncologist, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_5 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-8134</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> john.oliver@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 134 Gallery St, Detroit, MI, 46214, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_6" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="sarah mcbrook">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-h.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Sarah McBrook-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Xray Division, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_6 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-7613</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> sarah.mcbrook@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 13 Jamie Rd, Detroit, MI, 48313, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_7" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="jimmy fellan">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-i.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Jimmy Fellan-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Accounting, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_7 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-4314</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> jimmy.fallan@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 55 Smyth Rd, Detroit, MI, 48341, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-xl-4">-->
<!--                    <div id="c_8" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="arica grace">-->
<!--                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">-->
<!--                            <div class="d-flex flex-row align-items-center">-->
<!--                                <span class="status status-success mr-3">-->
<!--                                    <span class="rounded-circle profile-image d-block " style="background-image:url('img/demo/avatars/avatar-j.png'); background-size: cover;"></span>-->
<!--                                </span>-->
<!--                                <div class="info-card-text flex-1">-->
<!--                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">-->
<!--                                        Arica Grace-->
<!--                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>-->
<!--                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>-->
<!--                                    </a>-->
<!--                                    <div class="dropdown-menu">-->
<!--                                        <a class="dropdown-item" href="edit.html">-->
<!--                                            <i class="fa fa-edit"></i>-->
<!--                                        Редактировать</a>-->
<!--                                        <a class="dropdown-item" href="security.html">-->
<!--                                            <i class="fa fa-lock"></i>-->
<!--                                        Безопасность</a>-->
<!--                                        <a class="dropdown-item" href="status.html">-->
<!--                                            <i class="fa fa-sun"></i>-->
<!--                                        Установить статус</a>-->
<!--                                        <a class="dropdown-item" href="media.html">-->
<!--                                            <i class="fa fa-camera"></i>-->
<!--                                            Загрузить аватар-->
<!--                                        </a>-->
<!--                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">-->
<!--                                            <i class="fa fa-window-close"></i>-->
<!--                                            Удалить-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                    <span class="text-truncate text-truncate-xl">Accounting, Gotbootstrap Inc.</span>-->
<!--                                </div>-->
<!--                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_8 > .card-body + .card-body" aria-expanded="false">-->
<!--                                    <span class="collapsed-hidden">+</span>-->
<!--                                    <span class="collapsed-reveal">-</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body p-0 collapse show">-->
<!--                            <div class="p-3">-->
<!--                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> +1 313-779-3347</a>-->
<!--                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">-->
<!--                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> arica.grace@smartadminwebapp.com</a>-->
<!--                                <address class="fs-sm fw-400 mt-4 text-muted">-->
<!--                                    <i class="fas fa-map-pin mr-2"></i> 798 Smyth Rd, Detroit, MI, 48341, USA</address>-->
<!--                                <div class="d-flex flex-row">-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">-->
<!--                                        <i class="fab fa-vk"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">-->
<!--                                        <i class="fab fa-telegram"></i>-->
<!--                                    </a>-->
<!--                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">-->
<!--                                        <i class="fab fa-instagram"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2020 © Учебный проект</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="intel_introduction.html" class="text-secondary fw-700">Home</a></li>
                    <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>
        
    </body>
    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>
        <?php $this->layout('layout'); ?>
    </script>
</html>