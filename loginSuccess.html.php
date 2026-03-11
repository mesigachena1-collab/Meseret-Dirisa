<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg p-4 mt-5 text-center">
            <h2 class="card-title text-success mb-4">Login Successful!</h2>

            <p class="mb-3">
                Welcome back,
                <?= htmlspecialchars($_SESSION['author_name'] ?? $_SESSION['username'] ?? 'User') ?>.
            </p>

            <a href="index.php?controller=post&action=home" class="btn btn-primary w-50">
                Go to Home
            </a>
        </div>
    </div>
</div>