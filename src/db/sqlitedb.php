<?php

function check($db) {
    if (!$db) {
        echo "Database is closed";
        exit;
    }
}

function create_if_no($path, $tablename, $columns) {
    $db = opendb($path);

    $columnsStr = '';
    foreach ($columns as $column => $type) {
        if($columnsStr != '') {
            $columnsStr = $columnsStr . ', ';
        }
        $columnsStr = $columnsStr . "$column $type";
    }

    if(!$db->exec("CREATE TABLE IF NOT EXISTS $tablename ($columnsStr)")) {
        echo "<br>Failed to create table $tablename<br>";
    }

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
    check($db);

    $select = "SELECT * FROM $table WHERE";
    foreach($colValPairs as $col => $val) {
        $select = $select . " $col=:$col";
    }

    $stmt = $db->prepare($select);

    if(!$stmt) {
        echo "Failed to prepare statement";
        return [];
    }

    foreach($colValPairs as $col => $val) {
        $stmt->bindValue(":$col", $val['val'], $val['type']);
    }

    $query = $stmt->execute();

    $result = [];
    while($row = $query->fetchArray(SQLITE3_ASSOC)) {
        $result[] = $row;
    }

    return $result;
}

function insert($db, $table, $colValPairs) {
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

    foreach($colValPairs as $col => $val) {
        $stmt->bindValue(":$col", $val['val'], $val['type']);
    }

    $stmt->execute();
}

?>