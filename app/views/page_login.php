<?php if( !session_id() ) {
    session_start();
}
use function Tamtamchik\SimpleFlash\flash;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->layout('layout_login_register'); ?>
</head>
<body>
    <div class="blankpage-form-field">
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                <span class="page-logo-text mr-1">Учебный проект</span>
                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
<!--            <div class="alert alert-success">-->
                <?php echo flash()->display('Success');?>
<!--            </div>-->
            <form action="/php/Diplom_OOP/login/done" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input name="email" type="email" id="username" class="form-control" placeholder="Эл. адрес" value="">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Пароль</label>
                    <input name="password" type="password" id="password" class="form-control" placeholder="" >
                </div>
                <button type="submit" class="btn btn-default float-right">Войти</button>
            </form>
        </div>
        <div class="blankpage-footer text-center">
            Нет аккаунта? <a href="/php/Diplom_OOP/reg"><strong>Зарегистрироваться</strong>
        </div>
    </div>
    <video poster="img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
        <source src="media/video/cc.webm" type="video/webm">
        <source src="media/video/cc.mp4" type="video/mp4">
    </video>
    <script src="js/vendors.bundle.js"></script>
</body>
</html>
