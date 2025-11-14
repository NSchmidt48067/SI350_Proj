<!DOCTYPE html>

<?php
// make sure the user is logged in to access this page
session_start();

$_SESSION['loggedIn'] = true;

if($_SESSION['loggedIn']) {
    // echo 'Logged in';
    require('./db/meals.php');
} else {
    // echo 'Not logged in';
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// if it's a post, add the meal data
if ($method == 'POST') {
    // print_r($_POST);
    // tmp_name is where it's stored temporarily on the server on the upload
    $tmpPath = $_FILES['meal_pic']['tmp_name']; 
    
    if(is_uploaded_file($tmpPath)) {
        $contents = file_get_contents($tmpPath);
        // store the file in /imgs
        $path = './imgs/' . $_FILES['meal_pic']['name'];

        // could cause errors, should check them
        file_put_contents($path, $contents);

        /**
         * Need to save 
         * {
         *  name: "",
         *  description: "",
         *  imgsrc: "",
         * 
         * ( [meal_name] => denali [meal_date] => 2025-11-13 [rating] => 5 ) 
         * }
         * 
         * into the JSON object in mealdata
         */

        $name = $_POST['meal_name'];
        $date = $_POST['meal_date'];
        $rating = $_POST['rating'];
        $desc = $_POST['description'];

        meal_save($name, $desc, $path, $date, $rating);

        header('Location: index.html');
    }

    exit;
}

// if it's a get, return the below form
if($method == 'GET') {
    // do nothing
    // echo "<br>Getting form";
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate My Meal</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/styles.css">
    <script src="verify.js"></script>
</head>
<body>
    <!-- 
    Need to get:
    - Meal Name
    - Picture for the meal
    - Date it was last served on
    -->
    <h1>Add A Meal</h1>
    <form name="meal_form" action="./new_meal.php" method="POST" enctype="multipart/form-data" onsubmit="return verify(this)">
        <div class="container justify-content-center">
            <div class="row">
                <div class="col-sm">
                    <label for="meal_name">Meal Name:</label>
                </div>
                <div class="col-xl">
                    <input type="text" name="meal_name" id="meal_name">
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="description">Meal Description:</label>
                </div>
                <div class="col-xl">
                    <textarea name="description" id="description">Description of the meal...</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="meal_pic">Meal Picture:</label>
                </div>
                <div class="col-xl">
                    <input type="file" accept="image/*" name="meal_pic" id="meal_pic">
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="meal_date">Last Served On:</label>
                </div>
                <div class="col-xl">
                    <input type="date" name="meal_date" id="meal_date">
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="rating">Your Rating:</label>
                </div>
                <div class="col-xl">
                    <div class="star-rating animated-stars">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5" class="bi bi-star-fill"></label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" class="bi bi-star-fill"></label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" class="bi bi-star-fill"></label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" class="bi bi-star-fill"></label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" class="bi bi-star-fill"></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <input type="submit" value="Add Meal">
                </div>
            </div>
        </div>
    </form>

    <!-- star rating system -->
    <script src="stars.js"></script>

</body>
</html>