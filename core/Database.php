<?php
// class Database {
//     private static $instance = null;
//     private $conn;

//     private $host = DB_HOST;
//     private $db_name = DB_NAME;
//     private $username = DB_USER;
//     private $password = DB_PASS;
//     private $charset = DB_CHARSET;

//     private function __construct() {
//         try {
//             $this->conn = new PDO(
//                 "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}",
//                 $this->username,
//                 $this->password
//             );
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die("Erreur de connexion : " . $e->getMessage());
//         }
//     }

//     // Retourne l’instance unique de PDO
//     public static function getInstance() {
//         if (!self::$instance) {
//             self::$instance = new Database();
//         }
//         return self::$instance->conn;
//     }
// }




class Database
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=tomtroc;charset=utf8",
            "root",
            "root",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}


?>