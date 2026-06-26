<h2 class="text-center text-primary mb-4">Contact Us</h2>

<?php if (!empty($success)): ?>
  <div class="alert alert-success text-center">
    Message sent successfully!
  </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger text-center">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-lg p-4 mb-4">
      <form action="index.php?controller=contact&action=submit" method="post">

        <div class="mb-3">
          <label class="form-label fw-bold">Name:</label>
          <input type="text" name="name" class="form-control rounded-pill"
            value="<?= htmlspecialchars($postedValues['name'] ?? '') ?>" placeholder="Your Name" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Email:</label>
          <input type="email" name="email" class="form-control rounded-pill"
            value="<?= htmlspecialchars($postedValues['email'] ?? '') ?>" placeholder="you@example.com" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Message:</label>
          <textarea name="message" class="form-control rounded" rows="5" placeholder="Your message here..."
            required><?= htmlspecialchars($postedValues['message'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
          Send Message
        </button>

      </form>
    </div>
  </div>
</div>

<style>
  /* Card hover effect */
  .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }

  /* Input focus */
  .form-control:focus {
    border-color: #4b6cb7;
    box-shadow: 0 0 5px rgba(75, 108, 183, 0.5);
  }

  /* Button hover */
  .btn-primary:hover {
    background-color: #ff4c4c;
    border-color: #182848;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
</style>