<?php
$servername = "localhost";
$username = "root"; // Standardnutzer in XAMPP
$password = ""; // Kein Passwort, falls du es nicht geändert hast
$dbname = "condb"; // Datenbankname

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Verbindung fehlgeschlagen: " . $conn->connect_error]));
}

// POST-Daten abrufen
$id = $_POST["id"];
$item = $_POST["item"];
$anzahl = $_POST["anzahl"];
$preis = $_POST["preis"];
$barcode = $_POST["barcode"];
$thumbnail = null;

// Thumbnail speichern
if (!empty($_FILES["thumbnail"]["tmp_name"])) {
    $thumbnailPath = "thumbnails/" . basename($_FILES["thumbnail"]["name"]);
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnailPath);
    $thumbnail = $thumbnailPath; // Speichert den Pfad anstatt das Bild als BLOB
}

// Daten in der Datenbank aktualisieren
$stmt = $conn->prepare("UPDATE Inventar SET Item = ?, Anzahl = ?, Preis = ?, Barcode = ?, Thumbnail = ? WHERE laufende_Nummer = ?");
$stmt->bind_param("sisssi", $item, $anzahl, $preis, $barcode, $thumbnail, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Fehler: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>