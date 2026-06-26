<form method="post" action="index.php?controller=login&action=loginSubmit">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">

                <div class="card shadow-lg p-4 mt-5">
                    <h2 class="text-center text-primary mb-4">Author Login</h2>

                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php?controller=login&action=loginSubmit">

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($email ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php?controller=login&action=forgotPassword">
                            Forgot Password?
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>