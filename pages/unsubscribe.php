<?php
try {
    // Établir la connexion avec la base de données
    $host = 'localhost';
    $db   = 'tp1 news';
    $user = 'TP1 News';
    $pass = 'caca1';
    $charset = 'utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO('mysql:host='.$host.'; port=3306; dbname='.$db,$user,$pass);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if ($email) {
        // Marquer l'email comme désinscrit
        $sql = "DELETE FROM `newsletter` WHERE `email` = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $message = "L'adresse email a été désinscrite avec succès.";
        } else {
            $message = "Une erreur est survenue lors de la désinscription.";
        }
    } else {
        $message = "Veuillez saisir une adresse email valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Désinscription</title>
    <link rel="stylesheet" href="../css-js/css.css">
</head>
<body>
    <div class="container">
        <h1>Désinscription de la Newsletter</h1>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="unsubscribe.php" method="POST">
            <div>
                <label for="email">Adresse email</label>
                <input id="email" type="text" name="email" placeholder="p'tite pute ton adresse" required>
            </div>
            <div>
                <button type="submit">Se désinscrire</button>
            </div>
        </form>
        <a href="../tp1.php" class="lien" >Accueil</a>
    </div>
</body>
</html>
