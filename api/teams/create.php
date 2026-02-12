<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";
include_once "../../Models/Team.php";

$database = new Database();
$db = $database->getConnection();
$team = new Team($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name)) {
    if ($team->create($data->name)) {
        http_response_code(201);
        echo json_encode(["message" => "Squadra creata."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Errore server."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Dati incompleti."]);
}
