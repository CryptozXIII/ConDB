<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "condb");

$result = $conn->query("SELECT Kategorie_ID, Kategoriename FROM kategorien");
$kategorien = [];

while ($row = $result->fetch_assoc()) {
  $kategorien[] = $row;
}

echo json_encode($kategorien);
$conn->close();
