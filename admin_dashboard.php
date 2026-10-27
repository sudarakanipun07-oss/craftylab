<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$u_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$u_data = mysqli_fetch_assoc($u_res);

$f_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM user_feedback");
$f_data = mysqli_fetch_assoc($f_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CraftyLab</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #483d8b; 
            --body-bg: #f4f7fe;
            --accent: #764ba2;
            --status-label: #2d3748; 
        }

        body.dark-mode {
            --body-bg: #1a1a1a;
            --card-bg: #252525;
            --status-label: #ffffff; 
        }

        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: all 0.3s ease; }
        body { background: var(--body-bg); margin: 0; display: flex; color: #2d3748; overflow-x: hidden; }

        /* SIDEBAR */
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

        /* MAIN CONTENT AREA */
        .main { margin-left: 280px; width: calc(100% - 280px); padding: 40px; position: relative; }
        
        .header-section {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px;
        }

        .page-title h1 { margin: 0; font-size: 28px; font-weight: 700; color: var(--primary); letter-spacing: -0.5px; }
        .page-title p { margin: 5px 0 0 0; color: #718096; font-size: 14px; }
        .dark-mode .page-title p { color: #a0aec0; }

        #theme-toggle {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; background: white; border: 2px solid var(--primary);
            color: var(--primary); transition: 0.3s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .dark-mode #theme-toggle { background: white; color: var(--primary); border-color: var(--primary); }

        /* BANNER */
        .modern-banner {
            background: linear-gradient(135deg, #483d8b 0%, #764ba2 100%);
            padding: 40px; border-radius: 24px; position: relative; overflow: hidden;
            box-shadow: 0 20px 40px rgba(72, 61, 139, 0.2); margin-bottom: 40px;
        }
        .banner-content h2 { margin: 0; font-size: 30px; font-weight: 700; color: white; }
        .banner-content p { margin: 12px 0 0 0; font-size: 16px; color: rgba(255,255,255,0.9); max-width: 500px; line-height: 1.6; }

        /* STATS CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .stat-card { 
            background: white; padding: 30px; border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px; 
        }
        .dark-mode .stat-card { background: #252525; color: white; }

        .icon-box { width: 65px; height: 65px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; }
        .bg-blue { background: rgba(72, 61, 139, 0.08); color: #483d8b; }
        .bg-purple { background: rgba(118, 75, 162, 0.08); color: #764ba2; }

        .stat-info h3 { margin: 0; font-size: 26px; font-weight: 700; }
        .stat-info p { margin: 2px 0 0 0; font-size: 14px; color: #718096; }

        /* QUICK ACTIONS */
        .dashboard-row { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        .content-box { background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); }
        .dark-mode .content-box { background: #252525; color: white; }

        .quick-action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px; }
        .action-card {
            display: flex; align-items: center; gap: 15px; padding: 20px;
            background: #f8fafc; border: 1px solid #edf2f7; border-radius: 18px;
            text-decoration: none; color: #4a5568; transition: 0.3s;
        }
        .dark-mode .action-card { background: #2d3748; border-color: #4a5568; color: white; }
        .action-card:hover { transform: translateY(-5px); background: #483d8b; color: white !important; }

        /* System Status Text Fix */
        .status-line { color: var(--status-label) !important; font-weight: 500; }
        .db-status { color: #2f855a; font-weight: 700; } /* Dark Green for light mode */
        .dark-mode .db-status { color: #48bb78; } /* Lighter Green for dark mode */

        .divider { border: 0.1px solid rgba(255,255,255,0.1); margin: 25px 0; }
        .admin-label { text-align: center; margin-bottom: 10px; font-size: 0.85rem; color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">CraftyLab</div>
    <nav class="nav-menu">
        <a href="admin_dashboard.php" class="nav-link active">Dashboard</a>
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
            <h1>Dashboard Overview</h1>
            <p>Welcome back, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
        </div>
        <button id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </button>
    </header>

    <div class="modern-banner">
        <div class="banner-content">
            <h2>Welcome to your Admin Panel</h2>
            <p>Efficiently manage your CraftyLab ecosystem. Monitor user activity and respond to creative feedback in real-time.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon-box bg-blue"><i class="fas fa-users"></i></div>
            <div class="stat-info"><h3><?php echo $u_data['total']; ?></h3><p>Total Users</p></div>
        </div>
        <div class="stat-card">
            <div class="icon-box bg-purple"><i class="fas fa-comments"></i></div>
            <div class="stat-info"><h3><?php echo $f_data['total']; ?></h3><p>Feedbacks</p></div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="content-box">
            <h2 style="margin-top:0; font-size: 20px; color: var(--primary);">Quick Actions</h2>
            <div class="quick-action-grid">
                <a href="admin_users.php?mode=manage" class="action-card">
                    <i class="fas fa-user-edit"></i>
                    <span>Manage User Accounts</span>
                </a>
                <a href="admin_feedback.php?mode=manage" class="action-card">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Review Feedback</span>
                </a>
            </div>
        </div>
        <div class="content-box">
            <h2 style="margin-top:0; font-size: 20px; color: var(--primary);">System Status</h2>
            <p class="status-line">Database: <span class="db-status">Connected</span></p>
        </div>
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