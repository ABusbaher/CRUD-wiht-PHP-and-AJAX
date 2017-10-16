<?php

require_once 'core/init.php';
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"
            integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
            crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     
    <title>Test</title>
</head>
<body>
	<?php
    include_once('nav.php');
	if(isset($_GET['id'])) {
      	$id = trim($_GET['id']);
      	if(!empty($id)){
            /* DOBAVLJANJE KOMPONENTA PO ID-u */
        	$komitent = Join_tables::komitent($id);
        	?>
        	<div class="col-md-6 col-md-offset-3">
                <div class="alert-success" id="result1"></div>
        		<h1 class="text-center">Izmeni komitent</h1>
                <?php
                /* DOBAVLJANJE MESTA PO DRŽAVI */
                $id = $komitent->drzId;
                $rez = Mesto::getAll($id);
                ?>

                <!-- FORMA ZA IZMENU KOMITENTA -->
        		<form method="POST" action="change.php" class="edit_contact">
                    <div class="form-group">
                        <label for="grad">Izaberi grad:</label>
                        <select name="grad" id="gradovi" class="form-control">
                            <?php foreach ($rez as $r) { ?>
                            <option value="<?php echo $r->mes_id ?>"><?php echo $r->mes_naziv?></option>
                            <?php } ?>
                        </select>
                    </div>
        			<div class="form-group ">
        				<label for="sifra">Šifra*(samo brojevi dozvoljeni):</label>
        				<input type="number" name="sifra" value="<?php echo $komitent->sifra ?>" class="form-control" required>
        			</div>
        			<div class="form-group ">
        				<label for="naziv">Naziv*:</label>
        				<input type="text" name="naziv" value="<?php echo $komitent->naziv; ?>" class="form-control" required>
        			</div>
                <div class="form-group ">
                    <label for="opis">Opis:</label>
                    <textarea name="opis" id="opis1" rows=10 cols=30 class="form-control"><?php echo $komitent->opis; ?></textarea>
                </div>
        			<div class="form-group ">
        				<label for="pib">PIB(samo brojevi dozvoljeni):</label>
        				<input type="number" name="pib" value="<?php echo $komitent->pib; ?>" class="form-control">
        			</div>
        			<div class="form-group ">	
        				<label for="mbr">Matični broj(samo brojevi dozvoljeni):</label>
        				<input type="number" name="mbr" value="<?php echo $komitent->mbr; ?>" class="form-control">
        			</div>
        			<div class="form-group ">
        				<label for="klijent">Vrsta komitenta*:</label>
        				<select name="klijent" id="klijenti" class="form-control input-sm chat-input">
                			<option value="d">dobavljač</option>
                			<option value="k">kupac</option>
                			<option value="o">dobavljač i kupac</option>
            			</select>
        			</div>
        			<input type="hidden" name="id" value="<?php echo $komitent->id; ?>" class="form-control">
        			<div class="form-group">
            			<button type="submit" class="btn crud-submit btn-success">Izmeni komitenta</button>
        			</div>
        		</form>
                <!-- KRAJ FORME -->
        	</div>

    <?php
        }else{
            header('Location: komitenti.php');
        }
	}else{
        header('Location: komitenti.php');
    }
	?>
<script>
    $(document).ready(function(){
        $('#result1').hide();
        /*   IZMENA KOMITENTA   */
        $('.edit_contact').submit(function(event) {
            event.preventDefault();
            var id = $(".edit_contact").find("input[name='id']").val();
            var naziv = $(".edit_contact").find("input[name='naziv']").val();
            var sifra = $(".edit_contact").find("input[name='sifra']").val();
            var opis = $(".edit_contact").find("textarea[name='opis']").val();
            var pib = $(".edit_contact").find("input[name='pib']").val();
            var mbr = $(".edit_contact").find("input[name='mbr']").val();
            var grad = $("#gradovi option:selected").val();
            var klijent = $("#klijenti option:selected").val();
            //console.log(id);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'change.php',
                data: {id:id,naziv:naziv, sifra:sifra, opis:opis,
                        pib:pib,mbr:mbr,grad:grad,klijent:klijent},
                success: function (data) {
                    /* ISPIS PORUKE */
                    $('#result1').show();
                    $('#result1').html('<h3 class="text-center">Komitent uspešno izmenjen</h3>');
                    $('#result1').delay(4000).fadeOut();
                }
            }) 
        }) 
    })
</script>
</body>
</html>