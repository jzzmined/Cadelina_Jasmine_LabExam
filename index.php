<?php require 'includes/functions.php'; $title = 'Home'; $user = $_SESSION['user'] ?? null; ?>
<?php include 'includes/auth_form_head.php'; ?>
<body class="landing">
  <header class="nav">
    <nav>
      <a href="index.php">Home</a><a href="#">About</a><a href="#">Shop</a><a href="#">Contacts</a>
      <?php if ($user): ?>
        <a class="btn-pill" href="dashboard.php">Dashboard</a>
        <a class="btn-pill" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn-pill" href="login.php">Login</a>
        <a class="btn-pill" href="register.php">Register</a>
      <?php endif; ?>
    </nav>
  </header>
  <main class="hero">
    <h1>Beauty<br>&amp; Confidence</h1>
    <p class="kicker">OWN YOUR GLOW</p>
    <p class="tagline">A place to explore beauty that feels like you – routines, rituals, and confidence made simple.</p>
  </main>
</body>
</html>