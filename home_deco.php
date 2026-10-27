<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftyLab - Home Decor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    
    <div class="sidebar">
        <div class="logo">CraftyLab</div>
        <nav class="nav-menu">
            <a href="index.php" class="nav-item">Home</a> 
            <a href="paper.php" class="nav-item">Paper Crafts</a> 
            <a href="home_deco.php" class="nav-item nav-active">Home Decor</a> 
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
    </div>

    <div class="content">
        
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header">
            <h1>Home Decor Tutorials</h1>
            <p>Transform your living space with creative DIY projects, from wall art to handmade furniture decor.</p>
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
                <input type="text" placeholder="Search HomeDecor projects..." id="search-input">
                <button>Search</button> 
            </div>
        </section>
        
        <section class="tutorial-list tutorial-container">
            
            <div id="no-results-message" style="display: none; text-align: center; padding: 50px; color: #555;">
                <h3>No matching decor ideas found.</h3> 
                <p>Please adjust your search or difficulty filters.</p>
            </div>
            
            <div class="carousel-wrapper">
                
                <button class="nav-arrow left-arrow" id="left-arrow">
                    <span class="arrow-icon"></span>
                </button>
                
                <div class="cards-grid" id="cards-grid"> 

                    <a href="icecream.php" class="card" data-difficulty="easy" data-title="Photo Frame With Ice-Cream Sticks">
                        <img src="icecream.jpeg" alt="Photo Frame">
                        <div class="card-content">
                            <div class="title">Photo Frame with Ice Cream Sticks</div>
                            <div class="text">Create a charming and colorful photo frame using simple wooden popsicle sticks.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="wallhanging.php" class="card" data-difficulty="easy" data-title="Wall Hanging Using Paper Rings">
                        <img src="paper_rings.jpeg" alt="Paper Rings">
                        <div class="card-content">
                            <div class="title">Wall Hanging using Paper Rings</div>
                            <div class="text">Interlock colorful paper rings to create a modern and lightweight 3D wall art.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="oldcd.php" class="card" data-difficulty="medium" data-title="Wind Chime With Old CDs">
                        <img src="oldcd.jpeg" alt="CD Wind Chime">
                        <div class="card-content">
                            <div class="title">Wind Chime with Old CDs</div>
                            <div class="text">Upcycle old CDs into a shimmering, musical wind chime that reflects beautiful light.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="butterfly.php" class="card" data-difficulty="medium" data-title="Paper Butterfly Wall Decor">
                        <img src="butterflies.jpg" alt="Paper Butterfly">
                        <div class="card-content">
                            <div class="title">Paper Butterfly Wall Decor</div>
                            <div class="text">Transform your wall with a swarm of realistic and elegant 3D paper butterflies.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="pot_painting.php" class="card" data-difficulty="easy" data-title="Flower Pot Painting">
                        <img src="pots.jpg" alt="Flower Pot">
                        <div class="card-content">
                            <div class="title">Flower Pot Painting</div>
                            <div class="text">Add a pop of color to your garden with unique patterns and acrylic paint designs.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="bottle_vase.php" class="card" data-difficulty="medium" data-title="Bottle Vase Decoration">
                        <img src="bottle.jpg" alt="Bottle Vase">
                        <div class="card-content">
                            <div class="title">Bottle Vase Decoration</div>
                            <div class="text">Turn empty glass bottles into stunning home centerpieces using twine or paint.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="mirror_decor.php" class="card" data-difficulty="hard" data-title="Decorative Mirror">
                        <img src="mirror.jpg" alt="Decorative Mirror">
                        <div class="card-content">
                            <div class="title">Decorative Mirror</div>
                            <div class="text">Enhance a plain mirror with an artistic frame for a professional home decor look.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="paper_flower_wall.php" class="card" data-difficulty="hard" data-title="Paper Flower Wall Decor">
                        <img src="paper_flowers.jpg" alt="Paper Flowers">
                        <div class="card-content">
                            <div class="title">Paper Flower Wall Decor</div>
                            <div class="text">Craft intricate and large-scale paper flowers to create a breathtaking floral wall.</div>
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
            <p>&copy;2025 CraftyLab | Home Decor Section</p>
        </div>

    </div>
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
        cardsToShow.forEach(card => {
            card.style.display = 'flex'; 
        });

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