<?php
    namespace App\Class\Controller;

    use Misterioso013\Tools\CPF;
    use App\Class\Database\Database;
    use App\Traits\Regex\Regex;

    class User {

        use Regex;

        private string $name;
        private string $cpf;
        private string $mail;
        private string $pass;
        private string $nasc;

        public function __construct($name, $cpf, $mail, $pass, $nasc)
        {   
            $this->name = $name;
            $this->cpf = $cpf;
            $this->mail = $mail;
            $this->pass = $pass;
            $this->nasc = $nasc;
        }

        //
        public function RegisterUser() 
        {
            $user = $this->ConvertUserToArray();
            $sql = 'INSERT INTO CLIENTES VALUES (DEFAULT, ?, ?, ?, ?, ?)';

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query = $query->execute($user);
                return $conn->lastInsertId();
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }
        }

        //
        public function ValidateUserInfo()
        {
            if (!preg_match(self::REGEX_NAME, $this->name)) {
                return false;
            }
            if (!preg_match(self::REGEX_PASS, $this->pass)) {
                return false;
            }
            if (!$this->ValidateCpf()) {
                return false;
            }
            if (!preg_match(self::REGEX_NASC, $this->nasc)) {
                return false;
            }
            if (!filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            return true;
        }

        //
        public function VerifyIfUserExist() 
        {
            $name = $this->name;
            $cpf = $this->cpf;
            $mail = $this->mail;

            $sql = "SELECT * FROM CLIENTES WHERE CLIENTE_NOME = ? OR CLIENTE_CPF = ? OR CLIENTE_EMAIL = ?";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([$name, $cpf, $mail]);
                $query = $query->fetchAll(\PDO::FETCH_ASSOC);
                $conn = null;
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }
            
            return count($query) > 0;
        }

        //
        public function VerifyIfCanLog()
        {
            $email = $this->mail;
            $pass = hash('sha256', $this->pass);

            $sql = "SELECT * FROM CLIENTES WHERE CLIENTE_EMAIL = ? AND CLIENTE_SENHA = ?";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([$email, $pass]);
                $query = $query->fetch(\PDO::FETCH_ASSOC);
                $conn = null;
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }

            return isset($query['CLIENTE_ID']) ? $query['CLIENTE_ID'] : false;
        }

        //
        private function ValidateCpf() 
        {
            if (preg_match(self::REGEX_CPF, $this->cpf)) {
                $cpf = $this->cpf;
                $cpf = str_replace('.', '', $cpf);
                $cpf = str_replace('-', '', $cpf);            
                return CPF::validateCPF($cpf);       
            }
            return false;
        }

        //
        private function ConvertUserToArray()
        {
            $user = [];
            foreach ($this as $k => $v) {
                $v = addslashes(htmlspecialchars(trim($v)));
                if ($k == 'pass') {
                    $v = hash('sha256', $v);
                }
                array_push($user, $v);
            }
            return $user;
        }

    }