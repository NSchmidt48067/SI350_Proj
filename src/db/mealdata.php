<!-- 
Description: Server side code to return all meal data in JSON format from the mealdata.txt file
Creation Date: 13NOV2025
Author: Tristen Alvis
-->

<?php
    $datafile = fopen("mealdata.txt", "r");
    $data = fread($datafile, filesize("mealdata.txt"));
    fclose($datafile);
    echo json_encode($data);
?>