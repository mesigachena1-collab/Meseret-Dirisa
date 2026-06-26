<?php
$author_name = $variables['author_name'] ?? 'Admin';
?>

<div class="container my-5 text-center">

    <h1 class="mb-4">Welcome,
        <?= htmlspecialchars($author_name) ?>!
    </h1>
    <h2 class="mb-5 text-primary">World Culture Show</h2>

    <div class="row g-4 justify-content-center">

        <div class="col-md-3">
            <a href="index.php?controller=post&action=list" class="btn btn-lg btn-primary w-100 py-3">
                Manage Posts
            </a>
        </div>

        <div class="col-md-3">
            <a href="index.php?controller=post&action=listCategories" class="btn btn-lg btn-info w-100 py-3 text-white">
                Manage Categories
            </a>
        </div>

        <div class="col-md-3">
            <a href="index.php?controller=post&action=listAuthors" class="btn btn-lg btn-success w-100 py-3 text-white">
                Manage Authors
            </a>
        </div>

    </div>

    <div class="mt-5">
        <a href="index.php?controller=login&action=logout" class="btn btn-danger">Logout</a>
    </div>

</div>