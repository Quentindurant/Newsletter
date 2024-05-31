document.getElementById('copyEmailsButton').addEventListener('click', function() {
    // Sélectionner toutes les lignes actives
    var rows = document.querySelectorAll('tr[data-active="true"]');
    var addresses = '';

    // mettre les addresses mails a la suite dans mon presse papier
    rows.forEach(function(row) {
        var email = row.querySelector('.email').textContent.trim();
        addresses += email + ' ';
    });

    // Copie les adresses email dans le presse-papiers
    navigator.clipboard.writeText(addresses.trim())
        .then(function() {
            alert('Les adresses email actives ont été copiées dans le presse-papiers.');
        })
        .catch(function(error) {
            console.error('Une erreur est survenue lors de la copie dans le presse-papiers : ', error);
        });
});
