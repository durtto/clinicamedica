<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];
if($_POST['cliente'] != '')
{
	$_SESSION['cliente'] = $_POST['cliente'];
}
if($_POST['responsavel'] != '')
{
	$_SESSION['responsavel'] = $_POST['responsavel'];
}
if($_POST['resultadosPorPagina'] != '')
{
	$_SESSION['resultados_pagina'] = $_POST['resultadosPorPagina'];
}
if($_POST['inicio'] != '')
{
	$_SESSION['inicio'] = $_POST['inicio'];
}
if($_POST['fim'] != '')
{
	$_SESSION['fim'] = $_POST['fim']; 
}
if($_POST['usardata'] != '')
{
	$_SESSION['usardata'] = $_POST['usardata'];
}
if($_POST['ordenarPor'] != '')
{
	$_SESSION['ordenarPor'] = $_POST['ordenarPor'];
}
if( $_POST['ordem'] != '' )
{
	$_SESSION['ordem'] = $_POST['ordem'];
}
if( $_POST['status'] != '' )
{
	$_SESSION['status'] = $_POST['status'];
}
$inicio = $_SESSION['inicio'];
$fim = $_SESSION['fim'];
?>
 <div>
      <form action='home.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>
		<?
		$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ".								
				"ORDER BY pes_nome";			  
		?>		
        <fieldset>
          <fieldset>
            <fieldset class='cliente'>
              <label for='cliente'>
                Cliente
              </label>
              <select id='cliente' name='cliente'>
                <option value='null'>
                  Todos os clientes
                </option>
				<?
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];			  
					  $nome_cliente = $linha[1];
					  if($cod_cliente == $_SESSION['cliente'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_cliente; ?>' <?=$selected?>>
                <?  echo $nome_cliente; ?>
                </option>
				<? 
				}
				?>
                
              </select>

            </fieldset>
			<fieldset class='responsavel'>
              <label for='responsavel'>
                Responsável
              </label>
              <select id='responsavel' name='responsavel'>
                <option value='null'>
                  Todos os funcionários
                </option>
				<?
				$sql = "SELECT	usu_usuario, pes_nome, usu_login ". 
				"FROM	usuarios ". 
				"INNER JOIN pessoas ".
				"ON usu_usuario = pes_pessoa";	
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_usuario  = $linha[0];			  
					  $nome_usuario = $linha[1];
					  if($cod_usuario == $_SESSION['responsavel'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_usuario; ?>' <?=$selected?>>
                <?  echo $nome_usuario; ?>
                </option>
				<? 
				}
				?>		
              </select>
            </fieldset>		
            <fieldset class='responsavel'>
              <label for='responsavel'>
                Status
              </label>
              <select id='status' name='status'>
                <option value='null'>
                  Qualquer status
                </option>
				<?
				$sql = "SELECT sit_situacao, sit_nome FROM situacoes ORDER BY sit_situacao";	
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $codstatus  = $linha[0];			  
					  $nomestatus = $linha[1];					 
				?>
                <option value='<? echo $codstatus; ?>' <?if($codstatus == $_SESSION['status']){echo "selected";}?>>
                <?  echo $nomestatus; ?>
                </option>
				<? 
				}
				?>		
              </select>
            </fieldset>	           
          </fieldset>
		  
          <fieldset class='linha-dois'>
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
				else { $mes = 12; $ano = $ano-1; }
				$inicio = $data_inicio = $dia."/".$mes."/".$ano;				
				$fim = $data_fim = date("d/m/Y");						  
			}
			  ?>
              <input id='inicio' name='inicio' value='<?=$inicio?>' class='data-mask' type='text' />
              a
              <input id='fim' name='fim' value='<?=$fim?>' class='data-mask' type='text' />
            </fieldset>
            <fieldset class='resultadosPorPagina'>
              <label for='resultadosPorPagina'>
                Usar data:
              </label>

              <select id='usardata' name='usardata'>
                <option value='1' <? if($_SESSION['usardata'] == 1){ echo "selected='selected'";}?>>
                  de criação
                </option>
                <option value='2' <? if($_SESSION['usardata'] == 2){ echo "selected='selected'";}?>>
                 de prazo
                </option>
                
              </select>
            </fieldset>
            <fieldset class='resultadosPorPagina'>
              <label for='resultadosPorPagina'>
                Resultados por página
              </label>

              <select id='resultadosPorPagina' name='resultadosPorPagina'>
                <option value='20' <? if($_SESSION['resultados_pagina'] == 20){ echo "selected='selected'";}?>>
                  20
                </option>
                <option value='40' <? if($_SESSION['resultados_pagina'] == 40){ echo "selected='selected'";}?>>
                  40
                </option>
                <option value='60' <? if($_SESSION['resultados_pagina'] == 60){ echo "selected='selected'";}?>>
                  60
                </option>

                <option value='80' <? if($_SESSION['resultados_pagina'] == 80){ echo "selected='selected'";}?>>
                  80
                </option>
                <option value='100' <? if($_SESSION['resultados_pagina'] == 100){ echo "selected='selected'";}?>>
                  100
                </option>
              </select>
            </fieldset>
           

          </fieldset>
          <fieldset class='tipos-de-ordenacao'>
            <fieldset>
              <fieldset class='asc'>
                <label title='Ordem crescente' class='asc'>
                  <input name='ordem' value='asc' class='radio' type='radio' checked='checked' />
                  cresc.
                </label>
              </fieldset>

              <fieldset class='desc'>
                <label title='Ordem decrescente' class='desc'>
                  <input name='ordem' value='desc' class='radio' type='radio' />
                  decres.
                </label>
              </fieldset>			 
            </fieldset>
          </fieldset>
        </fieldset>		
		
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>
</div>
 

