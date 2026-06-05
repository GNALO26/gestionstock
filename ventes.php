<?php
// ============================================
// ventes.php — Liste des ventes
// ============================================
require_once("auth.php");
require_once("config.php");

$page_title = "Ventes";
$db = getDB();

$ventes = $db->query(
  "SELECT co.id_comm, co.date, co.montant,
          cl.nom AS client_nom, cl.prenom AS client_prenom, cl.ville
   FROM commande co
   JOIN client cl ON co.id_client = cl.id_client
   ORDER BY co.date DESC, co.id_comm DESC"
)->fetchAll();

$details = $db->query(
  "SELECT c.id_comm, a.design, a.categorie, c.qtecomm, a.prix, (c.qtecomm * a.prix) AS sous_total
   FROM contenir c
   JOIN article a ON c.id_article = a.id_article"
)->fetchAll();

$details_par_comm = [];
foreach ($details as $d) {
  $details_par_comm[$d["id_comm"]][] = $d;
}

include("header.php");
?>

<div class="main-content">
  <div class="section-title">
    <i class="fas fa-chart-bar"></i> Liste des ventes
    <span class="count-badge"><?= count($ventes) ?></span>
  </div>

  <?php if (empty($ventes)): ?>
    <div class="msg msg-warning"><i class="fas fa-exclamation-triangle"></i> Aucune vente enregistrée. <a href="effectuer_vente.php">Effectuer une vente →</a></div>
  <?php else: ?>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr><th>N°</th><th>Date</th><th>Client</th><th>Ville</th><th>Articles</th><th>Total</th></tr>
        </thead>
        <tbody>
          <?php foreach ($ventes as $v): ?>
            <tr>
              <td><span class="badge badge-navy">#<?= $v["id_comm"] ?></span></td>
              <td><?= date("d/m/Y", strtotime($v["date"])) ?></td>
              <td><strong><?= htmlspecialchars($v["client_nom"]) ?></strong> <?= htmlspecialchars($v["client_prenom"]) ?></td>
              <td><?= htmlspecialchars($v["ville"]) ?></td>
              <td>
                <?php $arts = $details_par_comm[$v["id_comm"]] ?? []; ?>
                <?php if (empty($arts)): ?>
                  <span class="text-muted">—</span>
                <?php else: ?>
                  <?php foreach ($arts as $art): ?>
                    <div class="vente-article">
                      <span class="badge badge-gold"><?= $art["qtecomm"] ?>x</span>
                      <?= htmlspecialchars($art["design"]) ?>
                      <span class="text-muted">(<?= number_format($art["sous_total"], 0, ',', ' ') ?> FCFA)</span>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </td>
              <td><strong><?= number_format($v["montant"], 0, ',', ' ') ?> FCFA</strong></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
</body>
</html>