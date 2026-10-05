<?php
require 'includes/functions.php';
if (!isset($_SESSION['user'])) { flash('error', 'Please log in first.'); redirect('login.php'); }
$flash = get_flash(); $title = 'Dashboard';
include 'includes/auth_form_head.php';
?>
<body class="landing">
  <header class="nav"><nav>
    <a href="index.php">Home</a><a class="btn-pill" href="logout.php">Logout</a>
  </nav></header>
  <main class="hero">
    <?php if ($flash): ?><div class="alert <?= e($flash['type']) ?>"><?= e($flash['msg']) ?></div><?php endif; ?>
    <h1>Hello,<br><?= e($_SESSION['user']['email']) ?></h1>
    <p class="kicker">OWN YOUR GLOW</p>
  </main>
</body>
</html>