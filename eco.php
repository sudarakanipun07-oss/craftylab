<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftyLab - Eco Friendly</title>
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
            <a href="eco.php" class="nav-item nav-active">Eco Friendly</a>
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
        
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header">
            <h1>Eco-Friendly Creations</h1>
            <p>Upcycle waste materials into beautiful crafts and contribute to a greener planet with these sustainable DIY ideas.</p>
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
                <input type="text" placeholder="Search eco projects..." id="search-input">
                <button>Search</button> 
            </div>
        </section>
        
        <section class="tutorial-list tutorial-container">
            
            <div id="no-results-message" style="display: none; text-align: center; padding: 50px; color: #555;">
                <h3>No matching eco-friendly ideas found.</h3> 
                <p>Please adjust your search or difficulty filters.</p>
            </div>
            
            <div class="carousel-wrapper">
                
                <button class="nav-arrow left-arrow" id="left-arrow">
                    <span class="arrow-icon"></span>
                </button>
                
                <div class="cards-grid" id="cards-grid"> 

                    <a href="paperbag.php" class="card" data-difficulty="easy" data-title="Recycled Paper Bag">
                        <img src="eco_bag.jpg" alt="Recycled Paper Bag">
                        <div class="card-content">
                            <div class="title">Recycled Paper Bag</div>
                            <div class="text">Turn old newspapers or magazines into stylish and durable reusable gift bags.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="bottleplanter.php" class="card" data-difficulty="easy" data-title="Plastic Bottle Planter">
                        <img src="eco_planter.jpg" alt="Bottle Planter">
                        <div class="card-content">
                            <div class="title">Plastic Bottle Planter</div>
                            <div class="text">Upcycle empty plastic bottles into cute hanging planters for your indoor garden.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="coconut.php" class="card" data-difficulty="medium" data-title="Coconut Shell Bowl">
                        <img src="eco_coconut.jpg" alt="Coconut Bowl">
                        <div class="card-content">
                            <div class="title">Coconut Shell Bowl</div>
                            <div class="text">Smooth and polish discarded coconut shells to create natural, eco-friendly bowls.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="newspaper.php" class="card" data-difficulty="hard" data-title="Newspaper Wall Clock">
                        <img src="eco_clock.jpg" alt="Newspaper Clock">
                        <div class="card-content">
                            <div class="title">Newspaper Wall Clock</div>
                            <div class="text">Roll old newspapers into tubes to craft a unique and functional artistic wall clock.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="tin_holder.php" class="card" data-difficulty="easy" data-title="Tin Can Pen Holder">
                        <img src="eco_tin.jpg" alt="Tin Holder">
                        <div class="card-content">
                            <div class="title">Tin Can Pen Holder</div>
                            <div class="text">Transform metal food cans into decorated desk organizers using twine or paint.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="cardboard_box.php" class="card" data-difficulty="medium" data-title="Cardboard Organizer">
                        <img src="eco_cardboard.jpg" alt="Cardboard Organizer">
                        <div class="card-content">
                            <div class="title">Cardboard Organizer</div>
                            <div class="text">Reuse delivery boxes to create multi-compartment storage for your stationery.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
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
            <p>&copy;<?php echo date("Y"); ?> CraftyLab | Eco Friendly Section</p>
        </div>

    </main>
</div>

<script>
    // Javascript logic remains the same as your original
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