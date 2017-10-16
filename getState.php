<?php
require_once 'core/init.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    /* DOBAVLJANJE SVIH MESTA PO DRŽAVI */
    $rez = Mesto::getAll($id);
    $output = '';
    /* ISPIS SELECT INPUTA */
    $output .= '<div class="form-group">
                    <label for="grad">Izaberi grad:
                    </label>
                    <select name="grad" id="grad" class="form-control">';
    foreach ($rez as $r) {
        $output .= '<option value="'.$r->mes_id.'">'.$r->mes_naziv.'</option>';
    }
    $output.='</select></div>';
    echo $output;
}