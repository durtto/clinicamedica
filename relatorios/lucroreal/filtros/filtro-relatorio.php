<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];

?>
 <div>
      <form action='impressao.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>
          Filtros
        </h3>
		
        <fieldset>
          <fieldset>
	        
				
			
            <fieldset class='inicio data-mask'>
              <label for='inicio'>
                Período
              </label>		  	
              <input type="text" name="inicio" value=""  id="inicio" class="onsubmit:notnull data-mask"/>          
			
           a
           <input type="text" name="fim" value="" id="fim" class="onsubmit:notnull data-mask"/>
            </fieldset>
            
            <fieldset class='inicio data-mask'>
              <label for='inicio'>
                Reserva de Caixa R$:
              </label>		  	
              <input type="text" name="reserva" value="10.000,00"  id="inicio" class="onsubmit:notnull moeda"/>   
          </fieldset>
		  </fieldset>
          </fieldset>
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>

    </div>



