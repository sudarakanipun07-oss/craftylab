<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Logic for deleting feedback
if (isset($_GET['del_feedback'])) {
    $id = mysqli_real_escape_string($conn, $_GET['del_feedback']);
    mysqli_query($conn, "DELETE FROM user_feedback WHERE id = '$id'");
    header("Location: admin_feedback.php?mode=manage");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks | Admin Dashboard</title>
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

        /* TABLE CONTAINER */
        .table-container { 
            background: white; padding: 35px; border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); 
        }
        .dark-mode .table-container { background: #252525; color: white; }

        table { width: 100%; border-collapse: collapse; }
        th { 
            text-align: left; padding: 18px; color: #718096; 
            font-weight: 600; border-bottom: 2px solid #f4f7fe; text-transform: uppercase; font-size: 12px;
        }
        .dark-mode th { border-bottom-color: #333; }
        td { padding: 18px; border-bottom: 1px solid #f4f7fe; font-size: 14px; vertical-align: middle; }
        .dark-mode td { border-bottom-color: #333; }

        .user-name { font-weight: 600; color: var(--primary); }
        .dark-mode .user-name { color: #a5a2d9; }

        .btn-del { 
            width: 40px; height: 40px; border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(229, 62, 62, 0.1); color: #e53e3e; 
            text-decoration: none; transition: 0.3s;
        }
        .btn-del:hover { background: #e53e3e; color: white; transform: scale(1.1); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">CraftyLab</div>
    <nav class="nav-menu">
        <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
        <a href="index.php" class="nav-link">View Website</a>
        <a href="admin_users.php" class="nav-link">Registered Users</a>
        <a href="admin_feedback.php" class="nav-link active">Feedbacks</a>
        <hr class="divider">
        <div class="admin-label">Hi, Admin!</div>
        <a href="main_logout.php" class="nav-link" style="color: #ff8080 !important; background: rgba(255, 128, 128, 0.08);">Logout</a>
    </nav>
</div>

<div class="main">
    <header class="header-section">
        <div class="page-title">
            <h1>User Feedbacks</h1>
            <p>Review and manage customer messages from here.</p>
        </div>
        <button id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </button>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User Info</th> <th>Message</th>
                    <?php if(isset($_GET['mode'])) echo "<th style='text-align:center;'>Action</th>"; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $fb_query = "SELECT * FROM user_feedback ORDER BY id DESC";
                $fb_result = mysqli_query($conn, $fb_query);
                while($row = mysqli_fetch_assoc($fb_result)) {
                    echo "<tr>
                            <td>
                                <div class='user-name'>" . htmlspecialchars($row['name']) . "</div>
                                <div style='font-size:12px; color:#718096;'>" . htmlspecialchars($row['email']) . "</div>
                            </td>
                            <td style='max-width:450px; line-height:1.6; color:#4a5568;'>" . htmlspecialchars($row['message']) . "</td>";
                            if(isset($_GET['mode']) && $_GET['mode'] == 'manage') {
                                echo "<td style='text-align:center;'>
                                        <a href='admin_feedback.php?del_feedback=".$row['id']."&mode=manage' 
                                           onclick=\"return confirm('Delete this message?')\" class='btn-del'>
                                            <i class='fas fa-trash-alt'></i>
                                        </a>
                                      </td>";
                            }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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