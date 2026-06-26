<?php
$post = $post ?? [];
$postId = $post['id'] ?? null;
$title = $post['title'] ?? '';
$body = $post['body'] ?? '';
$categoryId = $post['category_id'] ?? null;
$images = !empty($post['image']) ? explode(',', $post['image']) : [];
$altTexts = !empty($post['alt_text']) ? explode(',', $post['alt_text']) : [];
?>

<h1><?= $postId ? 'Edit Post' : 'Add New Post' ?></h1>

<form method="post" action="index.php?controller=post&action=editSubmit" enctype="multipart/form-data">
    <input type="hidden" name="post[id]" value="<?= htmlspecialchars($postId) ?>">

    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="post[title]" id="title" class="form-control" value="<?= htmlspecialchars($title) ?>"
            required>
    </div>

    <!-- Body -->
    <div class="mb-3">
        <label for="body" class="form-label">Content</label>
        <textarea name="post[body]" id="body" class="form-control" rows="6"
            required><?= htmlspecialchars($body) ?></textarea>
    </div>

    <!-- Category -->
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="post[category_id]" id="category" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= ($categoryId ?? 0) == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Existing Images / Videos -->
    <?php if (!empty($images)): ?>
        <div class="mb-3">
            <p>Current media:</p>
            <div class="d-flex flex-wrap">
                <?php foreach ($images as $i => $media):
                    $filePath = 'uploads/' . trim($media);
                    if (!file_exists($filePath))
                        continue;
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $alt = $altTexts[$i] ?? '';
                    ?>
                    <div style="margin:5px; text-align:center;">
                        <?php if (in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
                            <video src="<?= htmlspecialchars($filePath) ?>" style="max-width:150px;" controls></video>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($filePath) ?>" style="max-width:150px;"
                                alt="<?= htmlspecialchars($alt) ?>">
                        <?php endif; ?>

                        <!-- Editable alt text for existing media -->
                        <input type="text" name="alt_text_existing[<?= $i ?>]" class="form-control mt-1"
                            value="<?= htmlspecialchars($alt) ?>" placeholder="Alt text for this media">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Upload New Media -->
    <div class="mb-3">
        <label for="image" class="form-label">Upload New Image(s) / Video(s)</label>
        <input type="file" name="image[]" id="image" class="form-control" multiple>
        <small class="form-text text-muted">
            Allowed types: JPG, JPEG, PNG, GIF, MP4, WebM, OGG. Max size: 2MB each.
        </small>
    </div>

    <!-- Alt text for new uploads -->
    <div class="mb-3">
        <label for="alt_text" class="form-label">Alt Text for New Media (comma separated)</label>
        <input type="text" name="alt_text[]" id="alt_text" class="form-control"
            placeholder="Alt text for each new image/video in order">
    </div>

    <button type="submit" class="btn btn-success"><?= $postId ? 'Update Post' : 'Add Post' ?></button>
</form>