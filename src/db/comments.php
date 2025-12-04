<!-- 
Description: php code to send/receive comment data about meals
Creation Date: 14NOV2025
Author: George Prielipp
-->

<?php
    require('sqlitedb.php');
    
    function convertPost($obj) {
        // puts the Input data into the correct format I need for a query
        return [
            'mealid' => ['val' => intval($obj['mealid']), 'type' => SQLITE3_INTEGER], 
            'comment' => ['val' => $obj['comment'], 'type' => SQLITE3_TEXT], 
            'username' => ['val' => $obj['username'], 'type' => SQLITE3_TEXT],
        ];
    }

    //create the database if it doesn't exist
    create_if_no('comments.db', 'comments', ['uid' => 'INTEGER PRIMARY KEY AUTOINCREMENT', 'mealid' => 'INTEGER', 'comment' => 'TEXT NOT NULL', 'username' => 'TEXT NOT NULL']);

    // open the db
    $db = opendb('comments.db');

    if(!$db) {
        echo "Error opening database";
        exit;
    }

    // read from SQLite DB and get comments associated with meal (get; id=__)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $mealid = $_GET['id'];

        // perform the query
        $comments = query($db, 'comments', ["mealid" => ['val' => intval($mealid), 'type' => SQLITE3_INTEGER]]);

        // send the results back
        if(!$comments) {
            echo json_encode(['error' => "no comments in the DB match id '$mealid'"]);
        } else {
            echo json_encode(['comments' => $comments]);
        }
    }
    // or save them ... (post; {mealid:__, comment:__, username:__}) <-- DB will add uid
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get the data from the body of the post
        $data = json_decode(file_get_contents('php://input'), true);
        // put it into the database
        $result = insert($db, 'comments', convertPost($data));
        // send a quick message back
        $result[] = json_encode(['message' => 'success']);
        echo json_encode($result);
    }

    // make sure the database gets closed
    closedb($db);
?>