<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="fw-light my-4">Register as an Author</h3>
            </div>
            <div class="card-body p-4">

                <!-- Display Errors -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <p class="fw-bold mb-1">Registration Failed:</p>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Display Success Message -->
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <p class="mb-0"><?= htmlspecialchars($success) ?>. You can now <a href="login.php" class="alert-link">log in</a>.</p>
                    </div>
                <?php endif; ?>

                <form action="signup.php" method="POST">
                    
                    <!-- Full Name -->
                    <div class="form-floating mb-3">
                        <!-- Use $_POST['name'] to retain value on error -->
                        <input class="form-control" id="inputName" type="text" name="name" placeholder="Full Name" 
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required />
                        <label for="inputName">Full Name</label>
                    </div>

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <!-- Use $_POST['email'] to retain value on error -->
                        <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
                        <label for="inputEmail">Email address</label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <!-- We generally do NOT retain password value for security reasons -->
                        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password (min 8 chars)" required />
                        <label for="inputPassword">Password (min 8 characters)</label>
                    </div>
                    
                    <!-- Biography -->
                    <div class="mb-3">
                        <label for="inputBio" class="form-label text-muted">Brief Biography (Optional)</label>
                        <!-- Use $_POST['bio'] to retain value on error -->
                        <textarea class="form-control" id="inputBio" name="bio" rows="3" placeholder="Tell us about yourself and your cultural interests..."><?= htmlspecialchars($_POST['bio'] ?? '') ?></textarea>
                    </div>


                    <div class="d-grid mt-4 mb-0">
                        <button class="btn btn-primary btn-lg" type="submit" name="register">Register Account</button>
                    </div>
                </form>
            </div>
            
            <!-- Link to the Login page -->
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="login.php">Already have an account? Log In!</a>
                </div>
            </div>
        </div>
    </div>
</div>