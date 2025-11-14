<?php
    $datafile = fopen("mealdata.txt", "r");
    $data = fread($datafile, filesize("mealdata.txt"));
    fclose($datafile);
    echo json_encode($data);
?>