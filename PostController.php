<?php

class PostController
{
    public function __construct(
        private DatabaseTable $postsTable,
        private DatabaseTable $authorsTable,
        private DatabaseTable $categoriesTable,
        private Authentication $authentication,
        private DatabaseTable $commentsTable,
        private DatabaseTable $contactTable
    ) {
    }

    // -------------------------------
    // Home page / list all posts
    // -------------------------------
    public function home(): array
    {
        $search = $_GET['search'] ?? null;
        $posts = $this->postsTable->findAll();

        foreach ($posts as &$post) {
            $authorData = $this->authorsTable->find('id', $post['author_id']);
            $author = !empty($authorData) ? $authorData[0] : ['name' => 'Unknown'];
            $post['author_name'] = $author['name'];

            $categoryData = $this->categoriesTable->find('id', $post['category_id']);
            $category = !empty($categoryData) ? $categoryData[0] : ['name' => 'General'];
            $post['category_name'] = $category['name'] ?? 'General';

            $post['title'] = $post['title'] ?? 'Untitled';
            $post['body'] = $post['body'] ?? '';
            $post['category_id'] = $post['category_id'] ?? null;
            $post['author_id'] = $post['author_id'] ?? 0;
        }

        if ($search) {
            $search = strtolower(trim($search));
            $posts = array_filter(
                $posts,
                fn($p) => str_contains(strtolower($p['title'] ?? ''), $search) ||
                str_contains(strtolower($p['body'] ?? ''), $search)
            );
        }

        return [
            'template' => 'posts.html.php',
            'title' => 'All Posts',
            'variables' => [
                'posts' => $posts,
                'search' => $search,
                'is_logged_in' => $this->authentication->isLoggedIn(),
                'current_author_id' => $this->authentication->isLoggedIn() ? $this->authentication->getUser()['id'] : 0
            ]
        ];
    }

    // -------------------------------
    // View a single post
    // -------------------------------
    public function view(): array
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            throw new Exception("Post ID not provided.");
        }

        $post = $this->postsTable->findById($id) ?? [];

        // Ensure author info
        $post['author_id'] = (int) ($post['author_id'] ?? 0);
        $author = $this->authorsTable->findById($post['author_id']);
        $post['author_name'] = $author['name'] ?? 'Unknown';

        // Category info
        $post['category_id'] = $post['category_id'] ?? null;
        $category = $post['category_id'] ? $this->categoriesTable->findById($post['category_id']) : null;
        $post['category_name'] = $category['name'] ?? 'Culture';

        $post['title'] = $post['title'] ?? 'Untitled';
        $post['body'] = $post['body'] ?? '';
        $post['id'] = $post['id'] ?? 0;

        // Get comments for this post
        $postComments = $this->commentsTable->find('post_id', $id);

        // Ensure all author_ids are integers for comparison
        foreach ($postComments as &$c) {
            $c['author_id'] = (int) ($c['author_id'] ?? 0);
        }

        // Current logged-in user ID
        $currentAuthorId = $this->authentication->isLoggedIn() ? (int) $this->authentication->getUser()['id'] : 0;

        return [
            'template' => 'viewpost.html.php',
            'title' => $post['title'],
            'variables' => [
                'posts' => [$post],
                'comments' => [$id => $postComments],
                'is_logged_in' => $this->authentication->isLoggedIn(),
                'current_author_id' => $currentAuthorId
            ]
        ];
    }
    // -------------------------------
    // Show add/edit post form
    // -------------------------------
    public function edit(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            return [
                'template' => 'error.html.php',
                'title' => 'You must be logged in to add or edit a post'
            ];
        }

        $user = $this->authentication->getUser();
        $id = $_GET['id'] ?? null;
        $post = $id ? $this->postsTable->findById($id) ?? [] : [];

        if ($id && ($post['author_id'] ?? 0) != $user['id']) {
            return [
                'template' => 'error.html.php',
                'title' => 'You are not authorised to edit this post'
            ];
        }

        // Safe defaults for form fields
        $post['title'] = $post['title'] ?? '';
        $post['body'] = $post['body'] ?? '';
        $post['category_id'] = $post['category_id'] ?? null;
        $post['image'] = $post['image'] ?? '';

        return [
            'template' => 'editpost.html.php',
            'title' => $id ? 'Edit Post' : 'Add Post',
            'variables' => [
                'post' => $post,
                'categories' => $this->categoriesTable->allCategories()
            ]
        ];
    }

    // -------------------------------
    // Handle add/edit post submit
    // -------------------------------
    public function editSubmit(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();
        $post = $_POST['post'] ?? [];
        $id = $post['id'] ?? null;

        if (empty($post['title']) || empty($post['body'])) {
            header('Location: index.php?controller=post&action=edit' . ($id ? "&id=$id" : ''));
            exit;
        }

        // If editing, check ownership
        if ($id) {
            $existingPost = $this->postsTable->findById($id) ?? [];
            if (($existingPost['author_id'] ?? 0) != $user['id']) {
                header('Location: index.php?controller=post&action=home');
                exit;
            }
        }

        $post['author_id'] = $user['id'];

        // Set post_date for new post
        if (empty($post['id'])) {
            $post['post_date'] = date('Y-m-d');
        }

        // Handle multiple file uploads
        if (!empty($_FILES['image']['name'][0])) {
            $upload = include __DIR__ . '/../includes/uploadFile.php';
            $uploadedFiles = $upload($_FILES['image']); // Returns comma-separated file names

            if ($uploadedFiles) {
                $post['image'] = !empty($post['image']) ? $post['image'] . ',' . $uploadedFiles : $uploadedFiles;

                // Store alt text for uploaded files if provided
                $altTexts = $_POST['alt_text'] ?? [];
                $post['alt_text'] = !empty($altTexts) ? implode(',', $altTexts) : '';
            }
        }

        $this->postsTable->save($post);

        header('Location: index.php?controller=post&action=home');
        exit;
    }

    // -------------------------------
    // Delete a post
    // -------------------------------
    public function delete(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();
        $id = $_POST['id'] ?? null;
        if ($id) {
            $post = $this->postsTable->findById($id) ?? [];
            if (($post['author_id'] ?? 0) == $user['id']) {
                $this->postsTable->delete('id', $id);
            }
        }

        header('Location: index.php?controller=post&action=home');
        exit;
    }
    // add comment section 
    public function addComment(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            throw new Exception("You must be logged in to comment.");
        }

        $postId = $_POST['post_id'] ?? null;
        $body = $_POST['body'] ?? '';
        $user = $this->authentication->getUser();

        if (!$postId || !$body) {
            throw new Exception("Post ID and comment body are required.");
        }

        $this->commentsTable->save([
            'post_id' => $postId,
            'author_id' => $user['id'],
            'author_name' => $user['name'],
            'body' => $body,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $_GET['id'] = $postId;
        return $this->view();
    }
    // edit comment section 
    public function editComment(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();
        $id = $_POST['id'] ?? null;
        $body = trim($_POST['body'] ?? '');

        if (!$id || !$body) {
            header('Location: index.php?controller=post&action=home');
            exit;
        }

        $comment = $this->commentsTable->findById($id);

        // Only comment author can edit
        if ($comment && $comment['author_id'] == $user['id']) {

            $this->commentsTable->save([
                'id' => $id,
                'body' => $body
            ]);
        }

        header('Location: index.php?controller=post&action=view&id=' . $comment['post_id']);
        exit;
    }

    public function deleteComment(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();
        $id = $_POST['id'] ?? null;
        $comment = $this->commentsTable->findById($id) ?? [];

        if (($comment['author_id'] ?? 0) === $user['id']) {
            $this->commentsTable->delete('id', $id);
        }

        header('Location: index.php?controller=post&action=view&id=' . ($comment['post_id'] ?? 0));
        exit;
    }
    // -------------------------------
// AUTHOR MANAGEMENT
// -------------------------------

    // List all authors
    public function authors(): array
    {
        return [
            'template' => 'authors.html.php',
            'title' => 'Authors',
            'variables' => [
                'authors' => $this->authorsTable->findAll(),
                'is_logged_in' => $this->authentication->isLoggedIn()
            ]
        ];
    }

    // Show add/edit author form
    public function addAuthor(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            return ['template' => 'error.html.php', 'title' => 'Login required'];
        }

        $id = $_GET['id'] ?? null;
        $author = $id ? $this->authorsTable->findById($id) ?? [] : [];

        return [
            'template' => 'addauthor.html.php',
            'title' => $id ? 'Edit Author' : 'Add Author',
            'variables' => ['author' => $author]
        ];
    }

    // Handle add/edit author submit
    public function saveAuthor(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $author = $_POST['author'] ?? [];
        if (empty($author['name']) || empty($author['email'])) {
            header('Location: index.php?controller=post&action=addAuthor' . (!empty($author['id']) ? "&id={$author['id']}" : ''));
            exit;
        }

        $this->authorsTable->save($author);
        header('Location: index.php?controller=post&action=authors');
        exit;
    }

    // Delete author
    public function deleteAuthor(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if ($id)
            $this->authorsTable->delete('id', $id);

        header('Location: index.php?controller=post&action=authors');
        exit;
    }

    // -------------------------------
// CATEGORY MANAGEMENT
// -------------------------------

    // List all categories
    public function categories(): array
    {
        return [
            'template' => 'categories.html.php',
            'title' => 'Categories',
            'variables' => [
                'categories' => $this->categoriesTable->findAll(),
                'is_logged_in' => $this->authentication->isLoggedIn()
            ]
        ];
    }

    // Show add/edit category form
    public function addCategory(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            return ['template' => 'error.html.php', 'title' => 'Login required'];
        }

        $id = $_GET['id'] ?? null;
        $category = $id ? $this->categoriesTable->findById($id) ?? [] : [];

        return [
            'template' => 'addcategory.html.php',
            'title' => $id ? 'Edit Category' : 'Add Category',
            'variables' => ['category' => $category]
        ];
    }

    // Handle add/edit category submit
    public function saveCategory(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $category = $_POST['category'] ?? [];
        if (empty($category['name'])) {
            header('Location: index.php?controller=post&action=addCategory' . (!empty($category['id']) ? "&id={$category['id']}" : ''));
            exit;
        }

        $this->categoriesTable->save($category);
        header('Location: index.php?controller=post&action=categories');
        exit;
    }

    // Delete category
    public function deleteCategory(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if ($id)
            $this->categoriesTable->delete('id', $id);

        header('Location: index.php?controller=post&action=categories');
        exit;
    }

    // ADD POST ----------------
    public function add(): array
    {
        // Check if user is logged in via Authentication or return error message 
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        //  Prepare empty post data
        $post = [
            'title' => '',
            'body' => '',
            'category_id' => null,
            'image' => ''
        ];

        //  Return template with categories and authors
        return [
            'template' => 'addpost.html.php',
            'title' => 'Add New Post',
            'variables' => [
                'post' => $post,
                'categories' => $this->categoriesTable->allCategories(),
                'authors' => $this->authorsTable->allAuthors(),
                'is_logged_in' => $this->authentication->isLoggedIn(),
                'current_author' => $this->authentication->getUser()
            ]
        ];
    }
    public function addSubmit(): void
    {
        // Make sure user is logged in
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();

        // Build post data
        $post = [
            'title' => $_POST['title'] ?? '',
            'body' => $_POST['body'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'author_id' => $user['id'], // use logged-in user ID
            'post_date' => date('Y-m-d'),
        ];

        // Handle file uploads
        if (!empty($_FILES['media']['name'][0])) {
            $upload = include __DIR__ . '/../includes/uploadFile.php';
            $uploadedFiles = $upload($_FILES['media']); // returns comma-separated filenames

            if ($uploadedFiles) {
                $post['image'] = $uploadedFiles;
            }
        }

        // Save post to DB
        $this->postsTable->save($post);

        // Redirect to homepage
        header('Location: index.php?controller=post&action=home');
        exit;
    }
    // -------------------------------
// Manage posts (Dashboard)
// -------------------------------
    public function manage(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            return [
                'template' => 'error.html.php',
                'title' => 'Login required',
            ];
        }

        $posts = $this->postsTable->findAll();
        $managedPosts = [];

        foreach ($posts as $post) {
            $authorData = $this->authorsTable->find('id', $post['author_id']);
            $author = !empty($authorData) ? $authorData[0] : ['name' => 'Unknown'];

            $categoryData = $this->categoriesTable->find('id', $post['category_id']);
            $category = !empty($categoryData) ? $categoryData[0] : ['name' => 'General'];

            $managedPosts[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'body' => $post['body'],
                'post_date' => $post['post_date'],
                'author_id' => $post['author_id'],
                'author_name' => $author['name'],
                'category_id' => $post['category_id'],
                'category_name' => $category['name'] ?? 'General',
                'image' => $post['image'] ?? ''
            ];
        }

        $currentUserId = $this->authentication->getUser()['id'] ?? 0;

        return [
            'template' => 'manageposts.html.php',
            'title' => 'Manage Posts',
            'variables' => [
                'posts' => $managedPosts,
                'current_user_id' => $currentUserId
            ]
        ];
    }

    // -------------------------------
// Edit / Add Post (Dashboard or regular)
// -------------------------------
    public function editPost(): array
    {
        if (!$this->authentication->isLoggedIn()) {
            return [
                'template' => 'error.html.php',
                'title' => 'Login required',
            ];
        }

        $user = $this->authentication->getUser();
        $id = $_GET['id'] ?? null;
        $post = $id ? $this->postsTable->findById($id) ?? [] : [];

        // Only allow author to edit their own post
        if ($id && ($post['author_id'] ?? 0) != $user['id']) {
            return [
                'template' => 'error.html.php',
                'title' => 'You are not authorized to edit this post',
            ];
        }

        // Set safe defaults for form
        $post['title'] = $post['title'] ?? '';
        $post['body'] = $post['body'] ?? '';
        $post['category_id'] = $post['category_id'] ?? null;
        $post['image'] = $post['image'] ?? '';

        return [
            'template' => 'editpost.html.php',
            'title' => $id ? 'Edit Post' : 'Add Post',
            'variables' => [
                'post' => $post,
                'categories' => $this->categoriesTable->findAll(),
                'is_logged_in' => true,
                'current_author' => $user
            ]
        ];
    }

    // -------------------------------
// Save edited / new post
// -------------------------------
    public function savePost(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $user = $this->authentication->getUser();
        $post = $_POST['post'] ?? [];
        $id = $post['id'] ?? null;

        // Only allow author to edit their own post
        if ($id) {
            $existingPost = $this->postsTable->findById($id) ?? [];
            if (($existingPost['author_id'] ?? 0) != $user['id']) {
                header('Location: index.php?controller=post&action=manage');
                exit;
            }
        } else {
            // Set new post defaults
            $post['author_id'] = $user['id'];
            $post['post_date'] = date('Y-m-d');
        }

        // Handle uploaded images
        if (!empty($_FILES['image']['name'][0])) {
            $upload = include __DIR__ . '/../includes/uploadFile.php';
            $uploadedFiles = $upload($_FILES['image']); // comma-separated filenames
            if ($uploadedFiles) {
                $post['image'] = !empty($post['image']) ? $post['image'] . ',' . $uploadedFiles : $uploadedFiles;
            }
        }

        $this->postsTable->save($post);

        header('Location: index.php?controller=post&action=manage');
        exit;
    }

    // -------------------------------
// Delete post (Dashboard)
// -------------------------------
    public function deletePost(): void
    {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: index.php?controller=login&action=login');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $user = $this->authentication->getUser();

        if ($id) {
            $post = $this->postsTable->findById($id) ?? [];
            if (($post['author_id'] ?? 0) == $user['id']) {
                $this->postsTable->delete('id', $id);
            }
        }

        header('Location: index.php?controller=post&action=manage');
        exit;
    }


}
?>