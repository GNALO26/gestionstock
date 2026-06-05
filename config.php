<?php
function getDB() {
    $host = getenv('PGHOST') ?: 'localhost';
    $dbname = getenv('PGDATABASE') ?: 'postgres';
    $user = getenv('PGUSER') ?: 'postgres';
    $pass = getenv('PGPASSWORD') ?: '';
    $port = getenv('PGPORT') ?: '5432';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    } catch (PDOException $e) {
        die("❌ Erreur de connexion PostgreSQL : " . $e->getMessage());
    }
}
?>