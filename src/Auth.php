<?php

namespace App;

use App\Repository\UsersRepository;

class Auth
{
    public function login(array $data): bool
    {
        $email = htmlspecialchars($data['email']);
        $requestPass = htmlspecialchars($data['password']);

        $usersRepository = new UsersRepository();
        $userPass = $usersRepository->getUserPass($email);

        if ($userPass && password_verify($requestPass, $userPass)) {
            return $_SESSION['isUserVerifyed'] = true;
        } else {
            $_SESSION['isUserVerifyed'] = false;
            $_SESSION['login_email'] = $email;
            $_SESSION['error_message'] = 'Неверная комбинация логина и пароля.';
        }

        return false;
    }

    public function logout()
    {
        session_unset();
        $_SESSION['isUserVerifyed'] = false;
    }
}
