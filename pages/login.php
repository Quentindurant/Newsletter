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


session_start();

$adminPassword = 'fdp'; 

if (isset($_GET['password'])) {
    $password = $_GET['password'];

    if ($password === $adminPassword) {
        $_SESSION['isAdmin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $_SESSION['loginMessage'] = "Mot de passe incorrect.";
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Admin</title>
    <link rel="stylesheet" href="../css-js/css.css">
    <style>
        div {padding: 10px 0;}
        td, th {padding: 5px 10px;}
    </style>
</head>
<body>
     <div class="container">
        <h1>Vérification Admin</h1>
        <?php if (isset($_SESSION['loginMessage'])): ?>
            <p style="color: red;"><?php echo $_SESSION['loginMessage']; ?></p>
            <?php unset($_SESSION['loginMessage']); ?>
        <?php endif; ?>
        <form action="login.php" method="GET">
            <div>
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" placeholder="le mdp salope" >
            </div>
            <div>
                <button type="submit">Vérifier</button>
            </div>
        </form>
     </div>
</body>
</html>
