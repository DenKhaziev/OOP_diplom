<?php
namespace app\controllers;
//use Aura\SqlQuery\QueryFactory;

use app\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use PDO;
use Tamtamchik\SimpleFlash\Flash;

require '../vendor/autoload.php';



class HomeController
{
    private $templates;
    private $auth;
//    private $db;
    private $qb;
//    private $id;

    public function __construct()
    {
        $this->qb = new QueryBuilder();
        $this->templates = new Engine('../app/views');
        $db = new PDO("mysql:host=localhost;dbname=mysql;charset=utf8", 'root', 'root');
        $this->auth = new Auth($db);
    }

    function createUser() {
        $filename = $_FILES['user_avatar']['name'];
        $filetype = $_FILES['user_avatar']['type'];
        $tmp_name = $_FILES['user_avatar']['tmp_name'];

        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'],  function ($selector, $token)
            {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
//                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
//                echo '  For SMS, consider using a third-party service and a compatible SDK';
//                d($selector, $token);
                $this->auth->confirmEmail($selector, $token);
            });
            echo 'We have signed up a new user with the ID ' . $userId;
            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        $this->qb->update('users', [
            'work' => $_POST['work'],
            'telephone' => $_POST['telephone'],
            'isActive' => $_POST['isActive'],
            'adress' => $_POST['adress'],
            'vk' => $_POST['vk'],
            'telegram' => $_POST['telegram'],
            'instagram' => $_POST['instagram'],
            'avatar' => $filename,
        ], $userId);

        if (!isset($_FILES['user_avatar']) || $_FILES['user_avatar']['error'] !== UPLOAD_ERR_OK) {
            echo 'Upload Error';
            exit;
        }

        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($filetype, $allowed_types)) {
            echo 'Можно загружать файлы только в формате: jpg, png';
            exit;
        }

        $target_dir = '../app/uploads/';
        $target_file = $target_dir . basename($filename);
        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo 'Error to upload a file';
            exit;
        }
        Flash::success('Пользователь успешно добавлен');
        header('Location: /php/Diplom_OOP/users');
    }

    public function users() {
        $isAdmin = in_array('ADMIN', $this->auth->getRoles());
        $users = $this->qb->getAll('users');
        $isAuth = $this->auth->isLoggedIn();
        $id = $this->auth->getUserId();
        echo $this->templates->render('users', ['AllUsers' => $users, 'isAuth' => $isAuth, 'isAdmin' => $isAdmin, 'id' => $id]);
    }

    public function deleteUser($args) {
        $this->qb->delete('users', $args['id']);
        header('Location: /php/Diplom_OOP/users');
        Flash::info('User has been deleted');
    }

    public function registerView() {
        echo $this->templates->render('page_register');
    }

    public function loginView() {
        echo $this->templates->render('page_login');
    }

    public function editUserView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('edit', ['allUsers' => $users]);
    }

    public function editStatusView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('status', ['allUsers' => $users]);
    }
    public function editAvatarView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('media', ['allUsers' => $users]);
    }

    public function createUserView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('create_user', ['allUsers' => $users]);
    }

    public function changePasswordView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('security', ['allUsers' => $users]);
    }

    public function editUser($args) {
        $this->qb->update('users', [
            'username' => $_POST['username'],
            'work' => $_POST['work'],
            'telephone' => $_POST['telephone'],
            'adress' => $_POST['adress'],
        ], $args['id'] );
//        $flash = new Flash();
//        $flash->success('Профиль успешно обновлен!');
        Flash::success('Профиль успешно обновлен!');
        header('Location: /php/Diplom_OOP/users');

    }

    public function editStatus($args) {
        $this->qb->update('users', [
            'isActive' => $_POST['isActive'],
        ], $args['id']);
        Flash::success('Статус пользователя успешно изменен!');
        header('Location: /php/Diplom_OOP/users');
    }

    function imgUpload($args) {
        $filename = $_FILES['user_avatar']['name'];
        $filetype = $_FILES['user_avatar']['type'];
        $tmp_name = $_FILES['user_avatar']['tmp_name'];

        if (!isset($_FILES['user_avatar']) || $_FILES['user_avatar']['error'] !== UPLOAD_ERR_OK) {
            echo 'Upload Error';
            exit;
        }

        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($filetype, $allowed_types)) {
            echo 'Можно загружать файлы только в формате: jpg, png';
            exit;
        }

        $this->qb->update('users', [
            'avatar' => $filename,
        ], $args['id']);

        $target_dir = '../app/uploads/';
        $target_file = $target_dir . basename($filename);
        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo 'Error to upload a file';
            exit;
        }
        header('Location: /php/Diplom_OOP/users');
    }

    public function registration()
    {
            try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], 'user',  function ($selector, $token)
                {
                    echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                    echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                    echo '  For SMS, consider using a third-party service and a compatible SDK';
//                    d($selector, $token);
                    $this->auth->confirmEmail($selector, $token);
                    header('Location: /php/Diplom_OOP/reg');
                    exit;
                });
                echo 'We have signed up a new user with the ID ' . $userId;
                echo 'Email address has been verified';
            } catch (\Delight\Auth\InvalidEmailException $e) {
                die('Invalid email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Invalid password');
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                die('User already exists');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');
            }
        header('Location: /php/Diplom_OOP/users');

    }



    public function login() {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        header('Location: /php/Diplom_OOP/users');
    }

    public function logout() {
        $this->auth->logout();
        echo 'You have been logged out';
        header('Location: /php/Diplom_OOP/login');

    }
    public function verify() {
        try {
            $this->auth->confirmEmail('pS_MlSjM9SpE6hUS', 'pXij3_rZD2Oa7m8g');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    function changePassword() {
        try {
            $this->auth->admin()->changePasswordForUserById($_POST['id'], $_POST['newPassword']);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown ID');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        Flash::success('Your password has been changed');
        header('Location: /php/Diplom_OOP/users');
    }

    public function getRoles() {
        d($this->auth->getRoles());
        d($this->auth->admin()->doesUserHaveRole(5, \Delight\Auth\Role::ADMIN)); // boolean
    }

    public function assignRole() {
        $this->auth->admin()->addRoleForUserById(4, \Delight\Auth\Role::ADMIN);
        echo 'Role are update to ADMIN';
    }
}