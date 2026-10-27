<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layered Hanging Lantern Tutorial - CraftyLab</title>
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
            cursor: default; 
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
        
        /* DARK MODE Styles */
        body.dark-mode, body.dark-mode html { background-color: #1e1e1e !important; color: #e0e0e0 !important; }
        body.dark-mode .content { background-color: #1e1e1e !important; color: #e0e0e0 !important; }
        body.dark-mode .tutorial-details { background-color: #2c2c2c !important; }
        body.dark-mode .metadata-box { background-color: #333333 !important; color: #e0e0e0; }
        body.dark-mode .metadata-box h3, body.dark-mode .metadata-box p { color: #e0e0e0 !important; }
        body.dark-mode .material-list .material-item, body.dark-mode .steps-section .step-item { background-color: #3a3a3a !important; color: #e0e0e0; border-left-color: darkslateblue !important; }
        body.dark-mode h1, body.dark-mode h2, body.dark-mode .section-title, body.dark-mode .media-heading { color: #ffffff !important; }
        body.dark-mode .nav-item.nav-active { background-color: #ffffff !important; color: darkslateblue !important; }
        body.dark-mode #theme-toggle { color: #4B338A !important; }
        body.dark-mode .logo, body.dark-mode .nav-item:not(.nav-active) { color: #f0f0f0; }
    </style>
</head>
<body> 

<div class="container">
    <aside class="sidebar">
        <div class="logo">CraftyLab</div>
        <nav class="nav-menu">
            <a href="index.php" class="nav-item">Home</a>
            <a href="paper.php" class="nav-item nav-active">Paper Crafts</a>
            <a href="home_deco.php" class="nav-item">Home Decor</a>
            <a href="diy.php" class="nav-item">DIY Gifts</a>
            <a href="eco.php" class="nav-item">Eco Friendly</a>
            <a href="seasons.php" class="nav-item">Seasonal</a>

            <hr style="border: 0.1px solid rgba(255,255,255,0.1); margin: 15px 0;">

            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="nav-item" style="color: #ffcc00 !important;">
                    <i class="fas fa-user-shield"></i> Admin Panel
                </a>
            <?php endif; ?>

            <?php if(isset($_SESSION['username'])): ?>
                <div style="padding: 10px 20px; color: #cbd5e0; font-size: 0.85em;">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
                <a href="main_logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php else: ?>
                <a href="main_login.php" class="nav-item"><i class="fas fa-sign-in-alt"></i> Login</a>
            <?php endif; ?>
        </nav>
    </aside>

    <main class="content" style="position: relative;">
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header" style="background-color: darkslateblue; padding: 40px 30px;">
            <h1 style="font-size: 2.5em; margin-bottom: 5px; color: #ffffff;">Layered Hanging Lantern</h1>
            <p style="font-size: 1.1em; opacity: 0.9; color: #f0f0f0;">Craft a beautiful, layered round paper lantern with decorative tassels, perfect for festive decor.</p>
        </header>
        
        <section class="tutorial-details" style="padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); margin-bottom: 40px;">
            <div class="featured-image" style="text-align: center; border-bottom: 1px solid #e0e0e0;">
                   <img src="lantern.jpg" alt="Finished Paper Lantern" style="max-width: 250px; width: 90%; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); margin: 5px auto 10px auto; display: block;">
            </div>
            
            <div class="metadata-box" style="background-color: #e6e6fa; padding: 18px; border-radius: 10px; margin-top: 0; margin-bottom: 30px; text-align: center;">
                <div><h3 style="color: #4B338A; margin-bottom: 5px; font-size: 1em;">TIME REQUIRED</h3><p style="font-weight: 700; color: #333; font-size: 1.1em;">30 - 45 Minutes</p></div>
                <div><h3 style="color: #4B338A; margin-bottom: 5px; font-size: 1em;">DIFFICULTY</h3><p style="font-weight: 700; color: #333; font-size: 1.1em;">Hard</p></div>
            </div>
            
            <div class="materials-section" style="margin-bottom: 40px;">
                <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Materials Checklist</h2>
                <ul class="material-list" style="list-style-type: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Cardstock (2-3 Colors)</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Scissors / Paper Cutter</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Strong Craft Glue</li>
                    <li class="material-item" style="padding: 12px; border-radius: 8px;">Ruler and Pencil</li>
                </ul>
            </div>
            
            <div class="steps-section" style="margin-bottom: 50px;">
                <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Step-by-Step Instructions</h2>
                
                

                <ol class="step-list">
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Prepare Paper Strips</strong>
                        Cut 10 to 12 identical strips (1 inch wide). Also cut two small circular pieces for the top and bottom base.
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Assemble the Base Layer</strong>
                        Glue one end of all strips to the bottom circular base, spacing them evenly like spokes of a wheel.
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Form the Sphere</strong>
                        Bend the loose ends upwards. Glue them to the top circular base piece to form the rounded sphere shape.
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Add Decorative Liner</strong>
                        Cut contrasting paper strips and weave or glue them inside/between the main strips for a layered look.
                    </li>
                    <li class="step-item" style="list-style: none; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #4B338A;">
                        <strong class="step-title" style="font-size: 1.3em; color: #4B338A; display: block; margin-bottom: 8px;">Attach Handle and Tassels</strong>
                        Glue a handle to the top. Group fine strips of paper together and glue them to the bottom as tassels.
                    </li>
                </ol>
            </div>

            <div class="video-section">
                <h2 class="section-title" style="color: #4B338A; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-top: 40px;">Video Reference</h2>
                <div class="media-flex" style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 30px; justify-content: center;">
                    <div class="video-column" style="flex: 0 1 600px; width: 100%;">
                        <div class="video-wrapper" style="position: relative; width: 100%; padding-top: 56.25%;">
                            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.15);" 
                                    src="https://www.youtube.com/embed/jZzCWvJk-F4" 
                                    frameborder="0" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                        <p style="font-size: 0.9em; margin-top: 10px; text-align: center; color: #555;">
                            Video Tutorial Credit: <a href="https://www.youtube.com/@CraftyPooh" target="_blank" style="color: darkslateblue; font-weight: 600; text-decoration: none;">Crafty Pooh</a>
                        </p>
                    </div>
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
        if (savedTheme === 'dark') { body.classList.add('dark-mode'); icon.classList.replace('fa-moon', 'fa-sun'); }
        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            icon.classList.toggle('fa-sun', isDark);
            icon.classList.toggle('fa-moon', !isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });
</script>
</body>
</html>