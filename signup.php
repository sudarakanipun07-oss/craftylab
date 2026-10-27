<?php
session_start();
include 'db_config.php';

$message = "";
$message_type = "";

if (isset($_POST['signup_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['u_name']);
    $email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $password = mysqli_real_escape_string($conn, $_POST['u_pass']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['u_confirm_pass']);

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $message_type = "error";
    } else if (!str_ends_with($email, '@gmail.com')) {
        $message = "Please use a valid @gmail.com address!";
        $message_type = "error";
    } else {
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $check_email);
        if (mysqli_num_rows($res) > 0) {
            $message = "This email is already registered!";
            $message_type = "error";
        } else {
            $sql = "INSERT INTO users (username, email, password, user_role) VALUES ('$username', '$email', '$password', 'user')";
            if (mysqli_query($conn, $sql)) {
                $message = "Account created successfully! Please Log In.";
                $message_type = "success";
            } else {
                $message = "Something went wrong. Please try again.";
                $message_type = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join CraftyLab | Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0;
        }
        .signup-card {
            background: white; padding: 40px; border-radius: 24px; width: 450px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2); text-align: center;
        }
        .signup-card h2 { color: #2d3748; margin-bottom: 8px; font-size: 28px; }
        .signup-card p { color: #718096; font-size: 14px; margin-bottom: 30px; }
        
        .input-group { position: relative; margin-bottom: 20px; text-align: left; }
        .input-group i { position: absolute; left: 15px; top: 40px; color: #a0aec0; }
        .input-group label { font-size: 13px; font-weight: 500; color: #4a5568; margin-left: 5px; }
        .input-group input {
            width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px;
            border: 2px solid #edf2f7; outline: none; transition: 0.3s; margin-top: 5px;
        }
        .input-group input:focus { border-color: #764ba2; box-shadow: 0 0 0 4px rgba(118, 75, 162, 0.1); }
        
        .show-pass-container { display: flex; align-items: center; gap: 8px; margin-bottom: 25px; cursor: pointer; }
        .show-pass-container input { cursor: pointer; width: 16px; height: 16px; accent-color: #764ba2; }
        .show-pass-container label { font-size: 13px; color: #4a5568; cursor: pointer; }

        .signup-btn {
            width: 100%; padding: 14px; border: none; border-radius: 12px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white; font-size: 16px; font-weight: 600; cursor: pointer;
            box-shadow: 0 10px 15px rgba(118, 75, 162, 0.3); transition: 0.3s;
        }
        .signup-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(118, 75, 162, 0.4); }

        .alert { padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; text-align: left; }
        .alert-error { background: #fff5f5; color: #c53030; border-left: 4px solid #f56565; }
        .alert-success { background: #f0fff4; color: #2f855a; border-left: 4px solid #48bb78; }

        .login-link { margin-top: 25px; font-size: 14px; color: #718096; }
        .login-link a { color: #764ba2; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="signup-card">
    <h2>Create Account</h2>
    <p>Sign up to explore exclusive craft ideas.</p>

    <?php if($message): ?>
        <div class="alert alert-<?php echo $message_type == 'error' ? 'error' : 'success'; ?>">
            <i class="fas <?php echo $message_type == 'error' ? 'fa-circle-xmark' : 'fa-circle-check'; ?>"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <div class="input-group">
            <label>Full Name</label>
            <i class="fas fa-user"></i>
            <input type="text" name="u_name" placeholder="D.I. egodagamagedara" required autocomplete="new-password">
        </div>

        <div class="input-group">
            <label>Gmail Address</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="u_email" placeholder="example@gmail.com" required autocomplete="off">
        </div>

        <div class="input-group">
            <label>Password</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="u_pass" id="p1" placeholder="" required autocomplete="new-password">
        </div>

        <div class="input-group">
            <label>Confirm Password</label>
            <i class="fas fa-shield-halved"></i>
            <input type="password" name="u_confirm_pass" id="p2" placeholder="" required autocomplete="new-password">
        </div>

        <div class="show-pass-container" onclick="togglePass()">
            <input type="checkbox" id="check">
            <label for="check">Show Passwords</label>
        </div>

        <button type="submit" name="signup_btn" class="signup-btn">Get Started</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="main_login.php">Log In</a>
    </div>
</div>

<script>
    function togglePass() {
        const p1 = document.getElementById('p1');
        const p2 = document.getElementById('p2');
        const check = document.getElementById('check');
        if (p1.type === "password") {
            p1.type = "text";
            p2.type = "text";
            check.checked = true;
        } else {
            p1.type = "password";
            p2.type = "password";
            check.checked = false;
        }
    }
</script>

</body>
</html>