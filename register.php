<?php
require 'includes/functions.php';
if (isset($_SESSION['user'])) redirect('dashboard.php');

$errors = [];
$email = $phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = clean($_POST['email'] ?? '');
    $phone    = clean($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (!csrf_ok()) {
        $errors['form'] = 'Session expired. Please try again.';
    } else {
        if ($email === '')                                  $errors['email'] = 'Email is required.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
        elseif (find_user($email))                          $errors['email'] = 'This email is already registered.';

        if ($msg = validate_password($password)) $errors['password'] = $msg;

        if ($confirm === '')                $errors['confirm_password'] = 'Please confirm your password.';
        elseif ($confirm !== $password)     $errors['confirm_password'] = 'Passwords do not match.';

        if ($phone === '')                                          $errors['phone'] = 'Phone number is required.';
        elseif (!preg_match('/^(\+63|0)9\d{9}$/', $phone))          $errors['phone'] = 'Use a valid PH number, e.g. 09123456789.';

        if (!$errors) {
            $users = load_users();
            $users[] = [
                'email'    => $email,
                'phone'    => $phone,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created'  => date('c'),
            ];
            save_users($users);
            flash('success', 'Registration successful! You can now log in.');
            redirect('login.php');
        }
    }
}
$title = 'Sign Up';
include 'includes/auth_form_head.php';
?>
<body class="auth">
  <div class="photo"></div>
  <section class="card">
    <h2>Sign Up</h2>
    <?php if (isset($errors['form'])): ?><div class="alert error"><?= e($errors['form']) ?></div><?php endif; ?>

    <form method="post" novalidate id="authForm">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

      <div class="field">
        <input type="email" name="email" placeholder="Email" value="<?= e($email) ?>" class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['email'])): ?><small class="err"><?= e($errors['email']) ?></small><?php endif; ?>
      </div>

      <div class="field pw">
        <input type="password" name="password" placeholder="Password" class="<?= isset($errors['password']) ? 'invalid' : '' ?>">
        <button type="button" class="eye" aria-label="Show password">👁</button>
        <?php if (isset($errors['password'])): ?><small class="err"><?= e($errors['password']) ?></small><?php endif; ?>
      </div>

      <div class="field pw">
        <input type="password" name="confirm_password" placeholder="Confirm Password" class="<?= isset($errors['confirm_password']) ? 'invalid' : '' ?>">
        <button type="button" class="eye" aria-label="Show password">👁</button>
        <?php if (isset($errors['confirm_password'])): ?><small class="err"><?= e($errors['confirm_password']) ?></small><?php endif; ?>
      </div>

      <div class="field">
        <input type="tel" name="phone" placeholder="Phone" value="<?= e($phone) ?>" class="<?= isset($errors['phone']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['phone'])): ?><small class="err"><?= e($errors['phone']) ?></small><?php endif; ?>
      </div>

      <button class="btn" type="submit">Sign Up</button>
    </form>
    <p class="switch">Already have an account? <a href="login.php">Login</a></p>
  </section>
  <script src="assets/js/script.js"></script>
</body>
</html>