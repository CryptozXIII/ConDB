<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ConDB';

// Prüfen, ob eine Datei hochgeladen wurde
if (isset($_FILES['importFile']) && $_FILES['importFile']['error'] === UPLOAD_ERR_OK) {
    // Zielpfad für die hochgeladene Datei
    $uploadedFile = $_FILES['importFile']['tmp_name'];
    
    // Verbindung zur MySQL-Datenbank herstellen
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    // Die hochgeladene SQL-Datei einlesen
    $sql = file_get_contents($uploadedFile);

    // Prüfen, ob die Datei leer ist
    if (empty($sql)) {
        die("Fehler: Die SQL-Datei ist leer.");
    }

    // SQL-Befehle ausführen
    if ($conn->multi_query($sql)) {
        echo "Datenbank erfolgreich importiert! Die Seite muss aktuallisiert werden!";
    } else {
        echo "Fehler beim Importieren der Datenbank: " . $conn->error;
    }

    // Verbindung schließen
    $conn->close();
} else {
    echo "Fehler beim Hochladen der Datei.";
}
?>