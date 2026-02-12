<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";
include_once "../../Models/Tournament.php";

$database = new Database();
$db = $database->getConnection();
$tournament = new Tournament($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && count($data->teams) == 8) {
    $tId = $tournament->create($data->name, $data->teams);
    echo json_encode(["message" => "Torneo creato!", "id" => $tId]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Seleziona esattamente 8 squadre."]);
}
