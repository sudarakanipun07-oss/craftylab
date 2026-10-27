<?php
session_start();
include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftyLab - Paper Crafts</title>
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
            
            <a href="paper.php" class="nav-item nav-active">Paper Crafts </a> 
            
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

    </div>

    <div class="content">
        
        <div id="theme-toggle">
            <i class="fas fa-moon" id="toggle-icon"></i>
        </div>
        
        <header class="page-header">
            <h1>Paper Crafts & Tutorials</h1>
            <p>Dive into the world of paper: origami, card making, paper mache, and more!</p>
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
                <input type="text" placeholder="Search PaperCraft projects..." id="search-input">
                <button>Search</button> </div>
        </section>
        
        <section class="tutorial-list tutorial-container">
            
            <div id="no-results-message" style="display: none; text-align: center; padding: 50px; color: #555;">
                <h3>No matching crafts found.</h3> <p>Please adjust your search or difficulty filters.</p>
            </div>
            
            <div class="carousel-wrapper">
                
                <button class="nav-arrow left-arrow" id="left-arrow">
                    <span class="arrow-icon"></span>
                </button>
                
                <div class="cards-grid" id="cards-grid"> 

                    <a href="paper_fan.php" class="card" data-difficulty="easy" data-title="Paper Fan">
                        <img src="pfan.jpg" alt="Paper Fan">
                        <div class="card-content">
                            <div class="title">Paper Fan</div>
                            <div class="text">Learn how to make a pretty paper fan step by step.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="paper_flower.php" class="card" data-difficulty="medium" data-title="Paper Flower">
                        <img src="flower.jpg" alt="Paper Flower">
                        <div class="card-content">
                            <div class="title">Paper Flower</div>
                            <div class="text">Learn how to make a realistic paper flower step by step.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="paper_boat.php" class="card" data-difficulty="easy" data-title="Paper Boat">
                        <img src="boat.jpg" alt="Paper Boat">
                        <div class="card-content">
                            <div class="title">Paper Boat</div>
                            <div class="text">Learn how to make a pretty paper boat step by step.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="paper_lantern.php" class="card" data-difficulty="hard" data-title="Paper Lantern">
                        <img src="lantern.jpg" alt="Paper Lantern">
                        <div class="card-content">
                            <div class="title">Paper Lantern</div>
                            <div class="text">Learn how to make a beautiful, intricate paper lantern.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="paper_mache_bowl.php" class="card" data-difficulty="hard" data-title="Paper Mache Bowl">
                        <img src="mache.png" alt="Paper Mache Bowl">
                        <div class="card-content">
                            <div class="title">Paper Mache Bowl</div>
                            <div class="text">Craft a decorative and durable bowl using simple paper and glue.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="origami_crane.php" class="card" data-difficulty="medium" data-title="Origami Crane">
                        <img src="origami.png" alt="Origami Crane">
                        <div class="card-content">
                            <div class="title">Origami Crane</div>
                            <div class="text">The classic origami project, detailed steps for beginners and experts.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="quilled_card.php" class="card" data-difficulty="easy" data-title="Quilled Card">
                        <img src="quilling.png" alt="Quilled Card">
                        <div class="card-content">
                            <div class="title">Quilled GreetingCard</div>
                            <div class="text">Add elegant rolled paper designs to any greeting card.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="modular_star.php" class="card" data-difficulty="hard" data-title="Modular Star">
                        <img src="star.png" alt="Modular Origami Star">
                        <div class="card-content">
                            <div class="title">Modular Origami Star</div>
                            <div class="text">Create a complex 3D star from multiple paper units.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="diy_envelope.php" class="card" data-difficulty="easy" data-title="Envelope Making">
                        <img src="envelope.png" alt="Envelope Making">
                        <div class="card-content">
                            <div class="title">DIY Envelope</div>
                            <div class="text">Quick and easy tutorial for folding custom envelopes.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="paper_strip_art.php" class="card" data-difficulty="medium" data-title="Paper Strip Art">
                        <img src="strip_art.png" alt="Paper Strip Art">
                        <div class="card-content">
                            <div class="title">Paper Strip Art</div>
                            <div class="text">Abstract wall art created by layering colored paper strips.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="paper_cube.php" class="card" data-difficulty="medium" data-title="3D Paper Cube">
                        <img src="cube.png" alt="3D Paper Cube">
                        <div class="card-content">
                            <div class="title">3D Paper Cube</div>
                            <div class="text">Step-by-step guide to folding a perfect paper cube.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="weaving_placemat.php" class="card" data-difficulty="easy" data-title="Weaving Placemat">
                        <img src="weaving.png" alt="Paper Weaving Placemat">
                        <div class="card-content">
                            <div class="title">Paper Weaving Placemat</div>
                            <div class="text">Simple weaving technique for colorful placemats.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="popup_card.php" class="card" data-difficulty="hard" data-title="Pop-up Card">
                        <img src="popup.png" alt="Kirigami Pop-up Card">
                        <div class="card-content">
                            <div class="title">Kirigami Pop-up Card</div>
                            <div class="text">Advanced cutting and folding for amazing 3D cards.</div>
                            <div class="difficulty-rating hard">★★★ Hard</div>
                        </div>
                    </a>

                    <a href="doll_chain.php" class="card" data-difficulty="easy" data-title="Doll Chain">
                        <img src="doll_chain.png" alt="Paper Doll Chain">
                        <div class="card-content">
                            <div class="title">Paper Doll Chain</div>
                            <div class="text">Fun and quick craft for kids: connected paper dolls.</div>
                            <div class="difficulty-rating easy">★☆☆ Easy</div>
                        </div>
                    </a>

                    <a href="paper_plate_mask.php" class="card" data-difficulty="medium" data-title="Paper Plate Mask">
                        <img src="mask.png" alt="Paper Plate Mask">
                        <div class="card-content">
                            <div class="title">Paper Plate Mask</div>
                            <div class="text">Creative animal masks using simple paper plates.</div>
                            <div class="difficulty-rating medium">★★☆ Medium</div>
                        </div>
                    </a>

                    <a href="newspaper_coasters.php" class="card" data-difficulty="hard" data-title="Newspaper Coasters">
                        <img src="coaster.png" alt="Newspaper Coasters">
                        <div class="card-content">
                            <div class="title">Newspaper Coasters</div>
                            <div class="text">Rolling and gluing newspaper strips for durable coasters.</div>
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
            <div id="pagination-controls" class="pagination-controls">
                </div>
        </div>

        
        <div class="copyright-footer">
            <p>&copy;2026 CraftyLab | Paper Crafts section </p>
        </div>

    </div>
</div>

<script>
    // 1. Select required HTML Elements
    const allCards = document.querySelectorAll('.card'); 
    const filterDifficulty = document.getElementById('filter-difficulty');
    const searchInput = document.getElementById('search-input');
    const noResultsMessage = document.getElementById('no-results-message'); 
    
    const cardsGrid = document.getElementById('cards-grid'); 
    const leftArrow = document.getElementById('left-arrow');     
    const rightArrow = document.getElementById('right-arrow');     
    
    // Elements for PAGINATION
    const paginationControls = document.getElementById('pagination-controls');
    
    // Constants for PAGINATION
    const CARDS_PER_PAGE = 4; // Number of cards to show per page
    let currentPage = 1;

    // ------------------------------------------
    // A. SLIDER / CAROUSEL FUNCTIONALITY 
    // ------------------------------------------
    
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
        // Count only the cards visible in the current filter/page
        const currentCards = Array.from(cardsGrid.querySelectorAll('.card:not([style*="display: none"])'));
        
        // Hide arrows if there are 4 or fewer cards
        if (currentCards.length <= 4) { 
            leftArrow.style.display = 'none';
            rightArrow.style.display = 'none';
            return;
        }

        const maxScroll = cardsGrid.scrollWidth - cardsGrid.clientWidth;
        
        if (cardsGrid.scrollLeft === 0) {
            leftArrow.style.display = 'none';
        } else {
            leftArrow.style.display = 'flex';
        }

        if (cardsGrid.scrollLeft >= maxScroll - 5) { 
            rightArrow.style.display = 'none';
        } else {
            rightArrow.style.display = 'flex';
        }
    }

    // ------------------------------------------
    // B. PAGINATION FUNCTIONALITY (Updated for <a> tags)
    // ------------------------------------------

    function displayPage(pageNumber, filteredCards) {
        const startIndex = (pageNumber - 1) * CARDS_PER_PAGE;
        const endIndex = startIndex + CARDS_PER_PAGE;

        // Hide all cards 
        allCards.forEach(card => card.style.display = 'none');

        // Show only the cards for the current page
        const cardsToShow = filteredCards.slice(startIndex, endIndex);

        cardsToShow.forEach(card => {
            // *** UPDATED: Changed 'block' to 'flex' as .card is now an <a> tag (Step 2 Complete) ***
            card.style.display = 'flex'; 
        });

        // Update current page
        currentPage = pageNumber;
        
        // Update Pagination Controls
        renderPaginationControls(filteredCards.length);
        
        // Reset scroll position and check arrows
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
            if (i === currentPage) {
                button.classList.add('active');
            }
            
            button.addEventListener('click', () => {
                applyFilters(i); // Re-run filter with new page number
            });

            paginationControls.appendChild(button);
        }
    }

    // ------------------------------------------
    // C. FILTER / SEARCH FUNCTIONALITY 
    // ------------------------------------------

    function applyFilters(page = 1) {
        const selectedDifficulty = filterDifficulty.value;
        const searchTerm = searchInput.value.toLowerCase();
        
        const matchingCards = []; 

        allCards.forEach(card => {
            const cardDifficulty = card.getAttribute('data-difficulty');
            const cardTitle = card.getAttribute('data-title').toLowerCase();
            
            const difficultyMatch = (selectedDifficulty === 'all' || cardDifficulty === selectedDifficulty);
            const searchMatch = cardTitle.includes(searchTerm);
            
            if (difficultyMatch && searchMatch) {
                matchingCards.push(card); 
            }
        });

        // Show or hide No Results Message
        if (matchingCards.length === 0) {
            noResultsMessage.style.display = 'block';
            cardsGrid.style.display = 'none'; 
            paginationControls.style.display = 'none'; 
            leftArrow.style.display = 'none'; 
            rightArrow.style.display = 'none';
        } else {
            noResultsMessage.style.display = 'none';
            cardsGrid.style.display = 'flex'; 
            
            // Display cards using Pagination
            displayPage(page, matchingCards);
        }
    }

    // ------------------------------------------
    // D. Dark Mode Logic Added
    // ------------------------------------------
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('theme-toggle');
        const icon = document.getElementById('toggle-icon');
        const body = document.body;
        
        // Saved theme එක load කිරීම
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.add('fa-moon');
            icon.classList.remove('fa-sun');
        }

        toggleButton.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon'); 
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun'); 
                localStorage.setItem('theme', 'dark');
            }
        });

        // Initial check for scroll and filters
        cardsGrid.addEventListener('scroll', checkScrollPosition); 
        window.addEventListener('resize', checkScrollPosition); 
        applyFilters(1); 
    });


    // 7. Event Listeners
    filterDifficulty.addEventListener('change', () => applyFilters(1)); 
    searchInput.addEventListener('input', () => applyFilters(1)); 
    
    
</script>

</body>
</html>