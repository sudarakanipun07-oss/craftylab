<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftyLab - Seasonal Crafts</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    
    <aside class="sidebar">
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
    </aside>

    <main class="content">
        
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header">
            <h1>Seasonal & Festival Crafts</h1>
            <p>Celebrate every season and festival with these creative DIY decorations and handmade crafts.</p>
        </header>
        
        <section class="filter-section">
            <div class="filter-group">
                <label for="sort-by">Sort By:</label>
                <select id="sort-by">
                    <option value="newest">Newest</option>
                    <option value="easiest">Easiest</option>
                    <option value="popular">Popular</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="filter-difficulty">Difficulty:</label>
                <select id="filter-difficulty">
                    <option value="all">All Levels</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>

            <div class="search-group">
                <input type="text" placeholder="Search seasonal crafts..." id="search-input">
                <button>Search</button> 
            </div>
        </section>
        
        <section class="tutorial-list tutorial-container">
            
            <div id="no-results-message" style="display: none; text-align: center; padding: 50px; color: #555;">
                <h3>No matching seasonal ideas found.</h3> 
                <p>Please adjust your search or difficulty filters.</p>
            </div>
            
            <div class="carousel-wrapper">
                
                <button class="nav-arrow left-arrow" id="left-arrow">
                    <span class="arrow-icon"></span>
                </button>
                
                <div class="cards-grid" id="cards-grid"> 

                    <a href="handmade-lantern.php" class="card" data-difficulty="easy" data-title="Paper Lantern (Vesak/Diwali)">
                        <img src="sea_lantern.jpg" alt="Paper Lantern">
                        <div class="card-content">
                            <div class="title">Handmade Paper Lantern</div>
                            <div class="text">Create colorful and glowing paper lanterns for Vesak, Diwali, or any festive night.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="door.php" class="card" data-difficulty="medium" data-title="Christmas Door Wreath">
                        <img src="sea_wreath.jpg" alt="Christmas Wreath">
                        <div class="card-content">
                            <div class="title">Christmas Door Wreath</div>
                            <div class="text">Design a beautiful festive wreath using ribbons, pinecones, and greenery.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="greetingcard.php" class="card" data-difficulty="easy" data-title="New Year Greeting Card">
                        <img src="sea_nycard.jpg" alt="New Year Card">
                        <div class="card-content">
                            <div class="title">New Year Greeting Card</div>
                            <div class="text">Send your warm wishes with a personalized, glittery handmade New Year card.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="bunting.php" class="card" data-difficulty="easy" data-title="Birthday Party Bunting">
                        <img src="sea_bunting.jpg" alt="Party Bunting">
                        <div class="card-content">
                            <div class="title">Birthday Party Bunting</div>
                            <div class="text">Craft vibrant paper banners to make your birthday celebrations more colorful.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="avurudu_pots.php" class="card" data-difficulty="medium" data-title="Painted Avurudu Pots">
                        <img src="sea_pots.jpg" alt="Avurudu Pots">
                        <div class="card-content">
                            <div class="title">Painted Avurudu Pots</div>
                            <div class="text">Traditional clay pot painting with cultural patterns for Sinhala & Tamil New Year.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="snowflakes.php" class="card" data-difficulty="easy" data-title="3D Paper Snowflakes">
                        <img src="sea_snow.jpg" alt="Paper Snowflakes">
                        <div class="card-content">
                            <div class="title">3D Paper Snowflakes</div>
                            <div class="text">Decorate your home for the winter season with intricate 3D paper snowflakes.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="easter_eggs.php" class="card" data-difficulty="medium" data-title="Easter Egg Decoration">
                        <img src="sea_eggs.jpg" alt="Easter Eggs">
                        <div class="card-content">
                            <div class="title">Easter Egg Decoration</div>
                            <div class="text">Use natural dyes and creative patterns to decorate eggs for Easter Sunday.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="ornaments.php" class="card" data-difficulty="hard" data-title="Christmas Tree Ornaments">
                        <img src="sea_ornaments.jpg" alt="Tree Ornaments">
                        <div class="card-content">
                            <div class="title">Christmas Tree Ornaments</div>
                            <div class="text">Craft professional-looking hanging ornaments using felt, beads, and wire.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                </div>
                
                <button class="nav-arrow right-arrow" id="right-arrow">
                    <span class="arrow-icon"></span>
                </button>
                
            </div>
            
        </section>
        
        <div class="pagination-container">
            <div id="pagination-controls" class="pagination-controls"></div>
        </div>

        <div class="copyright-footer">
            <p>&copy;<?php echo date("Y"); ?> CraftyLab | Seasonal Section</p>
        </div>

    </main>
</div>

<script>
    const allCards = document.querySelectorAll('.card'); 
    const filterDifficulty = document.getElementById('filter-difficulty');
    const searchInput = document.getElementById('search-input');
    const noResultsMessage = document.getElementById('no-results-message'); 
    const cardsGrid = document.getElementById('cards-grid'); 
    const leftArrow = document.getElementById('left-arrow');      
    const rightArrow = document.getElementById('right-arrow');      
    const paginationControls = document.getElementById('pagination-controls');
    
    const CARDS_PER_PAGE = 4; 
    let currentPage = 1;
    const scrollAmount = 1100; 

    leftArrow.addEventListener('click', () => {
        cardsGrid.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        checkScrollPosition();
    });

    rightArrow.addEventListener('click', () => {
        cardsGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        checkScrollPosition();
    });

    function checkScrollPosition() {
        const currentCards = Array.from(cardsGrid.querySelectorAll('.card:not([style*="display: none"])'));
        if (currentCards.length <= 4) { 
            leftArrow.style.display = 'none';
            rightArrow.style.display = 'none';
            return;
        }
        const maxScroll = cardsGrid.scrollWidth - cardsGrid.clientWidth;
        leftArrow.style.display = cardsGrid.scrollLeft === 0 ? 'none' : 'flex';
        rightArrow.style.display = cardsGrid.scrollLeft >= maxScroll - 5 ? 'none' : 'flex';
    }

    function displayPage(pageNumber, filteredCards) {
        const startIndex = (pageNumber - 1) * CARDS_PER_PAGE;
        const endIndex = startIndex + CARDS_PER_PAGE;
        allCards.forEach(card => card.style.display = 'none');
        const cardsToShow = filteredCards.slice(startIndex, endIndex);
        cardsToShow.forEach(card => card.style.display = 'flex');
        currentPage = pageNumber;
        renderPaginationControls(filteredCards.length);
        cardsGrid.scrollLeft = 0; 
        checkScrollPosition();
    }

    function renderPaginationControls(totalCards) {
        paginationControls.innerHTML = '';
        const pageCount = Math.ceil(totalCards / CARDS_PER_PAGE);
        if (pageCount <= 1) {
            paginationControls.style.display = 'none';
            return;
        }
        paginationControls.style.display = 'flex'; 
        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.classList.add('page-button');
            if (i === currentPage) button.classList.add('active');
            button.addEventListener('click', () => applyFilters(i));
            paginationControls.appendChild(button);
        }
    }

    function applyFilters(page = 1) {
        const selectedDifficulty = filterDifficulty.value;
        const searchTerm = searchInput.value.toLowerCase();
        const matchingCards = []; 

        allCards.forEach(card => {
            const cardDifficulty = card.getAttribute('data-difficulty');
            const cardTitle = card.getAttribute('data-title').toLowerCase();
            const difficultyMatch = (selectedDifficulty === 'all' || cardDifficulty === selectedDifficulty);
            const searchMatch = cardTitle.includes(searchTerm);
            if (difficultyMatch && searchMatch) matchingCards.push(card); 
        });

        if (matchingCards.length === 0) {
            noResultsMessage.style.display = 'block';
            cardsGrid.style.display = 'none'; 
            paginationControls.style.display = 'none'; 
            leftArrow.style.display = 'none'; 
            rightArrow.style.display = 'none';
        } else {
            noResultsMessage.style.display = 'none';
            cardsGrid.style.display = 'flex'; 
            displayPage(page, matchingCards);
        }
    }

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
            icon.classList.toggle('fa-sun', isDark);
            icon.classList.toggle('fa-moon', !isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });

        cardsGrid.addEventListener('scroll', checkScrollPosition); 
        window.addEventListener('resize', checkScrollPosition); 
        applyFilters(1); 
    });

    filterDifficulty.addEventListener('change', () => applyFilters(1)); 
    searchInput.addEventListener('input', () => applyFilters(1)); 
</script>

</body>
</html>
