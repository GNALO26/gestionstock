<?php
// ============================================
// header.php — En-tête et navigation communs
// Inclure après auth.php sur chaque page
// ============================================
$page_courante = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'EssaiBDD' ?> — Plateforme UAC/ENEAM</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- Font Awesome 6 (icônes) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- ── En-tête principal ────────────────── -->
<header class="site-header">
  <div class="header-logo">
    <img src="logo1.png" alt="Logo UAC"
         onerror="this.classList.add('error')">
  </div>
  <div class="header-title">
    <h1>Bienvenue sur ma plateforme</h1>
  </div>
  <div class="header-right">
    <img src="logo2.png" alt="Logo ENEAM"
         onerror="this.classList.add('error')">
    <div class="header-logo-placeholder">ENEAM</div>
  </div>
</header>

<!-- Bouton burger (affiché uniquement sur mobile) -->
<button class="menu-toggle" id="menuToggle" aria-label="Menu">
  <span></span>
  <span></span>
  <span></span>
</button>

<!-- ── Navigation ───────────────────────── -->
<nav class="site-nav" id="siteNav">
  <a href="index.php"     class="<?= $page_courante == 'index.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> Accueil</a>
  <a href="articles.php"  class="<?= $page_courante == 'articles.php' ? 'active' : '' ?>"><i class="fas fa-boxes"></i> Articles</a>
  <a href="utilisateurs.php" class="<?= $page_courante == 'utilisateurs.php' ? 'active' : '' ?>"><i class="fas fa-user-friends"></i> Utilisateurs</a>
  <a href="clients.php"   class="<?= $page_courante == 'clients.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Clients</a>
  <a href="ventes.php"    class="<?= $page_courante == 'ventes.php' ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Ventes</a>
  <a href="effectuer_vente.php" class="<?= $page_courante == 'effectuer_vente.php' ? 'active' : '' ?>"><i class="fas fa-shopping-cart"></i> Effectuer une vente</a>

  <div class="nav-user">
    Connecté : <strong><?= $_SESSION["user_prenom"] . " " . $_SESSION["user_nom"] ?></strong>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
  </div>
</nav>

<script>
  // Gestion du menu burger
  const toggle = document.getElementById('menuToggle');
  const nav    = document.getElementById('siteNav');

  toggle.addEventListener('click', () => {
    nav.classList.toggle('open');
    toggle.classList.toggle('active');
  });

  // Fermer le menu après un clic sur un lien (mobile)
  nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        nav.classList.remove('open');
        toggle.classList.remove('active');
      }
    });
  });
</script>