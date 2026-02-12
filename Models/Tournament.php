<?php
// backend/Models/Tournament.php

class Tournament
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $teamIds)
    {
        try {
            // 1. Crea il torneo
            $query = "INSERT INTO tournaments (name) VALUES (:name)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $tournamentId = $this->conn->lastInsertId();

            shuffle($teamIds);

            // 2. Crea la FINALE (Round 3)
            $finalId = $this->insertMatch($tournamentId, 3, null);

            // 3. Crea le due SEMIFINALI (Round 2) collegate alla finale
            $semi1Id = $this->insertMatch($tournamentId, 2, $finalId);
            $semi2Id = $this->insertMatch($tournamentId, 2, $finalId);

            // 4. Crea i QUARTI (Round 1) collegati alle semifinali
            // Quarti per la Semifinale 1
            $this->insertMatch($tournamentId, 1, $semi1Id, $teamIds[0], $teamIds[1]);
            $this->insertMatch($tournamentId, 1, $semi1Id, $teamIds[2], $teamIds[3]);

            // Quarti per la Semifinale 2
            $this->insertMatch($tournamentId, 1, $semi2Id, $teamIds[4], $teamIds[5]);
            $this->insertMatch($tournamentId, 1, $semi2Id, $teamIds[6], $teamIds[7]);

            return $tournamentId;
        } catch (Exception $e) {
            return false;
        }
    }

    private function insertMatch($tId, $round, $nextId, $t1 = null, $t2 = null)
    {
        $query = "INSERT INTO matches (tournament_id, round, next_match_id, team1_id, team2_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tId, $round, $nextId, $t1, $t2]);
        return $this->conn->lastInsertId();
    }
}
