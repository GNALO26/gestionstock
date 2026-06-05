<?php
// ============================================
// utilisateurs.php — Liste des utilisateurs
// ============================================
require_once("auth.php");
require_once("config.php");

$page_title = "Utilisateurs";
$db = getDB();

$users = $db->query('SELECT id, nom, prenom, contact, login FROM "user" ORDER BY nom, prenom')->fetchAll();

include("header.php");
?>

<div class="main-content">
  <div class="section-title">
    <i class="fas fa-user-friends"></i> Utilisateurs inscrits
    <span class="count-badge"><?= count($users) ?></span>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr><th>#</th><th>Nom</th><th>Prénom</th><th>Contact</th><th>Login</th><th>Statut</th></tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr><td colspan="6" class="empty-cell">Aucun utilisateur trouvé.</td></tr>
        <?php else: ?>
          <?php foreach ($users as $i => $u): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><strong><?= htmlspecialchars($u["nom"]) ?></strong></td>
              <td><?= htmlspecialchars($u["prenom"]) ?></td>
              <td><?= htmlspecialchars($u["contact"]) ?></td>
              <td><span class="badge badge-navy"><?= htmlspecialchars($u["login"]) ?></span></td>
              <td>
                <?php if ($u["id"] == $_SESSION["user_id"]): ?>
                  <span class="badge badge-green"><i class="fas fa-circle"></i> Vous</span>
                <?php else: ?>
                  <span class="badge badge-gold">Actif</span>
                <?php endif; ?>
               </td>
             </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>