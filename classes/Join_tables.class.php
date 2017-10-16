<?php
class Join_tables{
    public static function sviKomitenti(){
        $db = Connect::getInstance();
        $className = get_called_class();
        $res = $db->query("SELECT 
            komitent.kom_id AS id, komitent.mes_id,komitent.kom_sifra AS sifra, komitent.kom_naziv AS naziv, komitent.kom_opis AS opis, 
            komitent.kom_pib AS pib, komitent.kom_mbr AS mbr, komitent.kom_vrsta AS vrsta,
            drzava.drz_naziv AS drzava, mesto.mes_naziv AS mesto
                FROM komitent
                LEFT JOIN mesto ON komitent.mes_id = mesto.mes_id 
                LEFT JOIN drzava ON mesto.drz_id = drzava.drz_id 
                ORDER BY komitent.kom_id DESC");
        $arr = array();
        while($r = $res->fetchObject($className)){
            $arr[] = $r;
        }
        return $arr;
    }

    public static function komitent($id){
        $db = Connect::getInstance();
        $className = get_called_class();
        $res = $db->query("SELECT 
            komitent.kom_id AS id,komitent.mes_id,komitent.kom_sifra AS sifra, komitent.kom_naziv AS naziv, komitent.kom_opis AS opis, 
            komitent.kom_pib AS pib, komitent.kom_mbr AS mbr, komitent.kom_vrsta AS vrsta,
            drzava.drz_naziv AS drzava, mesto.mes_naziv AS mesto, 
            drzava.drz_id AS drzId
                FROM komitent
                LEFT JOIN mesto ON komitent.mes_id = mesto.mes_id 
                LEFT JOIN drzava ON mesto.drz_id = drzava.drz_id 
                WHERE komitent.kom_id = $id");
       
       if($res->rowCount() == 0){
            echo '<h3>Nema tog komitenta</h3>';
            $arr = array();
            return $arr;
        }else{          
            while($r = $res->fetchObject($className)){
                return $r;
            }
            return $r;
        }
    }
    
}