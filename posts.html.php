<h1 class="mb-4 text-center">Latest Cultural Posts</h1>

<?php
$loggedIn = $is_logged_in ?? false;
$currentAuthorId = $current_author_id ?? 0;
$posts = $posts ?? [];
$comments = $comments ?? [];
?>

<?php if (!empty($posts)): ?>
    <div class="row g-4">
        <?php foreach ($posts as $post): ?>
            <?php
            $title = htmlspecialchars($post['title'] ?? 'Untitled');
            $author = htmlspecialchars($post['author_name'] ?? 'Unknown');
            $category = htmlspecialchars($post['category_name'] ?? 'Culture');
            $body = nl2br(htmlspecialchars($post['body'] ?? ''));
            $postDate = !empty($post['post_date']) ? date('F j, Y', strtotime($post['post_date'])) : 'Unknown';
            $images = !empty($post['image']) ? explode(',', $post['image']) : [];
            ?>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100 post-card fade-in">
                    <!-- <div class="card shadow-sm h-100"> -->

                    <!-- Media Carousel -->
                    <?php if (!empty($images)): ?>
                        <div id="carousel-<?= $post['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $i => $media):
                                    $media = trim($media);
                                    $ext = strtolower(pathinfo($media, PATHINFO_EXTENSION));
                                    $mediaPath = 'uploads/' . htmlspecialchars($media);
                                    ?>
                                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                        <?php if (in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
                                            <video class="d-block w-100" controls>
                                                <source src="<?= $mediaPath ?>" type="video/<?= $ext ?>">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php elseif (file_exists($mediaPath)): ?>
                                            <img src="<?= $mediaPath ?>" class="d-block w-100" alt="<?= $title ?>">
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($images) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $post['id'] ?>"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $post['id'] ?>"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Body -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $title ?></h5>
                        <p class="text-muted small mb-2">
                            By <strong><?= $author ?></strong> | <?= $category ?> | <?= $postDate ?>
                        </p>
                        <p class="card-text flex-grow-1"><?= $body ?></p>

                        <div class="d-flex mt-2">
                            <a href="index.php?controller=post&action=view&id=<?= $post['id'] ?>"
                                class="btn btn-primary btn-sm me-2">Read More</a>

                            <?php if ($loggedIn && $currentAuthorId === (int) ($post['author_id'] ?? 0)): ?>
                                <a href="index.php?controller=post&action=edit&id=<?= $post['id'] ?>"
                                    class="btn btn-warning btn-sm me-2">Edit</a>
                                <form method="post" action="index.php?controller=post&action=delete" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm delete-post">Delete</button>
                                    <!-- <button type="submit" class="btn btn-danger btn-sm">Delete</button> -->
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Comments Preview -->
                        <?php $postComments = $comments[$post['id']] ?? []; ?>
                        <?php if (!empty($postComments)): ?>
                            <div class="mt-3">
                                <h6>Comments (<?= count($postComments) ?>)</h6>
                                <?php foreach ($postComments as $comment): ?>
                                    <div class="comment mb-1">
                                        <strong><?= htmlspecialchars($comment['name'] ?? 'Anonymous') ?></strong>:
                                        <?= nl2br(htmlspecialchars($comment['message'] ?? '')) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <p class="text-muted text-center">No posts available yet. Check back soon!</p>
<?php endif; ?>