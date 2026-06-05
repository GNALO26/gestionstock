<?php
// ============================================
// clients.php — Liste des clients
// ============================================
require_once("auth.php");
require_once("config.php");

$page_title = "Clients";
$db = getDB();

$clients = $db->query(
  "SELECT c.id_client, c.nom, c.prenom, c.age, c.ville, c.mail,
          COUNT(DISTINCT co.id_comm) AS nb_commandes,
          COALESCE(SUM(co.montant), 0) AS total_depense
   FROM client c
   LEFT JOIN commande co ON c.id_client = co.id_client
   GROUP BY c.id_client
   ORDER BY c.nom, c.prenom"
)->fetchAll();

include("header.php");
?>

<div class="main-content">
  <div class="section-title">
    <i class="fas fa-users"></i> Clients
    <span class="count-badge"><?= count($clients) ?></span>
  </div>

  <?php if (empty($clients)): ?>
    <div class="msg msg-warning"><i class="fas fa-exclamation-triangle"></i> Aucun client enregistré.</div>
  <?php else: ?>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr><th>#</th><th>Nom</th><th>Prénom</th><th>Âge</th><th>Ville</th><th>Email</th><th>Cmd</th><th>Total</th></tr>
        </thead>
        <tbody>
          <?php foreach ($clients as $i => $c): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><strong><?= htmlspecialchars($c["nom"]) ?></strong></td>
              <td><?= htmlspecialchars($c["prenom"]) ?></td>
              <td><?= $c["age"] ? $c["age"] . " ans" : "—" ?></td>
              <td><?= htmlspecialchars($c["ville"]) ?></td>
              <td><?= $c["mail"] ? htmlspecialchars($c["mail"]) : "—" ?></td>
              <td><span class="badge badge-navy"><?= $c["nb_commandes"] ?></span></td>
              <td><?= number_format($c["total_depense"], 0, ',', ' ') ?> FCFA</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
</body>
</html>