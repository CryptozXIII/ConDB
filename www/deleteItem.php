<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root"; // Standard-Benutzername in XAMPP
$password = ""; // Standard-Passwort ist leer in XAMPP
$database = "ConDB";

// Verbindung zur MySQL-Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $database);

// Prüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Verbindungsfehler: " . $conn->connect_error]));
}

// Prüfen, ob eine ID übergeben wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sicherheit: ID in eine Zahl umwandeln

    // Zuerst das Thumbnail aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT Thumbnail FROM Inventar WHERE laufende_Nummer = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $thumbnailPath = null;

    if ($row = $result->fetch_assoc()) {
        $thumbnailPath = $row['Thumbnail']; // Annahme: Der Pfad ist gespeichert
    }
    $stmt->close();

    // Wenn ein Bild vorhanden ist, versuchen, es zu löschen
    if ($thumbnailPath && file_exists($thumbnailPath)) {
        unlink($thumbnailPath); // Löscht die Datei
    }

    // Jetzt den Eintrag aus der Datenbank löschen
    $stmt = $conn->prepare("DELETE FROM Inventar WHERE laufende_Nummer = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Fehler beim Löschen"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Ungültige Anfrage"]);
}

$conn->close();
?>
