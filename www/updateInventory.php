<?php
header("Content-Type: application/json");

// DB-Verbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "condb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Datenbank-Verbindung fehlgeschlagen"]);
    exit();
}

// Eingehende JSON-Daten
$input = json_decode(file_get_contents("php://input"), true);
$data = $input["items"] ?? null;
$ort = $input["ort"] ?? null;

if (!$data) {
    echo json_encode(["success" => false, "message" => "Keine Artikeldaten empfangen"]);
    exit();
}

// Bestände aktualisieren
foreach ($data as $item) {
    $barcode = $item["barcode"];
    $count = $item["count"];

    $stmt = $conn->prepare("SELECT Anzahl, Item_ID FROM inventar WHERE Barcode = ?");
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $stmt->bind_result($currentCount, $itemId);
    $stmt->fetch();
    $stmt->close();

    if ($currentCount === null) {
        echo json_encode(["success" => false, "message" => "Artikel nicht gefunden"]);
        exit();
    }

    $newCount = $currentCount - $count;
    if ($newCount < 0) {
        echo json_encode(["success" => false, "message" => "Nicht genügend Bestand"]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE Inventar SET Anzahl = ? WHERE Barcode = ?");
    $stmt->bind_param("is", $newCount, $barcode);
    $stmt->execute();
    $stmt->close();

    // Ersetze Barcode durch Artikel-ID für die Historie
    $item["id"] = $itemId;
    unset($item["barcode"]);
    $finalItems[] = $item;
}

// Bestellung speichern
$bestellungJson = json_encode($finalItems);
$stmt = $conn->prepare("INSERT INTO Bestellhistorie (Bestellung, Ort) VALUES (?, ?)");
$stmt->bind_param("ss", $bestellungJson, $ort);
$stmt->execute();
$stmt->close();

$conn->close();
echo json_encode(["success" => true, "message" => "Datenbank erfolgreich aktualisiert"]);
?>
