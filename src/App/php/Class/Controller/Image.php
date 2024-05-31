<?php
    namespace App\Class\Controller;

    use App\Class\Database\Database;
    use App\Class\Regex\ProdRegex;

    class Image extends ProdRegex {

        private $imageFormat;
        private $imageFoodId;
        private $imageContent;

        public function __construct($imageFormat, $imageFoodId, $imageContent) 
        {
            $this->imageFormat = $imageFormat;
            $this->imageFoodId = $imageFoodId;
            $this->imageContent = $imageContent;
        }

        public function Register()
        {   
            $image = $this->ConvertToArray();
            $sql = "INSERT INTO IMAGENS VALUES(DEFAULT, ?, ?, ?)";
        
            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute($image);
            } catch (\PDOException $e) {
                print self::ERROR_MESSAGE.$e->getMessage();
                die();
            }
        }

        public function ConvertToArray()
        {
            $food = [];
            foreach ($this as $k => $v) {
                if ($k != 'imageContent') {
                    $v = htmlspecialchars($v);
                }
                $v = addslashes(trim($v));
                array_push($food, $v);
            }
            return $food;
        }

        //
        public static function DeleteImage($image) 
        {
            $sql = "DELETE FROM IMAGENS WHERE COMIDA_ID = :id";

            try {
                $conn = new Database();
                $conn = $conn->connect();
                $query = $conn->prepare($sql);
                $query->execute([':id' => $image]);
                $conn = null;
            } catch (\PDOException $e) {
                print('Não foi possivel excluir a imagem'.$e->getMessage());
                exit();
            }
        }

    }