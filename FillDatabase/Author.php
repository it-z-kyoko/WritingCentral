<?php
require_once '../Classes/DBConnection.php';

if (isset($_POST['submit'])) {
    try {
        // Verbindung zur Datenbank herstellen
        $conn = DBConnection::getConnection();

        // Daten aus dem Formular lesen
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $alias = $_POST['alias'];
        $userId = $_POST['userId'];

        // SQL-Befehl vorbereiten
        $stmt = $conn->prepare("INSERT INTO author (FirstName, LastName, Alias, User_ID) VALUES (:firstName, :lastName, :alias, :userId)");

        // Parameter binden
        $stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
        $stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
        $stmt->bindValue(':alias', $alias, SQLITE3_TEXT);
        $stmt->bindValue(':userId', $userId, SQLITE3_INTEGER);

        // SQL-Befehl ausführen
        $stmt->execute();

        echo "Neuer Autor erfolgreich hinzugefügt";
    } catch (Exception $e) {
        echo "Fehler: " . $e->getMessage();
    }
}

if (isset($_COOKIE['user_id']))
{
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Form.css">
    <title>Autor hinzufügen</title>
</head>
<body>
    <h1>Neuen Autor hinzufügen</h1>
    <form action="Author.php" method="post">
        <label for="firstName">Vorname:</label><br>
        <input type="text" id="firstName" name="firstName" required><br><br>
        
        <label for="lastName">Nachname:</label><br>
        <input type="text" id="lastName" name="lastName" required><br><br>
        
        <label for="alias">Alias:</label><br>
        <input type="text" id="alias" name="alias"><br><br>
        
        <label for="userId">User ID:</label><br>
        <input type="number" id="userId" name="userId" required><br><br>
        
        <input type="submit" name="submit" value="Hinzufügen">
    </form>
</body>
</html>
<?php } else { ?>
    <h1>Melden Sie sich bitte an</h1>
    
<?php } ?>