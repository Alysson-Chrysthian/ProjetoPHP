<?php
    namespace App\Database;

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__.'\..\..\..');
    $dotenv->load();

    class Database {
        
        private string $name;
        private string $host;
        private string $user;
        private string $pass;
        private string $port;

        public function __construct()
        {
            $this->name = $_ENV['DB_NAME'];
            $this->host = $_ENV['DB_HOST'];
            $this->user = $_ENV['DB_USER'];
            $this->pass = $_ENV['DB_PASS'];
            $this->port = $_ENV['DB_PORT'];
        }

        public function connect()
        {
            $conn = null;
            
            $name = $this->name;
            $host = $this->host;
            $user = $this->user;
            $pass = $this->pass;
            $port = $this->port;

            try {
                $conn = new \PDO("mysql:dbname=$name;host=$host;port=$port", $user, $pass);
            } catch (\PDOException $e) {
                print 'Não foi possivel se conectar com o banco de dados '.$e->getMessage();
                die();
            }

            return $conn;
        }

    }
