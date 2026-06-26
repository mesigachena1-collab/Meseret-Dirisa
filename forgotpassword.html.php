<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <h3>Forgot Password</h3>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= $errorMessage ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?controller=login&action=forgotPasswordSubmit">

                <label>Email</label>
                <input type="email" name="email" class="form-control" required>

                <button class="btn btn-primary mt-3">
                    Send Reset Link
                </button>

            </form>

        </div>
    </div>
</div>