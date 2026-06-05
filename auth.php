<?php
// ============================================
// auth.php — Garde de session
// Inclure en haut de chaque page protégée
// ============================================

// session_start() doit être appelé AVANT tout output HTML
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Si l'utilisateur n'est pas connecté → rediriger vers login
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}
?>