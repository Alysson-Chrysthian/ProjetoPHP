<?php
    namespace App\User;

    use App\DB\DB;
    use Misterioso013\Tools\CPF;

    class User {
        
        private const REGEX_NOME = '/[A-z ]{3,}/';
        private const REGEX_CPF = '/(\d{3})\.(\d{3})\.(\d{3})\-(\d{2})/';
        private const REGEX_SENHA = '/(?=.*[A-z])(?=.*[0-9])(?=.*[@#&\$\%\-_])[A-z0-9@#&\$\%\-_]{8,16}/';
        private const REGEX_NASC = '/(\d{4})\-(\d{2})\-(\d{2})/';

        private $nome;
        private $mail;
        private $cpf;
        private $senha;
        private $nasc;

        public function __construct($nome, $mail, $cpf, $senha, $nasc)
        {
            $this->nome = $nome;
            $this->mail = $mail;
            $this->cpf = $cpf;
            $this->senha = $senha;
            $this->nasc = $nasc;
        }

        public function cadastrar() 
        {
            $conn = new DB();
            $conn = $conn->conectar();

            $sql = 'INSERT INTO CLIENTES VALUES(0, ?, ?, ?, ?, ?)';
            $query = $conn->prepare($sql);

            $user = [
                $this->nome,
                $this->cpf,
                $this->mail,
                $this->senha,
                $this->nasc
            ];

            $query->execute($user);
            
            return $conn->lastInsertId();
        }

        public function ValidarInfo()
        {
            $nasc = $this->nasc;
            $nasc = explode('/', $nasc);
            $nasc = $nasc[2].'-'.$nasc[1].'-'.$nasc[0];
            $this->nasc = $nasc;
            
            if (!preg_match(self::REGEX_NOME, $this->nome)) {
                return false;
            }
            if (!preg_match(self::REGEX_NASC, $this->nasc)) {
                return false;
            }
            if (!preg_match(self::REGEX_CPF, $this->cpf)) {
                return false;
            } 
            if (!$this->ValidarCpf()) {
                return false;
            }
            if (!preg_match(self::REGEX_SENHA, $this->senha)) {
                return false;
            }
            return true;
        } 

        private function ValidarCpf() {
            if (!preg_match(self::REGEX_CPF, $this->cpf)) {
                return false;
            }
            $cpf = $this->cpf;
            $cpf = str_replace('.', '', $cpf);
            $cpf = str_replace('-', '', $cpf);

            return CPF::validateCPF($cpf);
        }

    }
