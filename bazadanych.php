<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bazadanych
 *
 * @author andrzej.mroczek
 */
class bazadanych {

    private $pdo;
   
    private static $Instance = false;

    private function __construct() {
        $this->pdo= new PDO(
                'mysql:host=localhost;dbname=nowabaza',
                'Andrzej',
                'Andrzej27');
    }

    public static function getInstance() {
        if (self::$Instance == false) {
            self::$Instance = new bazadanych();
        }
        return self::$Instance;
    }

    private function __clone() {
        
    }

    public function getConnection() {
        return $this->pdo;
    }
    
    
    
    public function zapisz($tabela, array $dane){
            
        $pola ='';
        $wartosci='';
        foreach($dane as $pole=>$wartosc){
//            $sql.= 
            $wartosci.=$this->jestString($wartosc).', ';
            $pola.=$pole.', ';
            
        }
        $wartosci= substr($wartosci, 0, strlen($wartosci)-2);
        $pola= substr($pola, 0, strlen($pola)-2);
        
        $sql = "insert into $tabela ($pola) values ($wartosci)";
        
        $result =$this->pdo->exec($sql);
        return $result;
        
    }
    
    public function select($tabela,array $name=null) {
        if($name == null) {
            $pdost = $this->pdo->prepare("Select * from $tabela");
        } else {
            $wynik ='';
            foreach ($name as $pole => $wartosc) {
                $wynik.=$pole . '=' . $this->jestString($wartosc) . ' AND ';
            }
            $wynik = substr($wynik,0, -4);
            $pdost = $this->pdo->prepare("Select * from $tabela Where $wynik");
        }
        $pdost->execute();
        return $pdost->fetchAll();
        
    }

    
    private function jestString($krotka)
    {
        if(is_int($krotka))
        {
            return $krotka;
        }
        if(is_string($krotka))
        {
            return '"'.$krotka.'"';
        }
        return $krotka;
    }
 
}
