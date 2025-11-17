<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate My Meal -- Homepage</title>
    <!-- Bootstrap css/js links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- below is the link to the bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- js -->
    <!-- need to disable commenting if the user is not logged in -->
    <script src="js/loadcards.js"></script>
  </head>

  <body>
    <!-- NAV bar that resembles George's graphic design -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
      <!-- Left side of nav bar -->
      <ul class="navbar-nav"> 
        <!-- more options button: TODO: add something for it... -->
        <button type="button" class="btn">
          <i class="bi bi-grid-3x3-gap-fill"></i>
        </button>
        <!-- Search button: TODO: add search functionality -->
        <button type="button" class="btn">
          <i class="bi bi-search"></i>
        </button> 
      </ul>
      <!-- Center/Title of nav bar -->
      <a class="navbar-brand mx-auto" href="index.html">Rate My Meal</a>
      <!-- Right Side of nav bar -->
      <ul class="navbar-nav">
        <!-- Dropdown button -->
        <div class="btn-group">
          <button type="button" class="btn" id="dropDownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            <i class="bi bi-list"></i>
          </button>
          <!-- Dropdown Menu: options to add meal and ... -->
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropDownMenu">
            <li><a class="dropdown-item" href="#">Suggest Meal</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">TODO</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">TODO</a></li>
          </ul>
        </div>
        <!-- profile/login button -->
        <a href="login.html">
          <button type="button" class="btn">
            <i class="bi bi-person-circle"></i>
          </button> 
        </a> 
      </ul>
    </nav>

    <!-- Use AJAX and PHP script to dynamically load meal cards -->
    <div class="container" id="card-container">
      <!-- <script type="module" src="loadIndex.js"></script> -->
    </div>

    <!-- check if the user is logged in before displaying this -->
    <i id='add_meal' class="bi bi-plus-square-fill f-bottom-right btn btn-success">
      <script>
        $('#add_meal').mouseover(function () {
          $(this).text('   Add a meal');
        }).mouseout(function () {
          $(this).text('');
        }).click(function () {
          window.location = './new_meal.php';
        });
      </script>
    </i>


  </body>
</html>