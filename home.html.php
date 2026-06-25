<h1 class="mb-4 text-center">Latest Cultural Posts</h1>

<?php
// Ensure login variables are set
$loggedIn = $is_logged_in ?? false;
$currentAuthorId = $current_author_id ?? (int) ($_SESSION['author_id'] ?? 0);
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
            $body = nl2br(htmlspecialchars($post['body'] ?? $post['content'] ?? ''));
            $postDate = !empty($post['post_date']) ? date('F j, Y', strtotime($post['post_date'])) : 'Unknown';
            $images = !empty($post['image']) ? explode(',', $post['image']) : [];
            ?>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">

                    <!-- Media -->
                    <?php if (!empty($images)): ?>
                        <div class="carousel-container position-relative">
                            <div class="carousel-slides" style="display:flex; transition: transform 0.5s ease;">
                                <?php foreach ($images as $media): ?>
                                    <?php
                                    $media = trim($media);
                                    $ext = strtolower(pathinfo($media, PATHINFO_EXTENSION));
                                    $mediaPath = 'uploads/' . htmlspecialchars($media);
                                    ?>
                                    <?php if (in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
                                        <video controls class="w-100 mb-2" style="border-radius:10px;">
                                            <source src="<?= $mediaPath ?>" type="video/<?= $ext ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php elseif (file_exists($mediaPath)): ?>
                                        <img src="<?= $mediaPath ?>" alt="<?= $title ?>" class="w-100 mb-2" style="border-radius:10px;">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <?php if (count($images) > 1): ?>
                                <div class="carousel-controls mt-2 d-flex justify-content-between">
                                    <button class="prev btn btn-sm btn-secondary">&#10094;</button>
                                    <button class="next btn btn-sm btn-secondary">&#10095;</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Body -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $title ?></h5>

                        <!-- Post Meta with Icons -->
                        <p class="text-muted small mb-2 d-flex flex-wrap align-items-center gap-2">
                            <span><i class="bi bi-person-circle"></i> <?= $author ?></span>
                            <span class="mx-1">•</span>
                            <span><i class="bi bi-folder"></i> <?= $category ?></span>
                            <span class="mx-1">•</span>
                            <span><i class="bi bi-calendar"></i> <?= $postDate ?></span>
                        </p>

                        <!-- Post Body Text -->
                        <p class="card-text flex-grow-1"><?= $body ?></p>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap mt-2 gap-2">
                            <a href="index.php?controller=post&action=view&id=<?= $post['id'] ?>"
                                class="btn btn-primary btn-sm">Read More</a>

                            <?php if ($loggedIn && $currentAuthorId === (int) ($post['author_id'] ?? 0)): ?>
                                <a href="index.php?controller=post&action=edit&id=<?= $post['id'] ?>"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <form method="post" action="index.php?controller=post&action=delete" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Comments preview -->
                    <?php
                    $postComments = $comments[$post['id']] ?? [];
                    if (!empty($postComments)):
                        ?>
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

    <!-- Carousel JS -->
    <script>
        document.querySelectorAll('.carousel-container').forEach(container => {
            const slides = container.querySelector('.carousel-slides');
            const slideItems = slides.children;
            if (slideItems.length <= 1) return;

            let index = 0;
            const prevBtn = container.querySelector('.prev');
            const nextBtn = container.querySelector('.next');

            prevBtn.addEventListener('click', () => {
                index = (index - 1 + slideItems.length) % slideItems.length;
                slides.style.transform = `translateX(-${index * 100}%)`;
            });

            nextBtn.addEventListener('click', () => {
                index = (index + 1) % slideItems.length;
                slides.style.transform = `translateX(-${index * 100}%)`;
            });
        });
    </script>

<?php else: ?>
    <p class="text-muted text-center">No posts available yet. Check back soon!</p>
<?php endif; ?>