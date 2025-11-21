<?php
    // save a meal
    function meal_save($name, $desc, $imgpath, $dateServed, $rating) {
        // read the data
        $data = meal_read();
        // add the new meal
        echo gettype($data);
        $data[] = [
            'name' => $name, 
            'description' => $desc,
            'imgsrc' => $imgpath,
            'dateServed' => $dateServed,
            'rating' => $rating,
            'id' => count($data),
        ];
        // write the data
        meal_write($data);
    }
    // read a meal from the file
    function meal_read() {
        $file = fopen('./db/mealdata.txt', 'r');
        if(!$file) {
            echo "failed to open mealdata.txt for reading";
            exit;
        }

        $data = json_decode( fread($file, filesize('./db/mealdata.txt')) );
        fclose($file);

        return $data;
    }
    // write a meal to the file
    function meal_write($data) {
        $file = fopen('./db/mealdata.txt', 'w');
        if(!$file) {
            echo "failed to open mealdata.txt for writing";
            exit;
        }

        $jsonstr = json_encode($data);
        fwrite($file, $jsonstr);
        fclose($file);
    }
?>