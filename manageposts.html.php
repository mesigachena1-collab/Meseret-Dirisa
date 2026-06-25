<!-- manageposts.html.php -->

<h2>Manage Posts</h2>

<?php if (empty($variables['posts'])): ?>
    <p>No posts found.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($variables['posts'] as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['author_name']) ?></td>
                    <td><?= htmlspecialchars($post['category_name']) ?></td>
                    <td><?= htmlspecialchars($post['post_date']) ?></td>
                    <td>
                        <?php if (!empty($post['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars(explode(',', $post['image'])[0]) ?>" width="50" alt="">
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Only show edit/delete if current user is author -->
                        <?php if ($post['author_id'] == $variables['current_user_id']): ?>
                            <a href="index.php?controller=post&action=editPost&id=<?= $post['id'] ?>">Edit</a> |
                            <form action="index.php?controller=post&action=deletePost" method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        <?php else: ?>
                            <em>No actions</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p>
    <a href="index.php?controller=post&action=editPost">Add New Post</a>
</p>