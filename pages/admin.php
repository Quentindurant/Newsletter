<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: login.php');
    exit;
}

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

// Traiter l'activation/désactivation des emails
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $active = $_POST['active'];

    $sql = "UPDATE `newsletter` SET `active` = :active WHERE `ID` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: admin.php');
        exit;
    } else {
        echo "Erreur";
    }
}

$sql = "SELECT * FROM `newsletter`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css-js/css.css">
</head>
<body>
    <div class="container">
        <h2>NEWSLETTER</h2>
        <table border="1">
            <thead>
                <tr>
                    <th class="tableau">ID</th>
                    <th class="tableau">Nom</th>
                    <th class="tableau">Prénom</th>
                    <th class="tableau">Email</th>
                    <th class="tableau">Actif</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr data-active="<?php echo $row['active'] ? 'true' : 'false'; ?>">
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['prenom']; ?></td>
                        <td class="email"><?php echo $row['email']; ?></td>
                        <td>
                            <form action="admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                <input type="hidden" name="active" value="<?php echo $row['active'] ? 0 : 1; ?>">
                                <button type="submit" class="<?php echo $row['active'] ? 'active-button' : 'inactive-button'; ?>">
                                    <?php echo $row['active'] ? 'Désactiver' : 'Activer'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="copyEmailsButton">Copier les adresses email</button>
        <a href="../tp1.php" class="lien">Accueil</a>
    </div>
    <script src="../css-js/js.js"></script>
</body>
</html>
