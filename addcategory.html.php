<?php
$category = $category ?? [];
$errors = $errors ?? [];
$title = !empty($category['id']) ? 'Edit Category' : 'Add New Category';
?>

<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= htmlspecialchars($error) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="index.php?controller=post&action=saveCategory">
    <input type="hidden" name="category[id]" value="<?= htmlspecialchars($category['id'] ?? '') ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="category[name]" id="name" class="form-control"
            value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description (optional)</label>
        <textarea name="category[description]" id="description" class="form-control"
            rows="4"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">
        <?= !empty($category['id']) ? 'Update Category' : 'Add Category' ?>
    </button>
</form>