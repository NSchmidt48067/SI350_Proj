<?php

// internal check to see if the database is open
function check($db) {
    if (!$db) {
        echo "Database is closed";
        exit;
    }
}

// create a database if it doesn't exist
function create_if_no($path, $tablename, $columns) {
    // open the file
    $db = opendb($path);

    // create the SQL command
    $columnsStr = '';
    foreach ($columns as $column => $type) {
        if($columnsStr != '') {
            $columnsStr = $columnsStr . ', ';
        }
        $columnsStr = $columnsStr . "$column $type";
    }

    // execute the SQL command
    if(!$db->exec("CREATE TABLE IF NOT EXISTS $tablename ($columnsStr)")) {
        echo "<br>Failed to create table $tablename<br>";
    }

    // close the database
    closedb($db);
}

function opendb($path) {
    $db = new SQLite3($path, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    return $db;
}

function closedb($db) {
    $db->close();
}

function query($db, $table, $colValPairs) {
    // make sure the db is open
    check($db);

    // construct the query
    $select = "SELECT * FROM $table WHERE";
    foreach($colValPairs as $col => $val) {
        $select = $select . " $col=:$col";
    }

    $stmt = $db->prepare($select);

    if(!$stmt) {
        echo "Failed to prepare statement";
        return [];
    }

    // bind values to their respective column
    foreach($colValPairs as $col => $val) {
        $stmt->bindValue(":$col", $val['val'], $val['type']);
    }

    // perform the search
    $query = $stmt->execute();

    // find the result and send it back
    $result = [];
    while($row = $query->fetchArray(SQLITE3_ASSOC)) {
        $result[] = $row;
    }

    return $result;
}

function insert($db, $table, $colValPairs) {
    // construct the SQL query
    $cols = "";
    $vals = "";
    foreach($colValPairs as $col => $val) {
        if($cols != "") {
            $cols = $cols . ',';
            $vals = $vals . ',';
        }
        $cols = $cols . $col;
        $vals = $vals . ":$col";
    }

    $cmd = "INSERT INTO $table ($cols) VALUES ($vals)";
    $stmt = $db->prepare($cmd);

    // bind the values to insert
    foreach($colValPairs as $col => $val) {
        $stmt->bindValue(":$col", $val['val'], $val['type']);
    }

    // insert the values
    $result = $stmt->execute();

    // cause problems if it failed
    if(!$result) {
        return json_encode(['error' => $db->lastErrorMsg()]);
    }
}

?>