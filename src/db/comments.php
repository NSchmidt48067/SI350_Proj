<?php
    require('sqlitedb.php');
    
    function convertPost($obj) {
        return [
            'mealid' => ['val' => intval($obj['mealid']), 'type' => SQLITE3_INTEGER], 
            'comment' => ['val' => $obj['comment'], 'type' => SQLITE3_TEXT], 
            'username' => ['val' => $obj['username'], 'type' => SQLITE3_TEXT],
        ];
    }

    create_if_no('comments.db', 'comments', ['uid' => 'INTEGER PRIMARY KEY AUTOINCREMENT', 'mealid' => 'INTEGER', 'comment' => 'TEXT NOT NULL', 'username' => 'TEXT NOT NULL']);

    $db = opendb('comments.db');

    if(!$db) {
        echo "Error opening database";
        exit;
    }

    // read from SQLite DB and get comments associated with meal (get; id=__)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $mealid = $_GET['id'];

        $comments = query($db, 'comments', ["mealid" => ['val' => intval($mealid), 'type' => SQLITE3_INTEGER]]);

        if(!$comments) {
            echo json_encode(['error' => "no comments in the DB match id '$mealid'"]);
        } else {
            echo json_encode(['comments' => $comments]);
        }
    }
    // or save them ... (post; {mealid:__, comment:__, username:__}) <-- DB will add uid
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = insert($db, 'comments', convertPost($data));
        $result[] = json_encode(['message' => 'success']);
        echo json_encode($result);
    }

    closedb($db);
?>