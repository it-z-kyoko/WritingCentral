<?php
session_start();
require_once 'Classes/DBConnection.php';

if (isset($_POST['submit'])) {
    try {
        // Verbindung zur Datenbank herstellen
        $conn = DBConnection::getConnection();

        // Daten aus dem Formular lesen
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL-Befehl vorbereiten und ausführen
        $stmt = $conn->prepare("SELECT * FROM user WHERE Username = :username AND Passwort = :password");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);
        $result = $stmt->execute();

        // Überprüfen, ob der Benutzer gefunden wurde
        $user = $result->fetchArray(SQLITE3_ASSOC);
        if ($user) {
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['username'] = $user['Username'];

            // Cookie setzen, der die Benutzer-ID speichert (1 Stunde gültig)
            setcookie('user_id', $user['User_ID'], time() + 3600, "/");

            echo "Login erfolgreich. Willkommen, " . htmlspecialchars($user['Username']) . "!";
            // Weiterleiten zu einer anderen Seite, z.B. dashboard.php
            // header('Location: dashboard.php');
            // exit();
        } else {
            echo "Ungültiger Benutzername oder Passwort.";
        }
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
    <link rel="stylesheet" href="CSS/Form.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="username">Benutzername:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Passwort:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
