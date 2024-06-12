<?php
    namespace App\Class\Controller;

    use Misterioso013\Tools\CPF;
    use App\Class\Database\Database;
    use App\Class\Regex\UserRegex;
    use App\Interfaces\Controller;

    class User extends UserRegex {

        private string $name;
        private string $cpf;
        private string $mail;
        private string $pass;
        private string $nasc;

        public function __construct(array $info)
        {   
            foreach ($info as $k => $v) {
                $this->$k = $v;
            }
        }

        //
        public function Register() 
        {
            $user = $this->ConvertToArray();
            $sql = 'INSERT INTO CLIENTES VALUES (DEFAULT, :name, :cpf, :mail, :pass, :nasc)';

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
        public function ValidateInfo(bool $VerifyPass = true)
        {
            if (!preg_match(self::REGEX_NAME, $this->name)) {
                return false;
            }
            if ($VerifyPass) {
                if (!preg_match(self::REGEX_PASS, $this->pass)) {
                    return false;
                }
            }
            if (!$this->ValidateCpf()) {
                return false;
            }
            if (!preg_match(self::REGEX_NASC, $this->nasc)) {
                return false;
            }
            if (!preg_match(self::REGEX_MAIL, $this->mail)) {
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

            $sql = "SELECT * FROM CLIENTES WHERE CLIENTE_NOME = :name OR CLIENTE_CPF = :cpf OR CLIENTE_EMAIL = :mail";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':name' => $name, ':cpf' => $cpf, ':mail' => $mail]);
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }
            
            return $query->rowCount() > 0;
        }

        //
        public function VerifyIfCanLog()
        {
            $email = $this->mail;
            $pass = hash('sha256', $this->pass);
            $name = $this->name;

            $sql = "SELECT * FROM CLIENTES WHERE CLIENTE_EMAIL = :mail OR CLIENTE_NOME = :name AND CLIENTE_SENHA = :pass";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':mail' => $email, ':name' => $name, ':pass' => $pass]);
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
        public function ConvertToArray()
        {
            $user = [];
            foreach ($this as $k => $v) {
                $v = addslashes(htmlspecialchars(trim($v)));
                if ($k == 'pass') {
                    $v = hash('sha256', $v);
                }
                $k = ':'.$k;
                $user[$k] = $v;
            }
            return $user;
        }

    }