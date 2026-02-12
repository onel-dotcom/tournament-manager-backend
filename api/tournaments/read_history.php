<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";

$database = new Database();
$db = $database->getConnection();

$query = "SELECT t.*, teams.name as winner_name 
          FROM tournaments t 
          LEFT JOIN teams ON t.winner_id = teams.id 
          WHERE t.status = 'completed' 
          ORDER BY t.id DESC";

echo json_encode($db->query($query)->fetchAll(PDO::FETCH_ASSOC));
