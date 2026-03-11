<?php
$categories = $categories ?? [];
$is_logged_in = $is_logged_in ?? false;
?>

<h1>Categories</h1>

<?php if ($is_logged_in): ?>
    <div class="mb-3 text-end">
        <a href="index.php?controller=post&action=addCategory" class="btn btn-success">Add New Category</a>
    </div>
<?php endif; ?>

<?php if (!empty($categories)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <?php if ($is_logged_in): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($category['name']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($category['description'] ?? '') ?>
                    </td>
                    <?php if ($is_logged_in): ?>
                        <td>
                            <a href="index.php?controller=post&action=addCategory&id=<?= $category['id'] ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form method="post" action="index.php?controller=post&action=deleteCategory"
                                style="display:inline-block;"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="alert alert-info">No categories found.</p>
<?php endif; ?>