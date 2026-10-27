<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['user_id']; 
$msg = "";

$query = mysqli_query($conn, "SELECT username, email FROM users WHERE id = '$admin_id'");
$admin_data = mysqli_fetch_assoc($query);

if (isset($_POST['update_profile'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']); 

    if (!empty($new_pass)) {
        $update_query = "UPDATE users SET email='$new_email', password='$new_pass' WHERE id='$admin_id'";
    } else {
        $update_query = "UPDATE users SET email='$new_email' WHERE id='$admin_id'";
    }

    if (mysqli_query($conn, $update_query)) {
        $msg = "<div class='alert-success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
        $admin_data['email'] = $new_email;
    } else {
        $msg = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> Error updating profile.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #483d8b; 
            --body-bg: #f4f7fe;
            --accent: #764ba2;
        }

        body.dark-mode {
            --body-bg: #1a1a1a;
            --card-bg: #252525;
        }

        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: all 0.3s ease; }
        body { background: var(--body-bg); margin: 0; display: flex; color: #2d3748; overflow-x: hidden; }

        /* SIDEBAR - EXACT DASHBOARD STYLE */
        .sidebar { 
            width: 280px; height: 100vh; background: #483d8b; color: white; 
            padding: 40px 20px; position: fixed; display: flex; flex-direction: column;
            z-index: 100;
        }
        .logo { font-size: 30px; font-weight: 800; text-align: center; margin-bottom: 40px; letter-spacing: -1px; }
        .nav-menu { display: flex; flex-direction: column; gap: 12px; }
        .nav-link {
            display: block; text-align: center; color: white; text-decoration: none;
            padding: 12px 20px; border-radius: 50px; font-size: 0.95rem; font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
        }
        .nav-link.active { background: white; color: #483d8b !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .nav-link:hover { background: rgba(255, 255, 255, 0.2); }
        .divider { border: 0.1px solid rgba(255,255,255,0.1); margin: 25px 0; }
        .admin-label { text-align: center; margin-bottom: 10px; font-size: 0.85rem; color: rgba(255,255,255,0.6); }

        /* MAIN CONTENT */
        .main { margin-left: 280px; width: calc(100% - 280px); padding: 40px; position: relative; }
        
        /* HEADER SECTION */
        .header-section {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px;
        }
        .page-title h1 { margin: 0; font-size: 28px; font-weight: 700; color: var(--primary); letter-spacing: -0.5px; }
        .page-title p { margin: 5px 0 0 0; color: #718096; font-size: 14px; }
        .dark-mode .page-title h1 { color: #fff; }

        /* THEME TOGGLE */
        #theme-toggle {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; background: white; border: 2px solid var(--primary);
            color: var(--primary); transition: 0.3s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .dark-mode #theme-toggle { background: white; color: var(--primary); border-color: var(--primary); }

        /* EDIT CARD CONTAINER */
        .edit-card { 
            background: white; padding: 40px; border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); max-width: 600px; margin: 0 auto;
        }
        .dark-mode .edit-card { background: #252525; color: white; }

        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 10px; color: #718096; font-size: 14px; font-weight: 500; }
        .dark-mode .form-group label { color: #a0aec0; }

        .form-group input { 
            width: 100%; padding: 14px; border: 1px solid #edf2f7; border-radius: 15px; 
            background: #f8fafc; font-size: 15px; outline: none; transition: 0.3s;
        }
        .dark-mode .form-group input { background: #2d3748; border-color: #4a5568; color: white; }
        .form-group input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(72, 61, 139, 0.1); }
        .form-group input:disabled { background: #e2e8f0; cursor: not-allowed; }
        .dark-mode .form-group input:disabled { background: #1a202c; color: #718096; }

        .btn-save { 
            width: 100%; padding: 16px; background: var(--primary); color: white; 
            border: none; border-radius: 15px; cursor: pointer; font-weight: 600; font-size: 16px;
            box-shadow: 0 10px 20px rgba(72, 61, 139, 0.2); transition: 0.3s;
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(72, 61, 139, 0.3); opacity: 0.9; }

        /* ALERTS */
        .alert-success { background: #dcfce7; color: #15803d; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .alert-danger { background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">CraftyLab</div>
    <nav class="nav-menu">
        <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
        <a href="index.php" class="nav-link">View Website</a>
        <a href="admin_users.php" class="nav-link">Registered Users</a>
        <a href="admin_feedback.php" class="nav-link">Feedbacks</a>
        <hr class="divider">
        <div class="admin-label">Hi, Admin!</div>
        <a href="main_logout.php" class="nav-link" style="color: #ff8080 !important; background: rgba(255, 128, 128, 0.08);">Logout</a>
    </nav>
</div>

<div class="main">
    <header class="header-section">
        <div class="page-title">
            <h1>Account Settings</h1>
            <p>Update your admin profile information here.</p>
        </div>
        <button id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </button>
    </header>

    <div class="edit-card">
        <h2 style="margin-top:0; font-size: 22px; margin-bottom: 25px; color: var(--primary);">
            <i class="fas fa-user-shield" style="margin-right:10px;"></i>Admin Profile
        </h2>
        
        <?php echo $msg; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username (Cannot be changed)</label>
                <input type="text" value="<?php echo htmlspecialchars($admin_data['username']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($admin_data['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>New Password (Leave blank to keep current)</label>
                <input type="text" name="password" placeholder="Enter your new password">
            </div>
            <button type="submit" name="update_profile" class="btn-save">
                <i class="fas fa-save" style="margin-right:8px;"></i> Update Profile Details
            </button>
        </form>
    </div>
</div>

<script>
    const body = document.body;
    const icon = document.getElementById('toggle-icon');
    const themeToggle = document.getElementById('theme-toggle');

    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        if (icon) icon.classList.replace('fa-moon', 'fa-sun');
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const isDark = body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        if (icon) {
            icon.classList.toggle('fa-sun', isDark);
            icon.classList.toggle('fa-moon', !isDark);
        }
    });
</script>
</body>
</html>