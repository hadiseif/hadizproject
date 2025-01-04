<?php
session_start(); 


$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "maindb"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM playerinfo"; 
$result = $conn->query($sql);


$playersPerSlide = 3;
$players = [];

while ($row = $result->fetch_assoc()) {
    $players[] = $row; 
}

$numberOfItems = ceil(count($players) / $playersPerSlide); 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
          crossorigin="anonymous">
    <script src="main.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cabc4e8c2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<nav class="py-0 navbar navbar-expand-lg navbar-light bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample01"
                aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarExample01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
                <li class="nav-item active">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#video-section">Iconic Moments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#best-players">Our Players</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#aboutus">About Us</a>
                </li>

               
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admindb.php">Dashboard</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                
                <?php if (!isset($_SESSION['role'])): ?>
                   
                    <li class="nav-item">
                        <a class="btn btn-primary text-white px-3 py-1" href="index.php">Login</a>
                    </li>
                <?php else: ?>
                  
                    <li class="nav-item">
                        <a class="btn btn-danger text-white px-3 py-1" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section id="home">
    <div class="p-5 text-center bg-image"
         style="background-image: url('https://a.storyblok.com/f/112937/568x464/7dd062feb7/truth_english_football_hero.jpg'); height: 400px;">
        <div>
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-white">
                    <h1 class="mb-3"><b><u>Manchester United FC</u></b></h1>
                    <h4 class="mb-3"><b>WHERE THE LEGENDS BELONG</b></h4>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="hr" />


<section id="video-section" class="text-center my-5">
    <h2>Moments of Glory</h2>
    <iframe width="800" height="400"
            src="https://www.youtube.com/embed/bRluC_YfKkI?si=mBcF2AeB7Mtm0zOE"
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen></iframe>
</section>

<hr class="hr" />

<section id="best-players">

    <div id="carouselMultiItemExample" class="carousel slide carousel-dark text-center" data-bs-ride="carousel">
        <div class="d-flex justify-content-center mb-4">
            <button class="carousel-control-prev position-relative" type="button" data-bs-target="#carouselMultiItemExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next position-relative" type="button" data-bs-target="#carouselMultiItemExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="carousel-inner py-4">
            <?php
            $activeClass = 'active'; 
            for ($i = 0; $i < $numberOfItems; $i++) {
                echo '<div class="carousel-item ' . $activeClass . '">
                        <div class="container">
                            <div class="row">';
                
                for ($j = $i * $playersPerSlide; $j < min(($i + 1) * $playersPerSlide, count($players)); $j++) {
                    $player = $players[$j];
                    echo '<div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <img src="' . $player['image'] . '" class="card-img-top" alt="' . $player['pName'] . '" />
                                <div class="card-body">
                                    <h5 class="card-title">' . $player['pName'] . '</h5>
                                    <p class="card-text"><strong>Role:</strong> ' . $player['pRole'] . '</p>
                                    <p class="card-text"><strong>Player Number:</strong> ' . $player['ptnumber'] . '</p>
                                    <p class="card-text"><strong>Country:</strong> ' . $player['contry'] . '</p>
                                    <p class="card-text"><strong>Contract:</strong> ' . $player['Contract'] . '</p>
                                    <p class="card-text"><strong>Joined On:</strong> ' . $player['date'] . '</p>
                                </div>
                            </div>
                        </div>';
                }
                
                echo '</div></div></div>';
                $activeClass = ''; 
            }
            ?>
        </div>
    </div>

</section>

<hr class="hr" />


<section id="aboutus" class="py-5">
    <div class="container">
        <div class="row align-items-center gx-4">
            <div class="col-md-5">
                <div class="ms-md-2 ms-lg-5">
                    <img id="stadium" class="img-responsive"
                         src="https://i.ebayimg.com/images/g/oZ0AAOSwEEpiNh~t/s-l500.jpg">
                </div>
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="ms-md-2 ms-lg-5">
                    <span class="text-muted">Our Story</span>
                    <h2 class="display-5 fw-bold">About Us</h2>
                    <p class="lead">
                        Manchester United Football Club, founded in 1878 as Newton Heath, is one of the most successful
                        and iconic football clubs in the world...
                    </p>
                    <p class="lead mb-0">The goal of our team is to be the greatest team of all time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <footer class="bg-body-tertiary text-center">
        <div class="container p-4 pb-0">
            <section class="mb-4">
            
                <a class="btn text-white btn-floating m-1" style="background-color: #3b5998;" href="#!" role="button">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="btn text-white btn-floating m-1" style="background-color: #55acee;" href="#!" role="button">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39;" href="#!" role="button">
                    <i class="fab fa-google"></i>
                </a>
                <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac;" href="#!" role="button">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="btn text-white btn-floating m-1" style="background-color: #0082ca;" href="#!" role="button">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="btn text-white btn-floating m-1" style="background-color: #333333;" href="#!" role="button">
                    <i class="fab fa-github"></i>
                </a>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <a class="text-body">Manchester United</a>
        </div>
    </footer>
</div>

<script src="https://kit.fontawesome.com/cabc4e8c2b.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>
              