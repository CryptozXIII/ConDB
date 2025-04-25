<?php
$servername = "localhost";
$username = "root"; // Standardnutzer in XAMPP
$password = ""; // Kein Passwort, falls du es nicht geändert hast
$dbname = "condb"; // Neue Datenbankname

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Datenbankverbindung fehlgeschlagen"]));
}

$sql = "SELECT i.Item_ID AS ID, i.Item, i.Anzahl, i.Preis, i.Barcode, i.Thumbnail, k.Kategoriename
        FROM inventar i
        LEFT JOIN kategorien k ON i.Kategorie_ID = k.Kategorie_ID";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    // Falls Thumbnail als BLOB gespeichert wurde, hier den Pfad oder den Bildinhalt verarbeiten
    if ($row['Thumbnail']) {
        // Beispiel: Pfad zum Bild anzeigen
        $row['Thumbnail'] = "thumbnails/" . basename($row['Thumbnail']);
    }
    $items[] = $row;
}

echo json_encode(["success" => true, "data" => $items]);

$conn->close();
?>
