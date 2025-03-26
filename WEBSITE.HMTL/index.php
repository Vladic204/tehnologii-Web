<?php
session_start(); // Start the session

// Handle logout
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login_page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage Design</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .main-content {
            text-align: center;
            padding: 40px;
        }
        .title {
            font-size: 2.1em;
            color: #fbf6f6;
            margin-bottom: 5px;
        }
        .categories {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            margin-bottom: 400px;
        }
        .category {
            width: 200px;
            height: 300px;
            background: #cfc4c4;
            color: white;
            border-radius: 40px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s, width 0.3s, height 0.3s;
        }
        .category.search-result {
            width: 300px;
            height: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
        .image-container {
            width: 100%;
            height: 70%;
            position: relative;
        }
        .category.search-result .image-container {
            height: 80%;
        }
        .category img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 40px 40px 0 0;
        }
        .brand-info {
            width: 100%;
            height: 30%;
            background: #333;
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .category.search-result .brand-info {
            height: 20%;
            background: linear-gradient(180deg, #333, #1a1a1a);
        }
        .brand-info h3 {
            margin: 0;
            font-size: 1.2em;
            color: #d3d2e7;
            font-weight: bold;
        }
        .category.search-result .brand-info h3 {
            font-size: 1.5em;
        }
        .brand-info p {
            margin: 5px 0 0;
            font-size: 0.8em;
            color: #db0909;
        }
        .category.search-result .brand-info p {
            font-size: 1em;
        }
        .no-results {
            text-align: center;
            margin: 20px 0;
            color: #ccc1c1;
            font-size: 1.2em;
        }
        .services {
            margin-top: 40px;
        }
        .services h2 {
            font-size: 2em;
            color: #d8cfcf;
            margin-bottom: 20px;
        }
        .service-items {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .service-item {
            width: 200px;
            text-align: center;
        }
        .service-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .service-item p {
            margin: 10px 0 0;
            font-size: 1em;
            color: #d4cece;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .search-bar input {
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .search-bar button {
            padding: 8px 20px;
            background: linear-gradient(45deg, #4CAF50, #66BB6A);
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-bar button:hover {
            background: linear-gradient(45deg, #45a049, #5cb860);
        }
        .hidden {
            display: none;
        }
        /* Auth and button styles */
        .auth-buttons, .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 20px;
            background: linear-gradient(45deg, #4CAF50, #66BB6A);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: linear-gradient(45deg, #45a049, #5cb860);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        .btn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">VVBurlea007</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="categories.php">CATEGORIES</a></li>
                <li><a href="service.php">SERVICE</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Caută..." id="search-input">
            <button id="search-button">Caută</button>
        </div>
    </div>

    <div class="auth-buttons" style="<?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ? 'display: none;' : 'display: flex;'; ?>">
        <a href="login_page.php" class="btn">Logare</a>
        <a href="register.php" class="btn">Înregistrare</a>
    </div>
    <div class="logout-button" style="<?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ? 'display: flex;' : 'display: none;'; ?>">
        <a href="?logout=true" class="btn">Deconectare</a>
    </div>

    <div class="main-content">
        <h1 class="title">Primii din Moldova🌏</h1>
    
        <div class="categories">
            <div class="category" id="skoda">
                <div class="image-container">
                    <img src="images/octvv7.jpg" alt="Skoda">
                </div>
                <div class="brand-info">
                    <h3>Skoda</h3>
                    <p>Mașini economice și fiabile, perfecte pentru oraș și drum lung.</p>
                </div>
            </div>
            <div class="category" id="porsche">
                <div class="image-container">
                    <img src="images/porsche cayene.jpg" alt="Porsche">
                </div>
                <div class="brand-info">
                    <h3>Porsche</h3>
                    <p>Performanță de top și design sportiv pentru pasionații de viteză.</p>
                </div>
            </div>
            <div class="category" id="bmw">
                <div class="image-container">
                    <img src="images/m5.jpg" alt="BMW">
                </div>
                <div class="brand-info">
                    <h3>BMW</h3>
                    <p>Lux, tehnologie avansată și plăcerea de a conduce la superlativ.</p>
                </div>
            </div>
            <div class="category" id="bentley">
                <div class="image-container">
                    <img src="images/bentley.jpg" alt="Bentley">
                </div>
                <div class="brand-info">
                    <h3>Bentley</h3>
                    <p>Eleganță supremă și putere, un simbol al rafinamentului auto.</p>
                </div>
            </div>
            <div class="category" id="ferrari">
                <div class="image-container">
                    <img src="images/12fer.jpg" alt="Ferrari">
                </div>
                <div class="brand-info">
                    <h3>Ferrari</h3>
                    <p>Mașini perfecte pentru oraș și drum lung.</p>
                </div>
            </div>
            <div class="category" id="jaguar">
                <div class="image-container">
                    <img src="images/jaag2.jpg" alt="Jaguar">
                </div>
                <div class="brand-info">
                    <h3>Jaguar</h3>
                    <p>Performanță de top și design sportiv pentru pasionații de viteză.</p>
                </div>
            </div>
            <div class="category" id="rolls">
                <div class="image-container">
                    <img src="images/rolls.jpg" alt="Rolls">
                </div>
                <div class="brand-info">
                    <h3>Rolls Royce</h3>
                    <p>Lux, tehnologie avansată și plăcerea de a conduce la superlativ.</p>
                </div>
            </div>
            <div class="category" id="lamborghini">
                <div class="image-container">
                    <img src="images/urus.jpg" alt="Urus">
                </div>
                <div class="brand-info">
                    <h3>Lamborghini</h3>
                    <p>Eleganță supremă și putere, un simbol al rafinamentului auto.</p>
                </div>
            </div>
        </div>

        <div class="no-results" style="display: none;">
            <p>Nu s-au găsit rezultate pentru căutarea ta.</p>
        </div>

        <div class="services">
            <h2>Service va Ofera</h2>
            <div class="service-items">
                <div class="service-item">
                    <img src="images/sauto_new_logo_black.png" alt="Sales">
                    <p>Masini Noi</p>
                </div>
                <div class="service-item">
                    <img src="images/vag.jpg" alt="Service">
                    <p>Diagnostica si Reparatie</p>
                </div>
                <div class="service-item">
                    <img src="images/Nef2.jpeg" alt="Dealership">
                    <p>Salonul</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const categories = document.querySelectorAll('.category');
        const noResults = document.querySelector('.no-results');

        function performSearch() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            let hasResults = false;

            categories.forEach(category => {
                category.classList.add('hidden');
                category.classList.remove('search-result');
            });

            noResults.style.display = 'none';

            if (!searchTerm) {
                categories.forEach(category => {
                    category.classList.remove('hidden');
                });
                return;
            }

            categories.forEach(category => {
                const brandName = category.querySelector('h3').textContent.toLowerCase();
                if (brandName.includes(searchTerm)) {
                    category.classList.remove('hidden');
                    category.classList.add('search-result');
                    hasResults = true;
                }
            });

            if (!hasResults) {
                noResults.style.display = 'block';
            }
        }

        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });
    </script>
</body>
</html>