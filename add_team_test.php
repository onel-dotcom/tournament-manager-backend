<?php
// backend/add_team_test.php

require_once "Database.php";
require_once "Models/Team.php";

// 1. Inizializziamo il database
$database = new Database();
$db = $database->getConnection();

// 2. Inizializziamo l'oggetto Team
$team = new Team($db);

// 3. Proviamo ad aggiungere una squadra di test
$nomeSquadra = "Juventus";

if ($team->create($nomeSquadra)) {
    echo "Successo! La squadra '$nomeSquadra' è stata aggiunta al database.";
} else {
    echo "Errore durante l'inserimento della squadra.";
}
