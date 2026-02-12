# Tournament Manager 🏆

## Descrizione del Progetto
L'applicazione è una Web App Single-User per la gestione completa di tornei sportivi a eliminazione diretta.

### Sport Scelto: Calcio ⚽
È stato scelto il Calcio come sport di riferimento.
- **Regole:** Per i tornei a eliminazione diretta, il pareggio non è ammesso. Il sistema valida l'inserimento impedendo punteggi uguali per garantire sempre un vincitore.

---

## Funzionalità Core (MVP)
- **Gestione Anagrafiche (CRUD):** Visualizzazione, creazione ed eliminazione delle squadre.
- **Vincolo di Integrità:** Il sistema impedisce l'eliminazione di squadre che hanno già partecipato a tornei conclusi, fornendo un messaggio di errore.
- **Setup Torneo:** Creazione di tornei fissi a 8 squadre (partenza dai Quarti di Finale).
- **Logica di Avanzamento:** Algoritmo automatico che "capisce" chi vince e promuove il vincitore al turno successivo.
- **Dashboard Storico:** Vista dedicata ai tornei passati con indicazione del vincitore.

---

## Stack Tecnologico
- **Backend:** PHP 8.2+ (OOP).
- **Database:** MySQL / MariaDB.
- **Architettura:** API RESTful (JSON).
- **Frontend:** React (Vite) con Hooks (`useState`, `useEffect`).

---

## Struttura delle Cartelle
- `/backend`: Contiene la classe di connessione al DB.
- `/backend/Models`: Contiene le classi `Team.php` e `Tournament.php` (Business Logic).
- `/backend/api`: Contiene gli endpoint suddivisi per risorsa (`teams` e `tournaments`).
- `/frontend`: Contiene l'applicazione React.
- `/frontend/src/App.jsx`: componente principale che gestisce lo stato globale e la logica di navigazione tra le pagine React.

---

## Istruzioni per l'Installazione

### 1. Database
- Creare un database MySQL chiamato `tournament_db`.
- Importare il file `database_dump.sql` (presente nella root del progetto) per generare tabelle e dati di test.

### 2. Backend (PHP)
- Il progetto è configurato per essere lanciato tramite **Laravel Herd** all'indirizzo: `http://tournament-manager.test`.
- Assicurarsi che le credenziali nel file `backend/Database.php` corrispondano alla configurazione locale di DBngin/MySQL.

### 3. Frontend (React)
1. Aprire il terminale nella cartella `frontend`.
2. Installare le dipendenze:
   npm install

---

## Procedura di Avvio
Per avviare l'ambiente di lavoro:
1. Aprire **DBngin** e avviare il servizio MySQL (tasto Start).
2. Assicurarsi che **Laravel Herd** sia attivo.
3. Aprire il terminale nella cartella `frontend` e lanciare `npm run dev`.
4. Navigare su `http://localhost:5173`.

## Procedura di Spegnimento
1. Nel terminale di React, premere `Ctrl + C`.
2. In **DBngin**, premere `Stop` sul servizio MySQL.
3. In **Laravel Herd**, premere `Stop all services`.
4. Chiudere le applicazioni.