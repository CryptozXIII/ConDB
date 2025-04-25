<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "condb");
$result = $conn->query("SELECT * FROM Bestellhistorie ORDER BY Datum DESC");
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>
