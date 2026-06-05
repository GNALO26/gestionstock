<?php
// ============================================
// index.php — Tableau de bord principal
// ============================================
require_once("auth.php");
require_once("config.php");

$page_title = "Accueil";

$db = getDB();
$nb_users    = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
$nb_articles = $db->query("SELECT COUNT(*) FROM article")->fetchColumn();
$nb_clients  = $db->query("SELECT COUNT(*) FROM client")->fetchColumn();
$nb_ventes   = $db->query("SELECT COUNT(*) FROM commande")->fetchColumn();
$total_ca    = $db->query("SELECT COALESCE(SUM(montant),0) FROM commande")->fetchColumn();

include("header.php");
?>

<div class="main-content">
  <div class="section-title">
    <i class="fas fa-tachometer-alt"></i> Tableau de bord
  </div>

  <!-- Statistiques -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-label">Utilisateurs</div>
      <div class="stat-value"><?= $nb_users ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Articles</div>
      <div class="stat-value"><?= $nb_articles ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Clients</div>
      <div class="stat-value"><?= $nb_clients ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label"><i class="fas fa-shopping-cart"></i> Ventes</div>
      <div class="stat-value"><?= $nb_ventes ?></div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Chiffre d'affaires</div>
      <div class="stat-value"><?= number_format($total_ca, 0, ',', ' ') ?> F</div>
    </div>
  </div>

  <!-- Liens rapides -->
  <div class="card">
    <div class="card-title"><i class="fas fa-link"></i> Accès rapides</div>
    <div class="quick-links">
      <a href="articles.php" class="btn btn-primary"><i class="fas fa-boxes"></i> Gérer les articles</a>
      <a href="effectuer_vente.php" class="btn btn-gold"><i class="fas fa-shopping-cart"></i> Effectuer une vente</a>
      <a href="clients.php" class="btn btn-outline"><i class="fas fa-users"></i> Voir les clients</a>
      <a href="ventes.php" class="btn btn-outline"><i class="fas fa-chart-bar"></i> Voir les ventes</a>
    </div>
  </div>
</div>

</body>
</html>