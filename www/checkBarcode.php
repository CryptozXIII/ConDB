<?php
header("Content-Type: application/json");
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "condb"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB-Verbindung fehlgeschlagen"]);
    exit();
}

if (!isset($_POST["barcode"])) {
    echo json_encode(["success" => false, "message" => "Kein Barcode empfangen"]);
    exit();
}

$barcode = $_POST["barcode"];
$stmt = $conn->prepare("SELECT Item, Anzahl, Preis, Thumbnail FROM Inventar WHERE Barcode = ?");
$stmt->bind_param("s", $barcode);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($item, $anzahl, $preis, $thumbnail);
    $stmt->fetch();
    
    echo json_encode([
        "success" => true,
        "item" => $item,
        "anzahl" => $anzahl,
        "preis" => $preis,
        "thumbnail" => $thumbnail ? $thumbnail : "kein_thumbnail.png"
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Kein Eintrag gefunden"]);
}

$stmt->close();
$conn->close();
?>
