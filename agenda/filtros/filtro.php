<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];

if( $_POST['paciente'] != '' )
{
	$_SESSION['paciente'] = $_POST['paciente'];
}


?>
 <div>
      <form action='historico.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>			
       <fieldset>        
          <fieldset>		   	
			<fieldset class='data '>
              <label for='data'>
               Paciente
              </label>			 
              <select name="paciente">
              <option value='null'>Selecione um paciente</option>
              <?
              $ModelClientes = new ModelClientes();
              $arrayClientes = $ModelClientes->loadClientes();
              for($i=0; $i<sizeof($arrayClientes); $i++)
              {              	
              ?>
              	<option value="<?=$arrayClientes[$i]->get('codcliente')?>" <? if($_SESSION['paciente'] == $arrayClientes[$i]->get('codcliente')){ echo "selected";}?>>
              	<?=utf8_decode($arrayClientes[$i]->get('nomecliente'))?>
              	</option>	
              <? 
              }
              ?>	
              </select>
            </fieldset>        
            
          </fieldset>
        
        </fieldset>		
		
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>
</div>
 

