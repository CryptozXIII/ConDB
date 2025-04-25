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
$item = $_POST["item"];
$anzahl = $_POST["anzahl"];
$preis = $_POST["preis"];
$barcode = $_POST["barcode"];
$kategorie = $_POST["kategorie"] ?? null;
$thumbnail = null;

// Thumbnail speichern
if (!empty($_FILES["thumbnail"]["tmp_name"])) {
    $thumbnailPath = "thumbnails/" . basename($_FILES["thumbnail"]["name"]);
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnailPath);
    $thumbnail = $thumbnailPath; // Speichert den Pfad anstatt das Bild als BLOB
}

// Daten in die Datenbank einfügen
$stmt = $conn->prepare("INSERT INTO inventar (Item, Anzahl, Preis, Barcode, Thumbnail, Kategorie_ID) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sidssi", $item, $anzahl, $preis, $barcode, $thumbnailPath, $kategorie);


if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Fehler: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
