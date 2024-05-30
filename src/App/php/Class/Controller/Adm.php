<?php
    namespace App\Class\Controller;

    use App\Class\Database\Database;
    use App\Class\Regex\UserRegex;

    class Adm extends UserRegex {

        private $adm_id;
        private $password;

        //
        public function __construct($adm_id, $password)
        {
            $this->adm_id = $adm_id;
            $this->password = $password;
        }

        //
        public function ValidateAdmInfo()
        {
            if (!is_numeric($this->adm_id)) {
                return false;
            }
            if (!preg_match(self::REGEX_PASS, $this->password)) {
                return false;
            }
            return true;
        }

        //
        public function VerifyIfAdmExist()
        {
            $id = $this->adm_id;
            $password = $this->password;
        
            $sql = "SELECT ADM_ID FROM ADM WHERE ADM_ID = ? AND ADM_SENHA = ?";
            
            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([$id, $password]);
                $query = $query->fetch(\PDO::FETCH_ASSOC);
                $conn = null;
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }

            return isset($query['ADM_ID']) ? $query['ADM_ID'] : false;
        }

    }