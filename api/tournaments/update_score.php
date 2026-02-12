<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->match_id)) {
    if ($data->score1 == $data->score2) {
        http_response_code(400);
        echo json_encode(["message" => "Pareggio non ammesso!"]);
        exit;
    }

    $winner_id = ($data->score1 > $data->score2) ? $data->team1_id : $data->team2_id;

    $stmt = $db->prepare("UPDATE matches SET score1 = ?, score2 = ?, winner_id = ? WHERE id = ?");
    $stmt->execute([$data->score1, $data->score2, $winner_id, $data->match_id]);

    if (!empty($data->next_match_id)) {
        $check = $db->prepare("SELECT team1_id FROM matches WHERE id = ?");
        $check->execute([$data->next_match_id]);
        $next = $check->fetch(PDO::FETCH_ASSOC);

        $col = empty($next['team1_id']) ? "team1_id" : "team2_id";
        $db->prepare("UPDATE matches SET $col = ? WHERE id = ?")->execute([$winner_id, $data->next_match_id]);
    } else {
        $db->prepare("UPDATE tournaments SET status = 'completed', winner_id = ? WHERE id = ?")->execute([$winner_id, $data->tournament_id]);
    }
    echo json_encode(["message" => "Ok"]);
}
