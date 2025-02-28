<?

// Récupérer les informations de la BDD pour les afficher dans le tableau
$sql = "SELECT * FROM `newsletter`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>