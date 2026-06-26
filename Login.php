<?php

class Login
{
    public function __construct(private Authentication $authentication)
    {
    }

    public function login(): array
    {
        return [
            'template' => 'login.html.php',
            'title' => 'Login'
        ];
    }

    public function loginSubmit(): array
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $success = $this->authentication->login($email, $password);

        if ($success) {
            header('Location: index.php?controller=post&action=home');
            exit;
        }

        return [
            'template' => 'login.html.php',
            'title' => 'Login',
            'variables' => [
                'errorMessage' => 'Invalid email or password'
            ]
        ];
    }
    public function forgotPassword(): array
    {
        return [
            'template' => 'forgotpassword.html.php',
            'title' => 'Forgot Password'
        ];
    }
    public function forgotPasswordSubmit(): array
    {
        $email = $_POST['email'] ?? '';

        $author = $this->authentication->getAuthorByEmail($email);

        if ($author) {

            $token = bin2hex(random_bytes(32));

            $this->authentication->saveResetToken($email, $token);
            // reset link sent to localhost 
            $link = "http://localhost/WorldCultureShow2/index.php?controller=login&action=resetPassword&token=$token";

            return [
                'template' => 'forgotpassword.html.php',
                'title' => 'Forgot Password',
                'variables' => [
                    'message' => "Reset link: <a href='$link'>Click here</a>"
                ]
            ];
        }

        return [
            'template' => 'forgotpassword.html.php',
            'title' => 'Forgot Password',
            'variables' => [
                'errorMessage' => 'Email not found'
            ]
        ];
    }
    public function resetPassword(): array
    {
        $token = $_GET['token'] ?? '';

        return [
            'template' => 'resetpassword.html.php',
            'title' => 'Reset Password',
            'variables' => [
                'token' => $token
            ]
        ];
    }
    public function resetPasswordSubmit(): void
    {
        $token = $_POST['token'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $this->authentication->updatePasswordByToken($token, $password);

        header('Location: index.php?controller=login&action=login');
    }

    public function logout(): void
    {
        $this->authentication->logout();
        header('Location: index.php');
        exit;
    }
}