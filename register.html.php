<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg p-4 mt-5">
            <h2 class="card-title text-center text-primary mb-4">Register Author</h2>

            <!-- Display errors if any -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form submits to AuthorController::registerSubmit -->
            <form method="post" action="index.php?controller=author&action=registerSubmit">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="author[name]" id="name" class="form-control" required
                        value="<?= htmlspecialchars($author['name'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="author[email]" id="email" class="form-control" required
                        value="<?= htmlspecialchars($author['email'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="author[password]" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea name="author[bio]" id="bio"
                        class="form-control"><?= htmlspecialchars($author['bio'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>

            <p class="text-center small mt-3">
                Already have an account?
                <a href="index.php?controller=login&action=login" class="text-primary">Login here!</a>
            </p>
        </div>
    </div>
</div>