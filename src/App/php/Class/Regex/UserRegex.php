<?php
    namespace App\Class\Regex;

    class UserRegex {
        
        public const ERROR_MESSAGE = 'Não foi possivel realizar a operação por favor aguarde ou recarrega a pagina ';
        
        public const REGEX_COD = '/^[0-9]*$/';
        public const REGEX_NAME = '/[A-zÀ-ú ]{3,}/';
        public const REGEX_PASS = '/(?=.*[0-9])(?=.*[A-z])(?=.*[@#\-_\$\&])[A-zÀ-ú0-9@#\-_\$\&]{8,16}/';
        public const REGEX_CPF = '/([0-9]{3})\.([0-9]{3})\.([0-9]{3})\-([0-9]{2})/';
        public const REGEX_NASC = '/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/';
        public const REGEX_MAIL = '/^([A-zÀ-ú]{1,}\@([A-z]{1,}\.[A-z]{1,}){1,})$/';
    }