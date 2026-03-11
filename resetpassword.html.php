<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <h3>Reset Password</h3>

            <form method="post" action="index.php?controller=login&action=resetPasswordSubmit">

                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <label>New Password</label>

                <input type="password" name="password" class="form-control" required>

                <button class="btn btn-success mt-3">
                    Reset Password
                </button>

            </form>

        </div>
    </div>
</div>