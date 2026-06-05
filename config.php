<?php
// ============================================
// config.php — Connexion PDO à la base
// Inclure dans TOUS les fichiers PHP du projet
// ============================================

define("HOST", "sql201.infinityfree.com");
define("USER", "if0_42094013");
define("PASS", "LPj1mnI7BxNr4P");          // XAMPP = pas de mot de passe
define("BASE", "if0_42094013_oly");
define("Port", "3306");

/**
 * Retourne une connexion PDO à la base de données.
 * PDO = PHP Data Objects — interface universelle pour parler à MySQL.
 */
function getDB() {
  try {
    // DSN = Data Source Name — identifie la base à utiliser
    $dsn = "mysql:host=" . HOST . ";dbname=" . BASE . ";charset=utf8";

    $db  = new PDO($dsn, USER, PASS);

    // Lancer une exception si une requête SQL échoue
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retourner les résultats en tableau associatif par défaut
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $db;

  } catch (PDOException $e) {
    die("<div style='font-family:Arial;color:red;padding:20px'>
         ❌ Erreur de connexion : " . $e->getMessage() . "
         </div>");
  }
}
?>