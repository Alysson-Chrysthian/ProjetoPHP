<?php
    namespace App\User;

    use Misterioso013\Tools\CPF;
    use App\Database\Database;

    class User {

        private const REGEX_NAME = '/[A-z ]{3,}/';
        private const REGEX_PASS = '/(?=.*[0-9])(?=.*[A-z])(?=.*[@#\-_\$\&])[A-z0-9@#\-_\$\&]{8,16}/';
        private const REGEX_CPF = '/([0-9]{3})\.([0-9]{3})\.([0-9]{3})\-([0-9]{2})/';
        private const REGEX_NASC = '/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/';

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
                print 'Não foi possivel cadastrar o usuario, porfavor recarregue a pagina ou volte mais tarde';
                return false;
            }
        }

        public function ValidateInfo()
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

        public function ConvertUserToArray()
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