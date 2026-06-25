<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$loggedIn = !empty($_SESSION['author_id']);
$authorName = $_SESSION['author_name'] ?? 'Author';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'World Culture Show') ?></title>

  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/script.css">

  <style>
    /* Body */
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f2f3f5;
    }

    /* Navbar: soft blue gradient */
    .navbar {
      background: linear-gradient(90deg, #4267B2, #2D4373);
      /* FB-ish blue */
      transition: background 0.3s ease;
    }

    .navbar .navbar-brand {
      font-weight: 700;
      color: #fff !important;
    }

    .navbar a.nav-link {
      color: #e4e6eb;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .navbar a.nav-link:hover {
      color: #ffffff;
      transform: scale(1.05);
    }

    /* Welcome text: softer, light gray */
    .navbar .text-warning {
      color: #f0f2f5 !important;
      /* soft white/gray */
    }

    /* Dropdown menu: subtle shadow */
    .dropdown-menu {
      background: #fff;
      border-radius: 6px;
      border: 1px solid #ddd;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
      color: #333;
      transition: background 0.3s ease;
    }

    .dropdown-item:hover {
      background-color: #f0f2f5;
      color: #4267B2;
    }

    /* Buttons: subtle flat style */
    .btn-primary {
      background-color: #4267B2;
      border-color: #4267B2;
      color: #fff;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary:hover {
      background-color: #365899;
      border-color: #365899;
      transform: translateY(-2px);
    }

    /* Add Post link button */
    .nav-link.text-success.fw-bold {
      color: #42b72a !important;
      font-weight: 600;
    }

    .nav-link.text-success.fw-bold:hover {
      color: #36a420 !important;
    }

    /* Footer: soft */
    footer {
      background: #f2f3f5;
      color: #333;
      text-align: center;
      padding: 15px 0;
      box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
    }

    /* Card hover effect */
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php?controller=post&action=home">World Culture Show</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a href="index.php?controller=post&action=home" class="nav-link">Home</a></li>

          <?php if ($loggedIn): ?>
            <li class="nav-item"><span class="nav-link text-warning">Welcome, <?= htmlspecialchars($authorName) ?></span>
            </li>
            <li class="nav-item"><a class="nav-link text-success fw-bold" href="index.php?controller=post&action=add">Add
                New Post</a></li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dashboardDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">Dashboard</a>
              <ul class="dropdown-menu" aria-labelledby="dashboardDropdown">
                <li><a class="dropdown-item" href="index.php?controller=post&action=manage">Manage Posts</a></li>
                <li><a class="dropdown-item" href="index.php?controller=post&action=categories">Manage Categories</a></li>
                <li><a class="dropdown-item" href="index.php?controller=post&action=authors">Manage Authors</a></li>
              </ul>
            </li>

            <li class="nav-item"><a href="index.php?controller=contact&action=index" class="nav-link">Contact Us</a></li>
            <li class="nav-item"><a href="index.php?controller=login&action=logout"
                class="nav-link text-danger">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a href="index.php?controller=author&action=registrationForm" class="nav-link">Sign
                Up</a></li>
            <li class="nav-item"><a href="index.php?controller=login&action=login" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="index.php?controller=contact&action=index" class="nav-link">Contact Us</a></li>
          <?php endif; ?>

          <li class="nav-item ms-3">
            <form action="index.php" method="GET" class="d-flex">
              <input type="hidden" name="controller" value="post">
              <input type="hidden" name="action" value="home">
              <!-- <input type="text" id="searchInput" placeholder="Search posts..." class="form-control"> -->
              <input type="text" name="search" class="form-control me-2" placeholder="Search..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              <button type="submit" class="btn btn-primary">Go</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container mt-4">
    <?= $output ?? '' ?>
  </main>

  <!-- FOOTER -->
  <footer class="text-center py-3 mt-4">
    &copy; <?= date('Y') ?> World Culture Show
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="/js/script.js"></script> -->
</body>

</html>