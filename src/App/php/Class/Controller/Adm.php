<?php
    namespace App\Class\Controller;

    use App\Class\Database\Database;
    use App\Class\Regex\UserRegex;

    class Adm extends UserRegex {

        private $id;
        private $pass;

        //
        public function __construct(array $admInfo)
        {
            foreach ($admInfo as $k => $v) {
                $this->$k = $v;
            }
        }

        //
        public function ValidateAdmInfo()
        {
            if (!is_numeric($this->id)) {
                return false;
            }
            if (!preg_match(self::REGEX_PASS, $this->pass)) {
                return false;
            }
            return true;
        }

        //
        public function VerifyIfAdmExist()
        {
            $id = $this->id;
            $pass = $this->pass;
        
            $sql = "SELECT ADM_ID FROM ADM WHERE ADM_ID = :id AND ADM_SENHA = :pass";
            
            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':id' => $id, ':pass' => $pass]);
                $query = $query->fetch(\PDO::FETCH_ASSOC);
                $conn = null;
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }

            return isset($query['ADM_ID']) ? $query['ADM_ID'] : false;
        }

    }