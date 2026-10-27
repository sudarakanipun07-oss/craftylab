<?php
session_start(); 
include 'db_config.php';

$feedback_message = "";


if(isset($_POST['btn_submit'])) {
   
    if(isset($_SESSION['username']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
        
        $name = mysqli_real_escape_string($conn, $_POST['u_name']);
        $email = mysqli_real_escape_string($conn, $_POST['u_email']);
        $message = mysqli_real_escape_string($conn, $_POST['u_msg']);

        $sql = "INSERT INTO user_feedback (name, email, message) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            $feedback_message = "Thank you! Your feedback has been saved.";


            $to = "dehemiegodagamagedara@gmail.com"; 
            $subject = "CraftyLab: New Feedback from " . $name;
            
            $email_body = "You have received a new feedback entry from CraftyLab.\n\n".
                          "--- Details ---\n".
                          "Name: $name\n".
                          "Email: $email\n\n".
                          "Message:\n$message\n".
                          "---------------\n";
            
            $headers = "From: feedback@craftylab.com" . "\r\n" .
                       "Reply-To: " . $email . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            @mail($to, $subject, $email_body, $headers);
        }
    }
}

$craft_facts = array(
    "Did you know: Origami literally means 'folding paper'.",
    "Did you know: Felt is one of the oldest known textiles, dating back to 6000 BC.",
    "Did you know: DIY gained massive popularity in the 1950s for home improvement.",
    "Did you know: The world's largest crochet blanket was over 13,000 square feet!",
    "Did you know: Knitting was once a male-dominated profession in the 16th century."
);
$facts_json = json_encode($craft_facts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftyLab - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --box-bg: darkslateblue;
            --input-bg: rgba(255, 255, 255, 0.15);
            --input-border: rgba(255, 255, 255, 0.3);
        }

        /* Fact Section Styling */
        .random-fact-section {
            background: rgba(72, 61, 139, 0.1);
            border-left: 5px solid darkslateblue;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .fact-text {
            font-style: italic;
            color: darkslateblue;
            font-weight: 600;
            transition: opacity 0.5s ease;
        }

        .dark-mode .fact-text { color: #ffffff !important; }

        /* Content Boxes */
        .content-box {
            background: var(--box-bg) !important;
            border: 1px solid var(--input-border);
            padding: 25px !important;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            min-height: 260px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .about-text {
            color: #ffffff !important;
            font-size: 0.95rem; 
            line-height: 1.8; 
            text-align: justify;
            letter-spacing: 0.3px; 
            font-weight: 400;
        }

        .contact-info-list li, #my-email { 
            color: #ffffff !important; 
            font-size: 0.9rem;
        }

        #my-email {
            cursor: pointer;
            border-bottom: 1px dashed rgba(255,255,255,0.5);
        }

        #copy-status {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: darkslateblue;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            display: none;
            z-index: 1000;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* Form Styling */
        .feedback-form input, .feedback-form textarea {
            width: 100%; padding: 10px; margin-bottom: 8px; border-radius: 8px;
            border: 1px solid var(--input-border); background: var(--input-bg);
            color: white !important; outline: none;
        }
        .feedback-form input::placeholder, .feedback-form textarea::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .feedback-btn {
            background-color: #ffffff; color: darkslateblue; padding: 10px;
            border-radius: 50px; font-weight: 700; width: 100%; border: none; cursor: pointer;
            transition: transform 0.2s;
        }
        .feedback-btn:hover { transform: scale(1.02); }

        .info-sections h2 { color: darkslateblue; margin-bottom: 10px; font-weight: 700; }
        .dark-mode .info-sections h2 { color: #ffffff; }

        /* Dark Mode Global Overrides */
        body.dark-mode { background-color: #1e1e1e !important; color: #e0e0e0 !important; }
        body.dark-mode .content { background-color: #1e1e1e !important; }
        body.dark-mode .random-fact-section { background: rgba(255, 255, 255, 0.05); }
    </style>
</head>

<body class="body-index">
    <div id="copy-status"><i class="fas fa-check-circle"></i> Email Copied!</div>

    <div class="container">
        <aside class="sidebar">
            <div class="logo">CraftyLab</div>
            <nav class="nav-menu">
                <a href="index.php" class="nav-item nav-active">Home</a>
                <a href="paper.php" class="nav-item">Paper Crafts</a>
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
        </aside>

        <main class="content">
            <div id="theme-toggle"><i class="fas fa-moon" id="toggle-icon"></i></div>
            
            <header class="hero-section">
                <h1 class="hero-title">Welcome to CraftyLab!</h1>
            </header>

            <section class="random-fact-section">
                <p id="fact-display" class="fact-text">Loading craft inspiration...</p>
            </section>
            
            <div class="info-sections" style="display: flex; flex-wrap: wrap; gap: 25px; padding: 20px;">
                <div class="about-section" style="flex: 1; min-width: 300px;">
                    <h2>Our Vision</h2>
                    <div class="content-box">
                        <p class="about-text">
                            At CraftyLab, we are committed to inspiring the artist within you. Our mission is to build a refined sanctuary where imagination meets craftsmanship, enabling you to transform simple, everyday materials into stunning handmade masterpieces. By promoting sustainable and eco-friendly creativity, we aim to lead a movement that values innovation, precision, and the unique elegance of artisan excellence.
                        </p>
                    </div>
                </div>
                
                <div class="contact-section" style="flex: 1; min-width: 300px;">
                    <h2>Connect & Collaborate</h2>
                    <div class="content-box">
                        <ul class="contact-info-list" style="list-style: none; padding: 0; margin-bottom: 15px;">
                            <li style="margin-bottom: 10px;"><i class="fas fa-envelope"></i> <span id="my-email" onclick="copyEmail()">dehemiegodagamagedara@gmail.com</span></li>
                            <li><i class="fab fa-facebook-f"></i> <a href="https://www.facebook.com/share/1DX5SkjJUE/" target="_blank" style="color: white; text-decoration: none;">Connect with me on Facebook</a></li>
                        </ul>
                        
                        <?php if($feedback_message != ""): ?>
                            <p style="color: #a7f3d0; font-size: 0.85rem; margin-bottom: 10px; font-weight: 600;"><i class="fas fa-check"></i> <?php echo $feedback_message; ?></p>
                        <?php endif; ?>

                        <?php 
                            
                            if(isset($_SESSION['username']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')): 
                        ?>
                            <form action="index.php" method="POST" class="feedback-form">
                                <input type="text" name="u_name" placeholder="Full Name" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                                <input type="email" name="u_email" placeholder="Email Address" required>
                                <textarea name="u_msg" placeholder="Tell us how we can inspire you..." rows="2" required></textarea>
                                <button type="submit" name="btn_submit" class="feedback-btn">SUBMIT FEEDBACK</button>
                            </form>

                        <?php 

                            elseif(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): 
                        ?>
                            <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; border: 1px solid gold;">
                                <i class="fas fa-user-shield" style="color: gold; margin-bottom: 10px; font-size: 1.5rem;"></i>
                                <p style="color: #fff; font-size: 0.85rem;">You are logged in as <strong>Admin</strong>. <br>Feedback form is disabled for your account.</p>
                                <a href="admin_feedback.php" style="margin-top:15px; display:inline-block; color: gold; text-decoration:none; font-size:0.9rem; font-weight:600; border: 1px solid gold; padding: 5px 15px; border-radius: 50px;">View User Feedbacks →</a>
                            </div>

                        <?php 
                      
                            else: 
                        ?>
                            <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; border: 1px dashed rgba(255,255,255,0.3);">
                                <i class="fas fa-lock" style="color: #fff; margin-bottom: 10px; font-size: 1.2rem;"></i>
                                <p style="color: #fff; font-size: 0.85rem; margin-bottom: 12px;">Please login to share your feedback with us.</p>
                                <a href="main_login.php" style="background: white; color: darkslateblue; padding: 8px 20px; border-radius: 50px; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-block;">LOGIN NOW</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main> 
    </div> 

    <script>
        // Theme Management
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

        // Random Facts Logic
        const facts = <?php echo $facts_json; ?>;
        const factDisplay = document.getElementById('fact-display');
        let currentFactIndex = 0;

        function updateFact() {
            if (!factDisplay) return;
            factDisplay.style.opacity = 0;
            setTimeout(() => {
                factDisplay.textContent = facts[currentFactIndex];
                factDisplay.style.opacity = 1;
                currentFactIndex = (currentFactIndex + 1) % facts.length;
            }, 500);
        }
        updateFact();
        setInterval(updateFact, 5000);

        // Clipboard Feature
        function copyEmail() {
            navigator.clipboard.writeText("dehemiegodagamagedara@gmail.com").then(() => {
                const popup = document.getElementById('copy-status');
                popup.style.display = 'block';
                setTimeout(() => { popup.style.display = 'none'; }, 2500);
            });
        }
    </script>
</body>
</html>