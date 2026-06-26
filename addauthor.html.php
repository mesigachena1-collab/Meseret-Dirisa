<?php
// Ensure variables exist
$author = $author ?? [];
$author_id = $author['id'] ?? '';
$author_name = $author['name'] ?? '';
$author_email = $author['email'] ?? '';
$author_bio = $author['bio'] ?? '';
?>

<h1><?= $author_id ? 'Edit Author' : 'Add New Author' ?></h1>

<form method="post" action="index.php?controller=post&action=saveAuthor">
    <input type="hidden" name="author[id]" value="<?= htmlspecialchars($author_id) ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="author[name]" class="form-control"
            value="<?= htmlspecialchars($author_name) ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="author[email]" class="form-control"
            value="<?= htmlspecialchars($author_email) ?>" required>
    </div>

    <div class="mb-3">
        <label for="bio" class="form-label">Bio</label>
        <textarea id="bio" name="author[bio]" class="form-control"
            rows="4"><?= htmlspecialchars($author_bio) ?></textarea>
    </div>

    <button type="submit" class="btn btn-success"><?= $author_id ? 'Update Author' : 'Add Author' ?></button>
    <a href="index.php?controller=post&action=authors" class="btn btn-secondary">Cancel</a>
</form>