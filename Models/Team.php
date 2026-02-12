<?php
// backend/Models/Team.php

class Team
{
    private $conn;
    private $table_name = "teams";

    // Proprietà della squadra
    public $id;
    public $name;

    // Il costruttore riceve la connessione al database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Metodo per leggere tutte le squadre
    public function read()
    {
        $query = "SELECT id, name FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Metodo per creare una nuova squadra
    public function create($name)
    {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        // Pulizia dati per sicurezza
        $name = htmlspecialchars(strip_tags($name));

        // Colleghiamo il parametro
        $stmt->bindParam(":name", $name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- METODO PER ELIMINARE LE SQUADRE---
    public function delete($id)
    {
        // 1. Vincolo: Una squadra non può essere eliminata se ha partecipato a tornei passati
        // Controlliamo nella tabella 'matches' se l'ID della squadra compare come team1 o team2
        $checkQuery = "SELECT COUNT(*) FROM matches WHERE team1_id = ? OR team2_id = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->execute([$id, $id]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            // Se la squadra ha giocato almeno un match, blocchiamo l'eliminazione
            return "has_participated";
        }

        // 2. Se non ha partecipato a nulla, procediamo con l'eliminazione fisica
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$id])) {
            return true;
        }
        return false;
    }
}
