<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";
include_once "../../Models/Team.php";

$database = new Database();
$db = $database->getConnection();
$team = new Team($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $result = $team->delete($data->id);
    if ($result === true) {
        echo json_encode(["message" => "Squadra eliminata."]);
    } else if ($result === "has_participated") {
        http_response_code(400);
        echo json_encode(["message" => "Impossibile eliminare: questa squadra ha già partecipato a dei tornei."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Errore eliminazione."]);
    }
}
