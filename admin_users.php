<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Logic for deleting user
if (isset($_GET['del_user'])) {
    $id = mysqli_real_escape_string($conn, $_GET['del_user']);
    mysqli_query($conn, "DELETE FROM users WHERE id = '$id' AND user_role != 'admin'");
    header("Location: admin_users.php?mode=manage");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users | Admin Dashboard</title>
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

        /* SPECIAL ROW FOR ADMIN */
        .admin-row { background-color: rgba(72, 61, 139, 0.03); }
        .dark-mode .admin-row { background-color: rgba(255, 255, 255, 0.02); }

        .role-badge { 
            padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 700; 
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .user-bg { background: #e2e8f0; color: #4a5568; }
        .admin-bg { background: var(--primary); color: white; }

        /* BUTTONS */
        .btn-action { 
            width: 38px; height: 38px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; transition: 0.3s;
        }
        .btn-del { background: rgba(229, 62, 62, 0.1); color: #e53e3e; }
        .btn-del:hover { background: #e53e3e; color: white; transform: scale(1.1); }
        
        .btn-edit { background: rgba(72, 61, 139, 0.1); color: var(--primary); }
        .btn-edit:hover { background: var(--primary); color: white; transform: scale(1.1); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">CraftyLab</div>
    <nav class="nav-menu">
        <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
        <a href="index.php" class="nav-link">View Website</a>
        <a href="admin_users.php" class="nav-link active">Registered Users</a>
        <a href="admin_feedback.php" class="nav-link">Feedbacks</a>
        <hr class="divider">
        <div class="admin-label">Hi, Admin!</div>
        <a href="main_logout.php" class="nav-link" style="color: #ff8080 !important; background: rgba(255, 128, 128, 0.08);">Logout</a>
    </nav>
</div>

<div class="main">
    <header class="header-section">
        <div class="page-title">
            <h1>User Management</h1>
            <p>Monitor and manage all registered accounts on CraftyLab.</p>
        </div>
        <button id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </button>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Details</th>
                    <th>Role</th>
                    <?php if(isset($_GET['mode'])) echo "<th style='text-align:center;'>Action</th>"; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_query = "SELECT * FROM users ORDER BY id ASC";
                $user_result = mysqli_query($conn, $user_query);
                while($u_row = mysqli_fetch_assoc($user_result)) {
                    $isAdmin = (strtolower($u_row['user_role']) === 'admin');
                    $rowClass = $isAdmin ? "class='admin-row'" : "";
                    $badgeClass = $isAdmin ? "admin-bg" : "user-bg";
                    
                    echo "<tr $rowClass>
                            <td style='color:#718096; font-weight:600;'>#" . $u_row['id'] . "</td>
                            <td>
                                <div style='font-weight:600; color:var(--primary);'>" . htmlspecialchars($u_row['username']) . ($isAdmin ? " <i class='fas fa-shield-alt' style='font-size:12px;'></i>" : "") . "</div>
                                <div style='font-size:12px; color:#718096;'>" . htmlspecialchars($u_row['email']) . "</div>
                            </td>
                            <td><span class='role-badge $badgeClass'>" . ucfirst($u_row['user_role']) . "</span></td>";
                            
                            if(isset($_GET['mode']) && $_GET['mode'] == 'manage') {
                                echo "<td style='text-align:center;'>";
                                if($isAdmin) {
                                    echo "<a href='admin_profile_edit.php' class='btn-action btn-edit' title='Edit My Profile'><i class='fas fa-user-cog'></i></a>";
                                } else {
                                    echo "<a href='admin_users.php?del_user=".$u_row['id']."&mode=manage' 
                                           onclick=\"return confirm('Are you sure you want to delete this user?')\" 
                                           class='btn-action btn-del' title='Delete User'>
                                            <i class='fas fa-user-minus'></i>
                                          </a>";
                                }
                                echo "</td>";
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