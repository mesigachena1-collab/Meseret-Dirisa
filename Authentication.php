<?php
class Authentication
{
    public function __construct(
        private DatabaseTable $users,
        private string $usernameColumn,
        private string $passwordColumn
    ) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    //To log in with email and password
    public function login(string $email, string $password): bool
    {
        $user = $this->users->find($this->usernameColumn, strtolower($email));

        if (!empty($user) && password_verify($password, $user[0][$this->passwordColumn])) {
            session_regenerate_id(true);

            // Store user info in session
            $_SESSION['author_id'] = $user[0]['id'];
            $_SESSION['author_name'] = $user[0]['name'];
            $_SESSION['loggedin'] = true;

            return true;
        }

        return false;
    }

    // Check if the user is logged in
    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    // Get the currently logged-in user
    public function getUser(): ?array
    {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['author_id'],
                'name' => $_SESSION['author_name']
            ];
        }
        return null;
    }
    public function getAuthorByEmail($email)
    {
        $authors = $this->users->find($this->usernameColumn, strtolower($email));

        if (!empty($authors)) {
            return $authors[0];
        }

        return false;
    }
    public function saveResetToken($email, $token)
    {
        $author = $this->users->find($this->usernameColumn, strtolower($email));

        if (!empty($author)) {

            $data = [
                'id' => $author[0]['id'],
                'reset_token' => $token
            ];

            $this->users->save($data);
        }
    }
    public function updatePasswordByToken($token, $password)
    {
        $authors = $this->users->find('reset_token', $token);

        if (!empty($authors)) {

            $data = [
                'id' => $authors[0]['id'],
                'password' => $password,
                'reset_token' => null
            ];

            $this->users->save($data);
        }
    }

    // Log out the user 
    public function logout(): void
    {
        unset($_SESSION['author_id'], $_SESSION['author_name'], $_SESSION['loggedin']);
        session_regenerate_id(true);
    }
}
?>