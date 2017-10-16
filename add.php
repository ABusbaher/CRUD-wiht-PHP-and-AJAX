<?php
require_once 'core/init.php';
if(isset($_POST['grad'],$_POST['naziv'],$_POST['sifra'],$_POST['opis'],$_POST['pib'],$_POST['klijent'],$_POST['mbr'])){
    /*  VALIDACIJA ZA OBAVEZNA POLJA   */
	if(empty($_POST['naziv']) || empty($_POST['klijent']) || empty($_POST['grad'])){
		echo 'Morate popuniti polja označena zvezdicom';
    }else{
        /*   VALIDACIJA ZA NUMERIČKA POLJA    */
        if((!empty($_POST['sifra']) && !is_numeric($_POST['sifra']))||
        (!empty($_POST['pib']) && !is_numeric($_POST['pib']))||
        (!empty($_POST['mbr']) && !is_numeric($_POST['mbr']))){
            echo 'Šifra,PIB i matični broj moraju biti ispisani brojevima';
        }
        else{
            /*   VALIDACIJA ZA JEDINSTVENE UNOSE   */
            if(!empty($_POST['sifra']) && Komitent::notUnique('kom_sifra',$_POST['sifra'])) {
                echo 'Uneta sifra već postoji u bazi izaberi drugu';
            }elseif (!empty($_POST['pib']) && Komitent::notUnique('kom_pib',$_POST['pib'])) {
                echo 'Uneti PIB već postoji u bazi izaberi drugi';
            }elseif (!empty($_POST['mbr']) && Komitent::notUnique('kom_mbr',$_POST['mbr'])) {
                echo 'Uneti Matični broj već postoji u bazi izaberi drugi';
            }else{
                $mesto = $_POST['grad'];
                $naziv = htmlspecialchars($_POST['naziv']);
                $sifra = htmlspecialchars($_POST['sifra']);
                $opis = htmlspecialchars($_POST['opis']);
                $pib = htmlspecialchars($_POST['pib']);
                $mbr = htmlspecialchars($_POST['mbr']);
                $klijent = $_POST['klijent'];
                /*   DODAVANJE NOVOG KOMITENTA  */
                $komitent = new Komitent;
                $komitent->mes_id = $mesto;
                $komitent->kom_sifra = $sifra;
                $komitent->kom_naziv = $naziv;
                $komitent->kom_opis = $opis;
                $pib == "" ? $komitent->kom_pib = 0 : $komitent->kom_pib = $pib;
                $mbr == "" ? $komitent->kom_mbr = 0 : $komitent->kom_mbr = $mbr;
                $komitent->kom_vrsta = $klijent;                      
                $komitent->insert();
                echo json_encode($komitent);
            }  
        }
    }
}