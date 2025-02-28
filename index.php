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

$nom = $_POST['nom'] ?? null;
$prenom = $_POST['prenom'] ?? null;
$email = $_POST['email'] ?? null;
$message = ''; // Ajouter une variable pour le message

if ($nom && $prenom && $email) {
    if(count($_POST) > 0) {
        // Valider l'adresse email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Veuillez entrer une adresse email valide.";
        } else {
            // Vérifier si l'adresse email existe déjà
            $sql = "SELECT COUNT(*) FROM `newsletter` WHERE `email` = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $message = "L'adresse email est déjà enregistrée.";
            } else {
                // Insertion de données
                $sql = "INSERT INTO `newsletter` (`nom`, `prenom`, `email`) VALUES (:nom, :prenom, :email)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $message = "Inscription réussie.";
                } else {
                    $message = "Une erreur est survenue lors de l'inscription.";
                }
            }
        }
    }
}

// Récupérer les informations de la BDD pour les afficher dans le tableau
$sql = "SELECT * FROM `newsletter`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP1</title>
    <link rel="stylesheet" href="css-js/css.css">
    <style>
        div {padding: 10px 0;}
        td, th {padding: 5px 10px;}
    </style>
</head>
<body>
    <div class="container">
        <h1>NEWSLETTER</h1>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <br>
        <h2>Inscription</h2>
        <form action="" method="POST">
            <div>
                <label for="email">Email</label>
                <input id="email" type="text" name="email" placeholder="Email">
            </div>
            <div>
                <label for="prenom">Prénom</label>
                <input id="prenom" type="text" name="prenom" placeholder="Prénom">
            </div>
            <div>
                <label for="nom">Nom</label>
                <input id="nom" type="text" name="nom" placeholder="Nom">
            </div>
            <div>
                <button type="submit">Ajouter</button>
            </div>
        </form>

        <a href="pages/login.php" class="lien">Carré admin</a>

        <a href="pages/unsubscribe.php" class="lien" style="margin-left: 65%;">Se désinscrire</a>
    </div>
</body>
</html>
