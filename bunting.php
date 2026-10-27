<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Birthday Bunting - CraftyLab</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f4f9; 
            color: #333; 
            transition: background-color 0.5s ease, color 0.5s ease; 
        }
        .content, .tutorial-details, .metadata-box, .material-item, .step-item {
            transition: background-color 0.5s ease, color 0.5s ease, box-shadow 0.5s ease;
        }

        .metadata-box {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); 
            border: none !important; 
            display: flex; 
            justify-content: space-around; 
            gap: 20px; 
        }
        
        .material-list .material-item {
            background-color: #ffffff !important; 
            border-left: 5px solid #e6e6fa; 
            transition: background-color 0.2s;
        }
        .material-list .material-item:hover {
            background-color: #fff9e6 !important; 
        }
        
        .steps-section .step-item {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important; 
            background-color: #ffffff !important; 
        }
        .steps-section .step-item:hover {
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important; 
        }

        .steps-section .step-title {
            position: relative;
            padding-left: 40px; 
            font-weight: 600;
        }
        .steps-section .step-title::before {
            content: counter(step-counter);
            counter-increment: step-counter;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 30px; 
            height: 30px;
            background-color: #4B338A; 
            color: #ffffff;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: 700;
            font-size: 1em;
            box-shadow: 0 2px 5px rgba(0,0,0,0.4); 
            border: 2px solid #ffffff; 
        }
        .step-list {
             counter-reset: step-counter; 
        }

        /* Dark Mode styles */
        body.dark-mode, body.dark-mode html {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode .content {
             background-color: #1e1e1e !important;
             color: #e0e0e0 !important;
        }
        body.dark-mode .tutorial-details {
             background-color: #2c2c2c !important;
        }
        body.dark-mode .metadata-box {
            background-color: #333333 !important;
            color: #e0e0e0;
        }
        body.dark-mode .metadata-box h3,
        body.dark-mode .metadata-box p {
            color: #e0e0e0 !important;
        }
        body.dark-mode .material-list .material-item,
        body.dark-mode .steps-section .step-item {
            background-color: #3a3a3a !important;
            color: #e0e0e0;
            border-left-color: darkslateblue !important;
        }
    </style>
</head>
<body> 

<div class="container">
    <div class="sidebar">
        <div class="logo">CraftyLab</div>
        <nav class="nav-menu">
            <a href="index.php" class="nav-item">Home</a> 
            <a href="paper.php" class="nav-item">Paper Crafts</a> 
            <a href="home_deco.php" class="nav-item">Home Decor</a> 
            <a href="diy.php" class="nav-item">DIY Gifts</a> 
            <a href="eco.php" class="nav-item">Eco Friendly</a>
            <a href="seasons.php" class="nav-item nav-active">Seasonal</a>

            <hr style="border: 0.1px solid rgba(255,255,255,0.1); margin: 15px 0;">

            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="nav-item" style="color: #ffcc00 !important;">
                    <i class="fas fa-user-shield"></i> Admin Panel
                </a>
            <?php endif; ?>

            <?php if(isset($_SESSION['username'])): ?>
                <div style="padding: 10px 20px; color: #cbd5e0; font-size: 0.85em;">
                    Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </div>
                <a href="main_logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="main_login.php" class="nav-item">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <main class="content" style="position: relative;">
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header" style="background-color: darkslateblue; padding: 40px 30px;">
            <h1 style="font-size: 2.5em; margin-bottom: 5px; color: #ffffff;">DIY Birthday Banner / Bunting</h1>
            <p style="font-size: 1.1em; opacity: 0.9; color: #f0f0f0;">Make your celebrations more special with a handmade, colorful birthday banner.</p>
        </header>
        
        <section class="tutorial-details" style="padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); margin-bottom: 40px;">
            
            <div class="featured-image" style="text-align: center; margin-bottom: 0; padding: 0; border-bottom: 1px solid #e0e0e0;">
                    <img src="sea_bunting.jpg" alt="Birthday Bunting" 
                            style="width: 300px; 
                                    height: 250px; 
                                    object-fit: cover; 
                                    border-radius: 12px; 
                                    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                                    margin: 10px auto 10px auto;
                                    display: block;">
            </div>
            
            <div class="metadata-box" style="background-color: #e6e6fa; padding: 18px; border-radius: 10px; margin-top: 0; margin-bottom: 30px; text-align: center;">
                <div>
                    <h3 style="color: #4B338A; margin-bottom: 5px; font-size: 1em;">TIME REQUIRED</h3>
                    <p style="font-weight: 700; color: #333; font-size: 1.1em;">25 Minutes</p>
                </div>
                <div>
                     <h3 style="color: #4B338A; margin-bottom: 5px; font-size: 1em;">DIFFICULTY</h3>
                    <p style="font-weight: 700; color: #333; font-size: 1.1em;">Easy</p>
                </div>
            </div>
            
            <div class="materials-section" style="margin-bottom: 40px;">
                <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-top: 0; font-weight: 600; font-size: 1.5em;">Materials Checklist</h2>
                <ul class="material-list" style="list-style-type: none; margin-left: 0; padding: 15px 0; font-size: 1.1em; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Colorful Cardstock or Chart Paper</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Satin Ribbon or Strong Thread</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Markers and Glitter Pens</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Glue and Scissors</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Hole Puncher</li>
                </ul>
            </div>

            <div class="steps-section" style="margin-bottom: 50px;">
                <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; font-weight: 600; font-size: 1.5em;">Step-by-Step Instructions</h2>
                <ol class="step-list">
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Designing the Banner Shapes</strong>
                        Cut out triangles, circles, or shield shapes from different colored papers. Make sure you have enough shapes for each letter of "HAPPY BIRTHDAY".
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Lettering and Decoration</strong>
                        Write one letter on each shape using a bold marker. You can also use glitter or cut-out letters from a contrasting color paper for a 3D effect.
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Punching and Stringing</strong>
                        Punch two holes at the top of each shape. Thread the satin ribbon through the holes, making sure the letters are in the correct order and evenly spaced.
                    </li>
                </ol>
            </div>
            
            <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-top: 40px; font-weight: 600; font-size: 1.5em;">Video Reference</h2>
            <div class="media-flex" style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 30px; align-items: flex-start; justify-content: center;">
                <div class="video-column" style="flex: 0 1 500px; max-width: 100%;">
                    <div class="video-wrapper" style="position: relative; width: 100%; padding-top: 56.25%;">
                        <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.15);" 
                                    src="https://www.youtube.com/embed/-Uyd358bggw" 
                                    frameborder="0" 
                                    allowfullscreen>
                        </iframe>
                    </div>
                    <p class="video-credit" style="font-size: 0.9em; margin-top: 10px; text-align: center; color: #555;">
                        Video Tutorial Credit: <a href="https://www.youtube.com/@NSCreativeCollections" target="_blank" style="color: darkslateblue; font-weight: 600; text-decoration: none;">NS Creative Collections</a>
                    </p>
                </div>
            </div>
        </section>

        <div class="copyright-footer">
            <p>&copy;<?php echo date("Y"); ?> CraftyLab | Learn & Create</p>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('theme-toggle');
        const icon = document.getElementById('toggle-icon');
        const body = document.body;
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
            icon.classList.replace('fa-moon', 'fa-sun');
        }
        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            icon.classList.replace(isDark ? 'fa-moon' : 'fa-sun', isDark ? 'fa-sun' : 'fa-moon');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });
</script>
</body>
</html>