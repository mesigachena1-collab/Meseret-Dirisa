<?php

class AuthorController
{
    public function __construct(private DatabaseTable $authorsTable)
    {
    }

    // Show registration form
    public function register(): array
    {
        return $this->registrationForm();
    }

    public function registrationForm(): array
    {
        return [
            'template' => 'register.html.php',
            'title' => 'Register an Author',
            'variables' => [
                'author' => [
                    'id' => '',
                    'name' => '',
                    'email' => '',
                    'bio' => '',
                    'password' => ''
                ],
                'errors' => []
            ]
        ];
    }

    // Handle registration submit
    public function registerSubmit(): array
    {
        $author = $_POST['author'] ?? [];
        $errors = [];

        // Validation
        if (empty($author['name'])) {
            $errors[] = 'Name cannot be blank';
        }

        if (empty($author['email'])) {
            $errors[] = 'Email cannot be blank';
        } elseif (!filter_var($author['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        } else {
            $author['email'] = strtolower($author['email']);
            $existing = $this->authorsTable->find('email', $author['email']);
            if (!empty($existing)) {
                $errors[] = 'Email already registered';
            }
        }

        if (empty($author['password'])) {
            $errors[] = 'Password cannot be blank';
        }

        if (empty($errors)) {
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
            $this->authorsTable->save($author);

            header('Location: index.php?controller=author&action=success');
            exit;
        }

        return [
            'template' => 'register.html.php',
            'title' => 'Register an Author',
            'variables' => [
                'author' => $author,
                'errors' => $errors
            ]
        ];
    }

    // Registration success page
    public function success(): array
    {
        return [
            'template' => 'registersuccess.html.php',
            'title' => 'Registration Successful'
        ];
    }
}