<?php
$post = $post ?? [];
$errors = $errors ?? [];
$categories = $categories ?? [];
$isLoggedIn = $is_logged_in ?? false;

if (!$isLoggedIn) {
    echo '<p class="text-danger">You must be logged in to add a post.</p>';
    return;
}
?>

<div class="card shadow-lg p-4 mt-4 mx-auto" style="max-width: 700px;">
    <h2 class="text-center mb-4">Add New Post</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?controller=post&action=addSubmit" enctype="multipart/form-data">
        <!-- Post Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" required
                value="<?= htmlspecialchars($post['title'] ?? '') ?>">
        </div>

        <!-- Post Body -->
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea id="body" name="body" class="form-control" rows="6"
                required><?= htmlspecialchars($post['body'] ?? '') ?></textarea>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>" <?= (isset($post['category_id']) && $post['category_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Media Upload -->
        <div class="mb-3">
            <label for="media" class="form-label">Upload Images/Videos</label>
            <input type="file" id="media" name="image[]" class="form-control" multiple
                accept=".jpg,.jpeg,.png,.gif,.mp4,.webm,.ogg">

            <!-- Preview will appear here -->
            <div id="preview" class="mt-3 d-flex flex-wrap gap-2"></div>

            <small class="text-muted">
                Supported: JPG, JPEG, PNG, GIF, MP4, WebM, OGG. Max size: 2MB per file.
            </small>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100" style="transition: 0.3s; font-weight: 600;">
            Add Post
        </button>
    </form>
</div>

<!-- Hover effect for the button -->
<style>
    .btn-primary:hover {
        background-color: #d32f2f;
        border-color: #d32f2f;
        transform: translateY(-2px);
    }

    #preview img,
    #preview video {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

<!-- Preview Script -->
<script>
    document.getElementById('media').addEventListener('change', function (event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // clear previous previews

        const files = event.target.files;
        if (files.length === 0) return;

        Array.from(files).forEach(file => {
            const ext = file.name.split('.').pop().toLowerCase();
            const reader = new FileReader();

            reader.onload = function (e) {
                let element;
                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                    element = document.createElement('img');
                    element.src = e.target.result;
                } else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                    element = document.createElement('video');
                    element.src = e.target.result;
                    element.controls = true;
                } else {
                    alert('Unsupported file type: ' + file.name);
                    return;
                }

                element.style.marginRight = '10px';
                element.style.marginBottom = '10px';
                preview.appendChild(element);
            }

            reader.readAsDataURL(file);
        });
    });
</script>