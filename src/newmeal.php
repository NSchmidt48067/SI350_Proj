<?php
    $file = fopen("mealdata.txt", "a");

    // $name = $_POST['name'];
    // $description = $_POST['description'];
    // $imgsrc = $_POST['imgsrc'];

    // $meal = array(
    //     'name' => $name,
    //     'description' => $description,
    //     'imgsrc' => $imgsrc
    // );

    $json_str = json_encode($meal);

    fwrite($file, $json_str);
    fclose($file);
?>