<?php
class DB {
    protected $pdo;

    public function __construct() {
        $host = 'localhost';       // adapte
        $dbname = 'nom_base';      // adapte
        $user = 'utilisateur';     // adapte
        $pass = 'motdepasse';      // adapte
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die('Connexion échouée : ' . $e->getMessage());
        }
    }
}
?>