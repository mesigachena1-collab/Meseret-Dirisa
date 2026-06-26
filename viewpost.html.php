<?php
$singlePost = $posts[0] ?? null;
$isLoggedIn = $is_logged_in ?? false;
$currentAuthorId = $current_author_id ?? (int) ($_SESSION['author_id'] ?? 0);
?>

<?php if ($singlePost): ?>

  <h1 class="mb-4"><?= htmlspecialchars($singlePost['title']) ?></h1>

  <div class="card mb-4 shadow-sm">
    <!-- MEDIA DISPLAY -->
    <?php if (!empty($singlePost['image'])): ?>
      <div class="carousel-container position-relative">
        <?php
        $mediaFiles = explode(',', $singlePost['image']);
        foreach ($mediaFiles as $media):
          $media = trim($media);
          $filePath = 'uploads/' . $media;
          if (!file_exists($filePath))
            continue;
          $ext = strtolower(pathinfo($media, PATHINFO_EXTENSION));
          ?>
          <?php if (in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
            <video width="100%" controls class="card-img-top mb-2"
              style="max-height:500px; object-fit:contain; background-color:#000;">
              <source src="<?= htmlspecialchars($filePath) ?>" type="video/<?= htmlspecialchars($ext) ?>">
            </video>
          <?php else: ?>
            <img src="<?= htmlspecialchars($filePath) ?>" class="card-img-top mb-2"
              alt="<?= htmlspecialchars($singlePost['title']) ?>" style="max-height:400px; object-fit:cover;">
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="card-body">
      <p class="text-secondary mb-4"><?= nl2br(htmlspecialchars($singlePost['body'] ?? '')) ?></p>
      <p class="text-muted small border-top pt-2">
        Posted by <strong><?= htmlspecialchars($singlePost['author_name'] ?? 'Unknown') ?></strong>
        in <strong><?= htmlspecialchars($singlePost['category_name'] ?? 'Culture') ?></strong>
        on <?= !empty($singlePost['post_date']) ? date('F j, Y', strtotime($singlePost['post_date'])) : 'Unknown date' ?>
      </p>

      <!-- POST AUTHOR CONTROLS -->
      <?php if ($isLoggedIn && $currentAuthorId === (int) ($singlePost['author_id'] ?? 0)): ?>
        <div class="mt-3">
          <a href="index.php?controller=post&action=edit&id=<?= $singlePost['id'] ?>"
            class="btn btn-sm btn-warning">Edit</a>
          <form method="post" action="index.php?controller=post&action=delete" style="display:inline-block;"
            onsubmit="return confirm('Are you sure you want to delete this post?');">
            <input type="hidden" name="id" value="<?= $singlePost['id'] ?>">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- COMMENTS -->
  <h3>Comments</h3>

  <?php
  $postComments = $comments[$singlePost['id']] ?? [];
  ?>

  <?php if (empty($postComments)): ?>
    <p class="alert alert-info">Be the first to leave a comment!</p>
  <?php else: ?>
    <?php foreach ($postComments as $c):
      $c['author_id'] = (int) ($c['author_id'] ?? 0);
      ?>
      <div class="border p-3 mb-3 bg-light rounded shadow-sm comment-block" data-comment-id="<?= $c['id'] ?>">
        <strong><?= htmlspecialchars($c['author_name'] ?? 'Anonymous') ?></strong>
        <p class="mt-1 mb-1 comment-text"><?= nl2br(htmlspecialchars($c['body'] ?? '')) ?></p>
        <small
          class="text-muted"><?= !empty($c['created_at']) ? date('M j, Y H:i', strtotime($c['created_at'])) : '' ?></small>

        <!-- COMMENT EDIT / DELETE BUTTONS -->
        <?php if ($isLoggedIn && $currentAuthorId === $c['author_id']): ?>
          <div class="mt-2 d-flex gap-2">
            <button type="button" class="btn btn-sm btn-warning btn-edit-comment">Edit</button>
            <form action="index.php?controller=post&action=deleteComment" method="post"
              onsubmit="return confirm('Are you sure you want to delete this comment?');">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>

          <!-- EDIT FORM (hidden by default) -->
          <form class="edit-comment-form mt-2" action="index.php?controller=post&action=editComment" method="post"
            style="display:none;">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <textarea name="body" class="form-control mb-2" rows="3"><?= htmlspecialchars($c['body'] ?? '') ?></textarea>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-sm btn-success">Save</button>
              <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Cancel</button>
            </div>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- COMMENT FORM -->
  <?php if ($isLoggedIn): ?>
    <div class="card mt-4 shadow">
      <div class="card-body">
        <h4>Leave a Comment</h4>
        <form method="post" action="index.php?controller=post&action=addComment">
          <input type="hidden" name="post_id" value="<?= $singlePost['id'] ?>">
          <div class="mb-3">
            <label for="comment-body" class="form-label">Comment</label>
            <textarea id="comment-body" name="body" class="form-control" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
      </div>
    </div>
  <?php else: ?>
    <p class="text-muted">Please <a href="index.php?controller=login&action=login">login</a> to leave a comment.</p>
  <?php endif; ?>

<?php else: ?>
  <p class="text-muted">No post found.</p>
<?php endif; ?>

<!-- JS: Inline edit toggle -->
<script>
  document.querySelectorAll('.comment-block').forEach(block => {
    const editBtn = block.querySelector('.btn-edit-comment');
    const cancelBtn = block.querySelector('.btn-cancel-edit');
    const editForm = block.querySelector('.edit-comment-form');
    const commentText = block.querySelector('.comment-text');

    if (editBtn) {
      editBtn.addEventListener('click', () => {
        commentText.style.display = 'none';
        editForm.style.display = 'block';
        editBtn.style.display = 'none';
      });
    }

    if (cancelBtn) {
      cancelBtn.addEventListener('click', () => {
        editForm.style.display = 'none';
        commentText.style.display = 'block';
        if (editBtn) editBtn.style.display = 'inline-block';
      });
    }
  });
</script>