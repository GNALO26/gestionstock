<?php
// ============================================
// inscription.php — Créer un compte utilisateur
// ============================================
session_start();
require_once("config.php");

$erreur = "";
$succes = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // 1. Récupérer et nettoyer les données
  $nom     = trim($_POST["nom"]);
  $prenom  = trim($_POST["prenom"]);
  $contact = trim($_POST["contact"]);
  $login   = trim($_POST["login"]);
  $pass    = trim($_POST["password"]);

  // 2. Vérifier que tous les champs sont remplis
  if (empty($nom) || empty($prenom) || empty($contact)
      || empty($login) || empty($pass)) {
    $erreur = "Tous les champs sont obligatoires.";

  } else {
    $db = getDB();

    // 3. Vérifier si le login existe déjà (table "user" avec guillemets)
    $stmt = $db->prepare('SELECT id FROM "user" WHERE login = ?');
    $stmt->execute([$login]);

    if ($stmt->fetch()) {
      $erreur = "Ce login est déjà utilisé. Choisissez-en un autre.";
    } else {
      // 4. Hasher le mot de passe — JAMAIS en clair en base
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      // 5. Insérer l'utilisateur
      $stmt = $db->prepare(
        'INSERT INTO "user" (nom, prenom, contact, login, password)
         VALUES (?, ?, ?, ?, ?)'
      );
      $stmt->execute([$nom, $prenom, $contact, $login, $hash]);

      $succes = "Compte créé avec succès !";
    }
  }
}

// Récupérer les valeurs saisies pour les ré-afficher si erreur
$v = [
  "nom"     => isset($_POST["nom"])     ? htmlspecialchars($_POST["nom"])     : "",
  "prenom"  => isset($_POST["prenom"])  ? htmlspecialchars($_POST["prenom"])  : "",
  "contact" => isset($_POST["contact"]) ? htmlspecialchars($_POST["contact"]) : "",
  "login"   => isset($_POST["login"])   ? htmlspecialchars($_POST["login"])   : "",
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="auth-page">

  <!-- En-tête logos -->
  <div class="auth-header">
    <div class="auth-header-text">
      <h2>Bienvenue sur ma plateforme</h2>
    </div>
    <div class="auth-logo">ENEAM</div>
  </div>

  <!-- Carte inscription -->
  <div class="auth-card">
    <h3>Créer un compte</h3>
    <p class="subtitle">Remplissez vos informations pour vous inscrire.</p>

    <?php if ($erreur): ?>
      <div class="msg msg-error"><i class="fas fa-exclamation-triangle"></i> <?= $erreur ?></div>
    <?php endif; ?>

    <?php if ($succes): ?>
      <div class="msg msg-success"><i class="fas fa-check-circle"></i> <?= $succes ?></div>
      <p style="text-align:center; margin-top:12px; font-size:0.88rem;">
        <a href="login.php" style="color:var(--navy); font-weight:600;">
          <i class="fas fa-arrow-right"></i> Se connecter
        </a>
      </p>
    <?php else: ?>

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

      <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" value="<?= $v['nom'] ?>"
               placeholder="Votre nom de famille">
      </div>

      <div class="form-group">
        <label>Prénom</label>
        <input type="text" name="prenom" value="<?= $v['prenom'] ?>"
               placeholder="Votre prénom">
      </div>

      <div class="form-group">
        <label>Contact (téléphone)</label>
        <input type="text" name="contact" value="<?= $v['contact'] ?>"
               placeholder="+229 XX XX XX XX">
      </div>

      <div class="form-group">
        <label>Login</label>
        <input type="text" name="login" value="<?= $v['login'] ?>"
               placeholder="Choisissez un identifiant unique">
      </div>

      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password"
               placeholder="Choisissez un mot de passe sécurisé">
      </div>

      <div class="btn-group">
        <button type="reset"  class="btn btn-cancel"><i class="fas fa-times"></i> Annuler</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> S'inscrire</button>
      </div>

    </form>

    <?php endif; ?>
  </div>

  <div class="auth-link">
    Déjà inscrit ? <a href="login.php">Se connecter</a>
  </div>

</div>

</body>
</html>