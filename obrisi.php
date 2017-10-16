<?php
require_once 'core/init.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    /* BRISANJE KOMITENTA PO ID-u */
    Komitent::remove($id);
    echo json_encode($id);
}