<?php
// ============================================
// articles.php — Ajouter et lister les articles
// ============================================
require_once("auth.php");
require_once("config.php");

$page_title = "Articles";
$erreur     = "";
$succes     = "";

$db = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
  $id_article = trim($_POST["id_article"]);
  $design     = trim($_POST["design"]);
  $prix       = trim($_POST["prix"]);
  $categorie  = trim($_POST["categorie"]);

  if (empty($id_article) || empty($design) || empty($prix) || empty($categorie)) {
    $erreur = "Tous les champs sont obligatoires.";
  } elseif (!is_numeric($prix) || (float)$prix <= 0) {
    $erreur = "Le prix doit être un nombre positif.";
  } else {
    $check = $db->prepare("SELECT id_article FROM article WHERE id_article = ?");
    $check->execute([$id_article]);
    if ($check->fetch()) {
      $erreur = "Cet identifiant d'article existe déjà.";
    } else {
      $stmt = $db->prepare("INSERT INTO article (id_article, design, prix, categorie) VALUES (?, ?, ?, ?)");
      $stmt->execute([$id_article, $design, (float)$prix, $categorie]);
      $succes = "Article <strong>" . htmlspecialchars($design) . "</strong> ajouté avec succès !";
      $_POST = [];
    }
  }
}

$articles = $db->query("SELECT * FROM article ORDER BY categorie, design")->fetchAll();

$v = [
  "id_article" => isset($_POST["id_article"]) ? htmlspecialchars($_POST["id_article"]) : "",
  "design"     => isset($_POST["design"])     ? htmlspecialchars($_POST["design"])     : "",
  "prix"       => isset($_POST["prix"])       ? htmlspecialchars($_POST["prix"])       : "",
  "categorie"  => isset($_POST["categorie"])  ? $_POST["categorie"]                   : "",
];

include("header.php");
?>

<div class="main-content">
  <div class="section-title">
    <i class="fas fa-boxes"></i> Gestion des Articles
    <span class="count-badge"><?= count($articles) ?></span>
  </div>

  <div class="layout-two">
    <!-- Formulaire -->
    <div class="card">
      <div class="card-title"><i class="fas fa-plus-circle"></i> Ajouter un article</div>
      <?php if ($erreur): ?>
        <div class="msg msg-error"><i class="fas fa-exclamation-triangle"></i> <?= $erreur ?></div>
      <?php endif; ?>
      <?php if ($succes): ?>
        <div class="msg msg-success"><i class="fas fa-check-circle"></i> <?= $succes ?></div>
      <?php endif; ?>
      <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
          <label>Identifiant article</label>
          <input type="text" name="id_article" value="<?= $v['id_article'] ?>" placeholder="Ex: ART001">
        </div>
        <div class="form-group">
          <label>Désignation</label>
          <input type="text" name="design" value="<?= $v['design'] ?>" placeholder="Nom du produit">
        </div>
        <div class="form-group">
          <label>Prix (FCFA)</label>
          <input type="number" step="1" min="1" name="prix" value="<?= $v['prix'] ?>" placeholder="Ex: 15000">
        </div>
        <div class="form-group">
          <label>Catégorie</label>
          <select name="categorie">
            <option value="">-- Choisir --</option>
            <?php
            $cats = ["Informatique","Électronique","Alimentation","Vêtements","Fournitures","Mobilier","Autres"];
            foreach ($cats as $cat):
            ?>
              <option value="<?= $cat ?>" <?= $v['categorie'] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="btn-group">
          <button type="reset" class="btn btn-cancel"><i class="fas fa-times"></i> Annuler</button>
          <button type="submit" class="btn btn-primary" name="ajouter"><i class="fas fa-plus"></i> Ajouter</button>
        </div>
      </form>
    </div>

    <!-- Liste -->
    <div>
      <div class="card-title" style="margin-bottom:14px;"><i class="fas fa-list"></i> Liste des articles</div>
      <div class="table-wrapper">
        <table>
          <thead>
            <tr><th>ID</th><th>Désignation</th><th>Prix</th><th>Catégorie</th></tr>
          </thead>
          <tbody>
            <?php if (empty($articles)): ?>
              <tr><td colspan="4" class="empty-cell">Aucun article enregistré.</td></tr>
            <?php else: ?>
              <?php foreach ($articles as $a): ?>
                <tr>
                  <td><span class="badge badge-navy"><?= htmlspecialchars($a["id_article"]) ?></span></td>
                  <td><strong><?= htmlspecialchars($a["design"]) ?></strong></td>
                  <td><?= number_format($a["prix"], 0, ',', ' ') ?> FCFA</td>
                  <td><span class="badge badge-gold"><?= htmlspecialchars($a["categorie"]) ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>