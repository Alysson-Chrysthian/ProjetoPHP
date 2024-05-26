<?php
    namespace App\DB;

    use Exception;

    class DB {

        public function conectar() {
            $conn = false;
            try {
                $conn = new \PDO('mysql:dbname=churrascaria;host=localhost;port=3306', 'root', '');
            } catch(\Exception $e) {
                print($e->getMessage());
            }
            return $conn;
        }

    }
