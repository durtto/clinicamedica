<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];
if($_POST['contas'] != '')
{
	$_SESSION['contas'] = $_POST['contas'];
}
if($_POST['inicio'] != '')
{
	$_SESSION['inicio'] = $_POST['inicio'];
}
if($_POST['fim'] != '')
{
	$_SESSION['fim'] = $_POST['fim']; 
}
if( $_POST['ordem'] != '' )
{
	$_SESSION['ordem'] = $_POST['ordem'];
}
$inicio = $_SESSION['inicio'];
$fim = $_SESSION['fim'];
?>
 <div>
      <form action='home-contas.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>
		<?
		$sql = "SELECT con_conta, con_nome ". 
				"FROM contas ".								
				"ORDER BY con_nome";			  
		?>		
       <fieldset>        
          <fieldset>
		   <fieldset class='contas'>
              <label for='contas'>
                Contas
              </label>
              <select id='contas' name='contas'>               
				<?
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_conta  = $linha[0];			  
					  $nome_conta = $linha[1];
					  if($cod_conta == $_SESSION['contas'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_conta; ?>' <?=$selected?>>
                <?  echo $nome_conta; ?>
                </option>
				<? 
				}
				?>
                
              </select>
            </fieldset>		
            <fieldset class='inicio data-mask'>
              <label for='inicio'>
                Período
              </label>
			  <?
			  
			  if($inicio == '' && $fim == '' || strlen($inicio) < 10)
			  {
				$data_inicio = date("d/m/Y");
				list($dia,$mes,$ano)= split("/",$data_inicio);
				if($mes > 1)
				{ 
					$mes = $mes - 1;
					if(strlen($mes)<2){ $mes = "0".$mes; }
				}
				else { $mes = 12;  $ano = $ano-1;}
				$inicio = $data_inicio = $dia."/".$mes."/".$ano;				
				$fim = $data_fim = date("d/m/Y");						  
			}
			  ?>
              <input id='inicio' name='inicio' value='<?=$inicio?>' class='data-mask' type='text' />
              a
              <input id='fim' name='fim' value='<?=$fim?>' class='data-mask' type='text' />
            </fieldset>
			</fieldset>           
         
          
        </fieldset>		
		
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>
</div>
 

