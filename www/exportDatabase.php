<?php
// Verbindung zur MySQL-Datenbank
$mysqli = new mysqli('localhost', 'root', '', 'ConDB');

if ($mysqli->connect_error) {
    die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
}

// SQL-Dump der Tabellen erzeugen
$tables = $mysqli->query('SHOW TABLES');
$sql_dump = "";  // Gesamt-SQL-Dump als Variable

while ($table = $tables->fetch_row()) {
    $table_name = $table[0];
    $result = $mysqli->query("SELECT * FROM $table_name");

    // Table löschen, falls sie bereits existiert
    $sql_dump .= "DROP TABLE IF EXISTS `$table_name`;\n";

    // Tabelle erstellen
    $sql_dump .= "CREATE TABLE `$table_name` (\n";

    // Spalteninformationen holen und SQL-Dump für die Tabelle erzeugen
    $columns = $mysqli->query("SHOW COLUMNS FROM $table_name");
    $columns_data = [];
    while ($column = $columns->fetch_assoc()) {
        $columns_data[] = "`" . $column['Field'] . "` " . $column['Type'];
    }
    $sql_dump .= implode(",\n", $columns_data) . "\n";

    $sql_dump .= ");\n\n";  // Tabelle abschließen

    // Daten einfügen
    while ($row = $result->fetch_assoc()) {
        $insert_values = array_map(function($value) {
            return "'" . addslashes($value) . "'";
        }, $row);
        $sql_dump .= "INSERT INTO `$table_name` VALUES (" . implode(', ', $insert_values) . ");\n";
    }

    $sql_dump .= "\n\n";  // Trennung zwischen Tabellen
}

// Setze Header, um den Download zu triggern
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="backup_ConDB.sql"');
header('Content-Length: ' . strlen($sql_dump));

// Gib den Inhalt der Datei aus, anstatt sie zu speichern
echo $sql_dump;
exit;
?>
