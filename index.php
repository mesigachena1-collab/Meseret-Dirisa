<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function loadTemplate(string $templateFileName, array $variables = []): string
{
    extract($variables);
    ob_start();
    include 'templates/' . $templateFileName;
    return ob_get_clean();
}

try {
    include 'includes/DatabaseConnection.php';
    include 'classes/DatabaseTable.php';
    include 'classes/Authentication.php';
    include 'controllers/PostController.php';
    include 'controllers/AuthorController.php';
    include 'controllers/Login.php';
    include 'controllers/ContactController.php';

   
    $postsTable = new DatabaseTable($pdo, 'posts', 'id');
    $authorsTable = new DatabaseTable($pdo, 'authors', 'id');
    $categoriesTable = new DatabaseTable($pdo, 'categories', 'id');
    $commentsTable = new DatabaseTable($pdo, 'comments', 'id');
    $contactTable = new DatabaseTable($pdo, 'contact', 'id');


 
    $authentication = new Authentication($authorsTable, 'email', 'password');


    $postController = new PostController(
        postsTable: $postsTable,
        authorsTable: $authorsTable,
        categoriesTable: $categoriesTable,
        authentication: $authentication,
        commentsTable: $commentsTable,
        contactTable: $contactTable
    );
    $authorController = new AuthorController($authorsTable);
    $loginController = new Login($authentication);
    $contactController = new ContactController($contactTable, $authentication);

   
    $controllerName = $_GET['controller'] ?? 'post';
    $action = $_GET['action'] ?? 'home';

    $controllers = [
        'post' => $postController,
        'author' => $authorController,
        'login' => $loginController,
        'contact' => $contactController
    ];

    if (!isset($controllers[$controllerName])) {
        throw new Exception("Controller '$controllerName' not found.");
    }

    $controller = $controllers[$controllerName];

    if (!method_exists($controller, $action)) {
        throw new Exception("Action '$action' not found in controller '$controllerName'.");
    }
    $page = $controller->$action();

    $title = $page['title'] ?? '';
    $variables = $page['variables'] ?? [];
    $output = loadTemplate($page['template'], $variables);

} catch (PDOException $e) {
    $title = 'Database Error';
    $output = 'A database error occurred: ' . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    $title = 'Application Error';
    $output = 'An error occurred: ' . htmlspecialchars($e->getMessage());
}


include 'templates/layout.html.php';