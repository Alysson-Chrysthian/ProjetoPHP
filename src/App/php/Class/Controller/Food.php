<?php
    namespace App\Class\Controller;

    use App\Class\Database\Database;
    use App\Class\Regex\ProdRegex;
    use App\Interfaces\Controller;
use PDOException;

    class Food extends ProdRegex implements Controller {

        private $PdrName;
        private $PdrPrice;
        private $PdrDesc;
        private $PdrDate;
        private $PdrCat;
        private $AdmId;

        //
        public function __construct($name, $price, $desc, $PdrCat, $AdmId) 
        {
            $this->PdrName = $name;
            $this->PdrPrice = $price;
            $this->PdrDesc = $desc;
            $this->PdrDate = date('Y-m-d');
            $this->PdrCat = match ($PdrCat) {
                '1' => 'churrasco',
                '2' => 'bebida',
                default => false,
            };
            $this->AdmId = $AdmId;
        }
        
        //
        public function Register()
        {
            $food = $this->ConvertToArray();
            $sql = "INSERT INTO COMIDA VALUES(DEFAULT, ?, ?, ?, ?, ?, ?)";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute($food);
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }
            
            return $conn->lastInsertId();
        }

        //
        public function ValidateInfo()
        {
            if (!preg_match(self::REGEX_NAME, $this->PdrName)) {
                return false;
            }
            if (!preg_match(self::REGEX_DESC, $this->PdrDesc)) {
                return false;
            }
            if (!is_numeric($this->PdrPrice)) {
                return false;
            }
            if (!$this->PdrCat) {
                return false;
            }
            return true;
        }

        //
        public function ConvertToArray()
        {
            $food = [];
            foreach ($this as $v) {
                $v = addslashes(htmlspecialchars(trim($v)));
                array_push($food, $v);
            }
            return $food;
        }


        //
        public function VerifyIfExist()
        {
            $sql = "SELECT * FROM COMIDA WHERE COMIDA_NOME = :name";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':name' => $this->PdrName]);
                $query = $query->rowCount();
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
            }
            return $query > 0;
        }

        //
        public static function DeleteFood($food) 
        {
            $sql = "DELETE FROM COMIDA WHERE COMIDA_ID = :id";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':id' => $food]);
                $conn = null;
            } catch (\PDOException $e) {
                print 'Não foi possivel excluir o produto selecionado'.$e->getMessage();
                exit();
            }
        }

    }