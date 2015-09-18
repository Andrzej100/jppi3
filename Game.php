<?php

/**
 * Description of Game
 *
 * @author piotr.switala <piotr.switala@powiat.poznan.pl>
 */
class Game extends request {

    /**
     * Obsługa głównego wątku gry
     */
    public function start() {
        $session = Sesja::getInstance();
        
        $szablon =  new Ladowanie();
        
       $rodzaj = $szablon->getSzablon();
        if($szablon->jestWyslany()){
           $dane = $szablon->getPOST();
//           
           if($rodzaj == 'rejestracja'){
               
               $rejestracja = new Rejestracja(new Uzytkownik($dane['login'], $dane['haslo']));
               $rejestracja->zapisz();
               $session->setUp($dane);
               $session->setMessage('Dodano Uzytkownika');
               
           }elseif($rodzaj == 'logowanie'){
               $logowanie=new Logowanie(new Uzytkownik($dane['login'], $dane['haslo']));
               $user=$logowanie->sprawdz();
               if($user == false) {
                   $session->setMessage('Błąd logowania');
               }else{
                   $session->setMessage('Zalogowano');
               }
               $session->setUp(array('user'=>new Uzytkownik($user)));
           }elseif($rodzaj == 'wyborpostaci'){
               $user=$session->get('user');
               $wyborpostaci=new Wyborpostaci($user);
               if(isset($dane['imie'])){
                   $wyborpostaci->utwoz($dane['imie']);
                   $session->setMessage('Utworzono postac, wybierz postac');
               }elseif(isset($dane['wybor'])){
                $wybor=$wyborpostaci->wybierz($dane['wybor']);
                $session->setUp(array('postac'=>new Wiedzmin($wybor)));
                $session->setMessage('Wybrano postac');
               }
           }
           
        }
        
        if($rodzaj == 'wyborpostaci'){
           $user=$session->get('user');
           $wyborpostaci=new Wyborpostaci($user);
           $session->setUp(array('wynik'=>$wyborpostaci->pobierz()));
        }

//        echo $session->get('login');
//        echo $session->get('haslo');
//        echo $session->get('id');
        $variable = array(
            'wynik'=>$session->get('wynik'),
            'message'=>$session->getMessage(),
            'user'=>$session->get('user'),
            'postac'=>$session->get('postac')
        );
        
        $szablon->szablon($variable);
//        if ($_GET['strona']=='rejestracja' && isset($_POST['submit'])) {
//            echo"Czychcesz sie zarejestrować czy zalogować?";
////            $ladowanie = new ladowanie();
////            echo $ladowanie->wybor();
//        } elseif ( $_GET['strona']=='rejestracja' ) {
//            include "./Szablony/rejestracja.php";
//        } elseif (isset($_POST['logowanie'])) {
//            $ladowanie = new ladowanie();
//            echo $ladowanie->formularz("logowanie");
//            if ($ladowanie->login() == true) {
//                echo"Logowanie zakonczone pomyslnie";
//                $sesja = new sesja();
//                $sesja->sessionset();
//                Serializacja::serialize('sesja', $sesja, $_SESSION['user_id']);
//                Serializacja::serialize('ladowanie', $ladowanie, $_SESSION['user_id']);
//                echo $ladowanie->wybierzpostac();
//            }
//        }
//        if ($_POST['submit'] == "wybierz") {
//            $ladowanie = Serializacja::unserialize($_SESSION['user_id'], 'ladowanie');
//            $wybor = $ladowanie->wyborpostaci();
//            $postac = new Wiedźmin($wybor);
//            echo 'wybrales' + $ladowanie->wyborpostaci();
//            Serializacja::serialize('ladowanie', $ladowanie, $_SESSION['user_id'], true);
//            Serializacja::serialize('postac', $postac, $_SESSION['user_id']);
//            $ladowanie->wyborakcji();
//        }
//
//        if ($_POST['submit'] == 'Statystyki') {
//            $statystyki = new Statystyki();
//            echo $statystyki->statystykiform();
//            if (isset($_POST['staty'])) {
//                $statystyki = new Statystyki();
//                $statystyki->statystykiwyswietl();
//            }
//        } elseif ($_POST['submit'] == 'Wejdź do sklepu') {
//            $postac = Serializacja::unserialize($_SESSION['user_id'], 'postac');
//            $sklep = new Sklep($postac);
//            echo $sklep->obsluga('kupno');
//            echo $sklep->obsluga('sprzedaz');
//            Serializacja::serialize('sklep', $sklep, $_SESSION['user_id']);
//            if (isset($_POST['submit'])) {
//                $sklep = Serializacja::unserialize($_SESSION['user_id'], 'sklep');
//                echo $sklep->obsluga('kupno');
//                echo $sklep->obsluga('sprzedaz');
//                echo $sklep->transakcja($_POST['submit']);
//                Serializacja::serialize('sklep', $sklep, $_SESSION['user_id'], true);
//            }
//        } elseif ($_POST['submit'] == 'Wybierz Ekwipunek') {
//            $postac = Serializacja::unserialize($_SESSION['user_id'], 'postac');
//            $ekwipunek = new Ekwipunek($postac->getid(), $postac->getaktywne);
//            echo $ekwipunek->showekwipunek();
//            Serializacja::serialize('ekwipunek', $ekwipunek, $_SESSION['user_id']);
//            if ($_POST['submit'] == 'wyposaz') {
//                $ekwipunek = Serializacja::unserialize($_SESSION['user_id'], 'ekwipunek');
//                $postac = Serializacja::unserialize($_SESSION['user_id'], 'postac');
//                $bron = $ekwipunek->aktywnyekwipunek($_POST['idbroni']);
//                echo $postac->aktywnyEkwipunek($bron);
//                Serializacja::serialize('ekwipunek', $ekwipunek, $_SESSION['user_id'], true);
//                Serializacja::serialize('postac', $postac, $_SESSION['user_id'], true);
//            }
//        } elseif ($_POST['submit'] == 'Wybierz Przeciwnika') {
//            $tura = new Tura();
//            if (isset($_POST['potwor']) || $_POST['submit'] == "Wybierz akcje") {
//                $tura = Serializacja::unserialize($_SESSION['user_id'], 'tura');
//                $postac = Serializacja::unserialize($_SESSION['user_id'], 'postac');
//                $przeciwnik = $_POST['potwor'];
//                $potwor = new Postac\Potwor($przeciwnik);
//                $tura->dodajGracza($postac);
//                $tura->dodajPrzeciwnika($potwor);
//                $tura->losowanie();
//                Serializacja::serialize('tura', $tura, $_SESSION['user_id'], true);
//            } else {
//                echo $tura->wyborprzeciwnika();
//                Serializacja::serialize('tura', $tura, $_SESSION['user_id']);
//            }
//        }
//        if ($_POST['submit'] == "Wybierz akcje") {
//            do {
//                $tura = Serializacja::unserialize($_SESSION['user_id'], 'tura');
//                $akcja1 = ($_POST['akcja']);
//                echo $akcja1;
//                $akcja2 = $tura->akcja2();
//                echo $akcja2;
//                $akcja3 = $tura->akcja3();
//                echo $akcja3;
//                $losowanie = $tura->losowanie();
//                echo $losowanie;
//                Serializacja::serialize('tura', $tura, $_SESSION['user_id'], true);
//            } while ($tura->sprawdzCzyKoniec());
//        }
    }

}
