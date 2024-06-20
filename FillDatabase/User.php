<?php
require_once '../Classes/DBConnection.php';

if (isset($_POST['submit'])) {
try {
    // Verbindung zur Datenbank herstellen
    $conn = DBConnection::getConnection();

    // Daten aus dem Formular lesen
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];
    $email = $_POST['email'];

    // SQL-Befehl vorbereiten
    $stmt = $conn->prepare("INSERT INTO user (Username, Passwort, Email) VALUES (:username, :passwort, :email)");

    // Parameter binden
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':passwort', $passwort, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);

    // SQL-Befehl ausführen
    $stmt->execute();

    echo "Neuer Benutzer erfolgreich hinzugefügt";
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
    <title>User hinzufügen</title>
</head>
<body>
    <h1>Neuen Benutzer hinzufügen</h1>
    <form action="User.php" method="post">
        <label for="username">Benutzername:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="passwort">Passwort:</label><br>
        <input type="password" id="passwort" name="passwort" required><br><br>
        
        <label for="email">E-Mail:</label><br>
        <input type="email" id="email" name="email"><br><br>
        
        <input type="submit" value="Hinzufügen" name="submit">
    </form>
</body>
</html>
