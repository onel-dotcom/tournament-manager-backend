<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";
include_once "../../Models/Team.php";

$database = new Database();
$db = $database->getConnection();

$team = new Team($db);
$stmt = $team->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $teams_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $teams_arr[] = array("id" => $id, "name" => $name);
    }
    echo json_encode($teams_arr);
} else {
    echo json_encode(array());
}
