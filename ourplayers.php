<?php
session_start(); 


include('config.php'); 


$sql = "SELECT * FROM playerinfo"; 
$result = $conn->query($sql);

$players = [];
while ($row = $result->fetch_assoc()) {
    $players[] = $row; 
}


$playersPerSlide = 3;  
$numberOfItems = ceil(count($players) / $playersPerSlide);  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Players</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cabc4e8c2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        .card-img-top {
            height: 200px; 
            object-fit: cover; 
            width: 100%; 
            margin: 0 auto; 
        }
    </style>
</head>
<body>

<h1>Our Players in This Team</h1>
<div>

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
  
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php

$conn->close();
?>
