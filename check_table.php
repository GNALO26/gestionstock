<?php
require_once("config.php");

$db = getDB();

// Lister les colonnes de la table "user"
$query = "SELECT column_name, data_type 
          FROM information_schema.columns 
          WHERE table_name = 'user' 
          ORDER BY ordinal_position";
$stmt = $db->query($query);
$columns = $stmt->fetchAll();

echo "<h2>Colonnes de la table 'user' :</h2><ul>";
foreach ($columns as $col) {
    echo "<li>" . htmlspecialchars($col['column_name']) . " (" . htmlspecialchars($col['data_type']) . ")</li>";
}
echo "</ul>";

// Tenter une requête simple avec guillemets autour de "user"
try {
    $test = $db->query("SELECT * FROM \"user\" LIMIT 1");
    echo "<p style='color:green'>✅ SELECT * FROM \"user\" fonctionne.</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Erreur avec \"user\" : " . $e->getMessage() . "</p>";
}

// Sans guillemets
try {
    $test = $db->query("SELECT * FROM user LIMIT 1");
    echo "<p style='color:green'>✅ SELECT * FROM user fonctionne.</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Erreur sans guillemets : " . $e->getMessage() . "</p>";
}
?>