<?php
// Ensure variables exist
$authors = $authors ?? [];
$is_logged_in = $is_logged_in ?? false;
?>

<h1>Authors</h1>

<?php if ($is_logged_in): ?>
    <div class="mb-3 text-end">
        <a href="index.php?controller=post&action=addAuthor" class="btn btn-success">Add New Author</a>
    </div>
<?php endif; ?>

<?php if (!empty($authors)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Bio</th>
                <?php if ($is_logged_in): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= htmlspecialchars($author['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($author['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($author['bio'] ?? '') ?></td>
                    <?php if ($is_logged_in): ?>
                        <td>
                            <a href="index.php?controller=post&action=addAuthor&id=<?= $author['id'] ?>"
                                class="btn btn-warning btn-sm">Edit</a>

                            <form method="post" action="index.php?controller=post&action=deleteAuthor" style="display:inline-block;"
                                onsubmit="return confirm('Are you sure you want to delete this author?');">
                                <input type="hidden" name="id" value="<?= $author['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="alert alert-info">No authors found.</p>
<?php endif; ?>