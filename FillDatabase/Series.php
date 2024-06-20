<?php
session_start();
require_once '../Classes/DBConnection.php';

if (isset($_POST['submit'])) {
    try {
        // Verbindung zur Datenbank herstellen
        $conn = DBConnection::getConnection();

        // Daten aus dem Formular lesen
        $authorId = $_POST['authorId'];
        $name = $_POST['name'];
        $shortDescription = $_POST['shortDescription'];

        // SQL-Befehl vorbereiten
        $stmt = $conn->prepare("INSERT INTO series (Author_ID, Name, ShortDescription) VALUES (:authorId, :name, :shortDescription)");

        // Parameter binden
        $stmt->bindValue(':authorId', $authorId, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':shortDescription', $shortDescription, SQLITE3_TEXT);

        // SQL-Befehl ausführen
        $stmt->execute();

        echo "Neue Serie erfolgreich hinzugefügt";
    } catch (Exception $e) {
        echo "Fehler: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Form.css">
    <title>Serie hinzufügen</title>
</head>
<body>
    <h1>Neue Serie hinzufügen</h1>
    <form action="Series.php" method="post">
        <label for="authorId">Author ID:</label><br>
        <input type="number" id="authorId" name="authorId" required><br><br>
        
        <label for="name">Name der Serie:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="shortDescription">Kurze Beschreibung:</label><br>
        <textarea id="shortDescription" name="shortDescription"></textarea><br><br>
        
        <input type="submit" name="submit" value="Hinzufügen">
    </form>
</body>
</html>
