<?php
include_once __DIR__ . "/../config.php";
include_once "../../Database.php";

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT m.*, t1.name as team1_name, t2.name as team2_name 
          FROM matches m
          LEFT JOIN teams t1 ON m.team1_id = t1.id
          LEFT JOIN teams t2 ON m.team2_id = t2.id
          WHERE m.tournament_id = ?
          ORDER BY m.round ASC, m.id ASC";

$stmt = $db->prepare($query);
$stmt->execute([$id]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
