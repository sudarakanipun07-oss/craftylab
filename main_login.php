<?php
session_start();
include 'db_config.php';

$error = "";

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $password = mysqli_real_escape_string($conn, $_POST['u_pass']);

    // Database එකේ දත්ත පරීක්ෂා කිරීම
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Session දත්ත ගබඩා කිරීම
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['user_role']; 

        // Admin හෝ User ඕනෑම අයෙක් ලොග් වූ පසු කෙළින්ම index.php වෙත යැවීම
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CraftyLab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0;
        }
        .login-card {
            background: #ffffff; padding: 45px; border-radius: 24px; width: 420px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15); text-align: center;
        }
        .login-card h2 { color: #2d3748; margin-bottom: 8px; font-size: 30px; font-weight: 600; }
        .login-card p { color: #718096; font-size: 14px; margin-bottom: 35px; }

        .input-group { position: relative; margin-bottom: 20px; text-align: left; }
        .input-group i { position: absolute; left: 15px; top: 42px; color: #a0aec0; }
        .input-group label { font-size: 13px; font-weight: 500; color: #4a5568; margin-left: 5px; }
        .input-group input {
            width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px;
            border: 2px solid #edf2f7; outline: none; transition: 0.3s; margin-top: 6px;
        }
        .input-group input:focus { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1); }

        .options-container {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 25px; font-size: 13px;
        }
        .show-pass { display: flex; align-items: center; gap: 6px; cursor: pointer; color: #4a5568; }
        .show-pass input { cursor: pointer; accent-color: #667eea; }

        .login-btn {
            width: 100%; padding: 14px; border: none; border-radius: 12px;
            background: linear-gradient(to right, #764ba2, #667eea);
            color: white; font-size: 16px; font-weight: 600; cursor: pointer;
            transition: 0.3s; box-shadow: 0 10px 15px rgba(102, 126, 234, 0.3);
        }
        .login-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(102, 126, 234, 0.4); }

        .error-alert {
            background: #fff5f5; color: #c53030; padding: 12px; border-radius: 10px;
            font-size: 13px; margin-bottom: 20px; border-left: 4px solid #f56565;
            display: flex; align-items: center; gap: 10px; text-align: left;
        }

        .signup-link { margin-top: 30px; font-size: 14px; color: #718096; }
        .signup-link a { color: #764ba2; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .signup-link a:hover { color: #667eea; }

        .back-btn {
            margin-top: 15px; display: inline-block; font-size: 12px;
            color: #a0aec0; text-decoration: none; transition: 0.2s;
        }
        .back-btn:hover { color: #718096; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Welcome Back</h2>
    <p>Please enter your details to sign in.</p>

    <?php if($error): ?>
        <div class="error-alert">
            <i class="fas fa-circle-exclamation"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="main_login.php" autocomplete="off">
        <div class="input-group">
            <label>Gmail Address</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="u_email" placeholder="name@gmail.com" required autocomplete="off">
        </div>

        <div class="input-group">
            <label>Password</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="u_pass" id="login_pass" placeholder="" required autocomplete="new-password">
        </div>

        <div class="options-container">
            <label class="show-pass" onclick="togglePassword()">
                <input type="checkbox" id="check"> Show Password
            </label>
            <a href="#" style="color: #764ba2; text-decoration: none; font-weight: 500;">Forgot?</a>
        </div>

        <button type="submit" name="login_btn" class="login-btn">Sign In</button>
    </form>

    <div class="signup-link">
        New to CraftyLab? <a href="signup.php">Create an account</a>
    </div>
    
    <a href="index.php" class="back-btn">← Back to Homepage</a>
</div>

<script>
    function togglePassword() {
        const passInput = document.getElementById('login_pass');
        const check = document.getElementById('check');
        if (passInput.type === "password") {
            passInput.type = "text";
            check.checked = true;
        } else {
            passInput.type = "password";
            check.checked = false;
        }
    }
</script>

</body>
</html>