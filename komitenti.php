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
    <?php include_once('nav.php'); ?>
	<div class="col-md-8 col-md-offset-2">
		<div class="alert-success" id="result"></div>
	</div>
	<div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">Svi komitenti</h2>
        <table class="table table-hover">
              <thead>
                <tr>
                  <th>Mesto</th>
                  <th>Šifra</th>
                  <th>Naziv</th>
                  <th>Opis</th>
                  <th>PIB</th>
                  <th>MBr</th>
                  <th>Vrsta</th>
                  <th>Izmeni</th>
                  <th>Obriši</th>
                </tr>
              </thead>
              <tbody class="lista">
              <?php
                /* DOBAVLJENJE SVIH KOMITENATA */
                $komitenti = Join_tables::sviKomitenti();
                foreach($komitenti as $komitent) {
              ?>
                    <tr>
                        <td><?php echo $komitent->mesto ?></td>
                        <td><?php echo $komitent->sifra ?></td>
                        <td><?php echo $komitent->naziv ?></td>
                        <td><?php echo $komitent->opis ?></td>
                        <td><?php echo $komitent->pib ?></td>
                        <td><?php echo $komitent->mbr ?></td>
                        <td><?php 
                        	if ($komitent->vrsta == 'd') {
                        		echo 'dobavljač';
                        	} elseif ($komitent->vrsta  == 'k') {
                        		echo 'kupac';
                        	}else{
                        		echo 'dobavljač i kupac';
                        	}
                        	?></td>
                        <td><button class='edit-modal btn btn-primary'  >
                            <a style="color:white" href="izmeni.php?id=<?php echo $komitent->id ?>"><span class='glyphicon glyphicon-edit'></span> izmeni</a></button>
                        </td>
                        <!-- FORMA ZA BRISANJE KOMITENTA -->
                        <form action="obrisi.php" method="POST" class='delete_contact' data-id='<?php echo $komitent->id ?>'>
	                        <td><input type="hidden" id="id_number" name="id" value="<?php echo $komitent->id ?>" >
	                           <button class="btn btn-danger" type="submit"><span class='glyphicon glyphicon-trash'></span>Obriši</button>
	                        </td>
                        </form>
                    </tr>
            <?php 
                }
            ?>   
              </tbody>
        </table>
        <!--end of table-->
    </div>

    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">Dodaj komitenta</h2>
        <div class="form-group " id='drzave'>
        	<label for="vrsta">Izaberi državu:</label>
        	<select name="vrsta" class="form-control input-sm chat-input" id = 'state'>
                <option value="Izaberi drzavu">Izaberi drzavu</option>
        		<?php
                /* DOBAVLJENJE SVIH DRŽAVA */ 
        		$drzave = Drzava::all();
        		foreach ($drzave as $drzava) {
        		 ?>
                    <option value="<?php echo $drzava->drz_id ?>"><?php echo $drzava->drz_naziv ?></option>
                <?php
            	}
                ?>
            </select>
        </div>
        <!-- FORMA ZA DODAVANJE NOVOG KOMITENTA -->
        <form method="POST" action="add.php" id="add_contact">
            <div id="gradovi"></div>
            <div class="dodajKom">
                <div class="form-group">
                	<label for="sifra">Šifra*:</label>
                	<input type="number" name="sifra" id="sifra" class="form-control" required>
                </div>
                <div class="form-group ">
                	<label for="naziv">Naziv*:</label>
                	<input type="text" name="naziv" id="naziv" class="form-control" required>
                </div>
                <div class="form-group ">
                	<label for="opis">Opis:</label>
                	<textarea name="opis" id="opis" rows=10 cols=30 class="form-control"></textarea>
                </div>
                <div class="form-group ">
                	<label for="pib">PIB(samo brojevi dozvoljeni):</label>
                	<input type="number" name="pib" id="pib" class="form-control" >
                </div>
                <div class="form-group ">	
                	<label for="mbr">Matični broj(samo brojevi dozvoljeni):</label>
                	<input type="number" name="mbr" id="mbr" class="form-control" >
                </div>
                <div class="form-group ">
                	<label for="klijent">Vrsta komitenta*:</label>
                	<select name="klijent" id="klijent" class="form-control input-sm chat-input">
                        <option value="d">dobavljač</option>
                        <option value="k">kupac</option>
                        <option value="o">dobavljač i kupac</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn crud-submit btn-success">Dodaj komitenta</button>
                </div>
            </div>
        </form>
        <!-- KRAJ FORME -->
    </div>
    <script>
    	$(document).ready(function(){
            $('.dodajKom').hide();
            $('#result').hide();
    	   /* BRISANJE KOMITENTA */
            $('.delete_contact').submit(function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                var c_obj = $(this).parents("tr");

                /*  POTVRDA BRISANJA   */
                if(confirm("Are you sure you want to delete this?")){ 
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'obrisi.php',
                        data:{id:id},
                        success: function (data) {
                            /* UKLANJANJE REDA IZ TABELE
                            I ISPIS PORUKE */
                            c_obj.remove();
                            $('#result').show();
                            $('#result').html('<h3 class="text-center">Kontakt uspešno obrisan</h3>');
                            $('#result').delay(4000).fadeOut();
                            $(".action-container").hide();
                        }
                    })
                }else{
                    return false;
                }   
            })

        /* ODABIR DRŽAVE AJAX-om */
            $('#state').on('change',function(event) {
                event.preventDefault();
                var id = this.value;
                $.ajax({
                    type: 'POST',
                    url: 'getState.php',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        $("#drzave").hide();
                        $('.dodajKom').show();
                        $('#gradovi').html(data);
                        $('#gradovi').show();                     
                    }
                });
            })

            /*   DODAVANJE NOVOG KOMITENTA   */
            $('#add_contact').submit(function(event){
                event.preventDefault();
                var naziv = $("#add_contact").find("input[name='naziv']").val();
                var sifra = $("#add_contact").find("input[name='sifra']").val();
                var opis = $("#add_contact").find("textarea[name='opis']").val();
                var pib = $("#add_contact").find("input[name='pib']").val();
                var mbr = $("#add_contact").find("input[name='mbr']").val();
                var grad = $("#grad option:selected").val();
                var mesto = $("#grad option:selected").text();
                var klijent = $("#klijent option:selected").val();
                var k = $("#klijent option:selected").text();
                //console.log(opis);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: 'add.php',
                    data:{naziv:naziv, sifra:sifra, opis:opis,
                        pib:pib,mbr:mbr,grad:grad,klijent:klijent,mesto:mesto,k:k},
                    success: function (data) {
                        /* ISPIS PORUKE */
                        $('#result').show();
                        $('#result').html('<h3 class="text-center">Komitent uspešno dodat</h3>');
                        $('#result').delay(4000).fadeOut();
                        $('.dodajKom').hide();
                        $("#gradovi").hide();
                        $("#drzave").show();
                        $("#state option[value='Izaberi drzavu']").prop('selected', true);
                        /* RESETOVANJE FORME */
                        $("#naziv").val('');
                        $("#sifra").val('');
                        $("#opis").val('');
                        $("#mbr").val('');
                        $("#pib").val('');
                        
                        /* CRTANJE NOVOG REDA U TABELI */
                        $('.table-hover').append(
                            '<tr><td>'+mesto+'</td>'+
                            '<td>'+sifra+'</td>'+
                            '<td>'+naziv+'</td>'+
                            '<td>'+opis+'</td>'+
                            '<td>'+pib+'</td>'+
                            '<td>'+mbr+'</td>'+
                            '<td>'+k+'</td>'+
                            '<td>Novi komitent</td>'+
                            '<td></td>'+
                            '</tr>');
                        }
                    })        
                })

        })
</script>
</head>
<body>
    </script>
</body>
</html>