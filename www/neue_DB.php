<?php
// Verbindung zur MySQL-Datenbank herstellen
$mysqli = new mysqli('localhost', 'root', '', '');

// Überprüfen, ob die Verbindung erfolgreich war
if ($mysqli->connect_error) {
    die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
}

// Neue Datenbank "ConDB" erstellen
$sql = "CREATE DATABASE IF NOT EXISTS ConDB";
if ($mysqli->query($sql) === TRUE) {
    echo "Datenbank ConDB erfolgreich erstellt oder existiert bereits.<br>";
} else {
    echo "Fehler beim Erstellen der Datenbank: " . $mysqli->error;
}

// Mit der neu erstellten Datenbank verbinden
$mysqli->select_db('ConDB');

// Tabelle "Inventar" erstellen
$table_sql = "
CREATE TABLE IF NOT EXISTS Inventar (
  laufende_Nummer INT NOT NULL AUTO_INCREMENT,
  Item TEXT NOT NULL,
  Anzahl INT, 
  Preis DECIMAL(10,2),
  Barcode TEXT,
  Thumbnail BLOB,
  PRIMARY KEY (laufende_Nummer)
)";
if ($mysqli->query($table_sql) === TRUE) {
    echo "Tabelle 'Inventar' erfolgreich erstellt.<br>";
} else {
    echo "Fehler beim Erstellen der Tabelle: " . $mysqli->error;
}

// Verbindung schließen
$mysqli->close();

// Weiterleitung zur Startseite oder zu einer Bestätigungsseite
header("Location: start.html"); // Optional: Weiterleitung nach erfolgreicher Erstellung
exit;
?>
