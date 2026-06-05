<?php
// ============================================
// login.php — Authentification utilisateur
// ============================================
session_start();
require_once("config.php");

// Initialiser le compteur d'essais (stocké en session)
if (!isset($_SESSION["essais"])) {
  $_SESSION["essais"] = 0;
}

$erreur    = "";
$imposteur = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Bloquer immédiatement si 3 essais atteints
  if ($_SESSION["essais"] >= 3) {
    $imposteur = true;

  } else {
    $login = trim($_POST["login"]);
    $pass  = trim($_POST["password"]);

    if (empty($login) || empty($pass)) {
      $erreur = "Veuillez remplir tous les champs.";

    } else {
      $db   = getDB();

      // Chercher l'utilisateur par son login
      $stmt = $db->prepare("SELECT * FROM user WHERE login = ?");
      $stmt->execute([$login]);
      $user = $stmt->fetch();

      // Vérifier le mot de passe hashé
      if ($user && password_verify($pass, $user["password"])) {

        // ✅ Connexion réussie
        $_SESSION["essais"]     = 0;
        $_SESSION["user_id"]    = $user["id"];
        $_SESSION["user_nom"]   = $user["nom"];
        $_SESSION["user_prenom"]= $user["prenom"];
        $_SESSION["user_login"] = $user["login"];

        // Rediriger vers la page demandée ou l'accueil
        $redirect = isset($_SESSION["redirect_after_login"])
                    ? $_SESSION["redirect_after_login"]
                    : "index.php";
        unset($_SESSION["redirect_after_login"]);
        header("Location: $redirect");
        exit();

      } else {
        // ❌ Échec
        $_SESSION["essais"]++;

        if ($_SESSION["essais"] >= 3) {
          $imposteur = true;
        } else {
          $restants = 3 - $_SESSION["essais"];
          $erreur   = "Login ou mot de passe incorrect. "
                    . "Il vous reste <strong>$restants essai(s)</strong>.";
        }
      }
    }
  }
}

$essaisActuels = $_SESSION["essais"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
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
  </div>

  <!-- Carte connexion -->
  <div class="auth-card">

    <?php if ($imposteur): ?>

      <!-- Message imposteur -->
      <div class="imposteur-box">
        <i class="fas fa-ban"></i> Vous êtes un imposteur !
        <p style="font-size:0.82rem; font-weight:400; margin-top:8px; color:#ff8888;">
          Accès définitivement bloqué après 3 tentatives échouées.
        </p>
      </div>

    <?php else: ?>

      <h3>Se connecter</h3>
      <p class="subtitle">Entrez vos identifiants pour accéder à la plateforme.</p>

      <?php if ($erreur): ?>
        <div class="msg msg-error"><i class="fas fa-exclamation-triangle"></i> <?= $erreur ?></div>
      <?php endif; ?>

      <!-- Indicateur d'essais -->
      <?php if ($essaisActuels > 0): ?>
        <div class="essais-dots">
          <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="essais-dot <?= $i <= $essaisActuels ? 'used' : '' ?>"></div>
          <?php endfor; ?>
          <span style="font-size:0.75rem; color:var(--grey); margin-left:4px;">
            <?= $essaisActuels ?>/3 tentative(s)
          </span>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

        <div class="form-group">
          <label>Login</label>
          <input type="text" name="login"
                 value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>"
                 placeholder="Votre identifiant" autofocus>
        </div>

        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" name="password" placeholder="Votre mot de passe">
        </div>

        <div class="btn-group">
          <button type="reset"  class="btn btn-cancel"><i class="fas fa-eraser"></i> Effacer</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> S'authentifier</button>
        </div>

      </form>

    <?php endif; ?>
  </div>

  <div class="auth-link">
    Pas encore inscrit ? <a href="inscription.php">Créer un compte</a>
  </div>

</div>

</body>
</html>