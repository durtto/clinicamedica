<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];
if($_POST['sacado'] != '')
{
	$_SESSION['sacado'] = $_POST['sacado'];
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
if($_POST['exibir'] != '')
{
	$_SESSION['exibir'] = $_POST['exibir'];
}
if( $_POST['ordem'] != '' )
{
	$_SESSION['ordem'] = $_POST['ordem'];
}
if($_POST['ordenarPor'] != '')
{
	$_SESSION['ordenarPor'] = $_POST['ordenarPor'];
}
if($_POST['categoria'] != '')
{
	$_SESSION['categoria'] = $_POST['categoria'];
}
$inicio = $_SESSION['inicio'];
$fim = $_SESSION['fim'];
?>
 <div>
      <form action='home-financeiro.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>
		
        <fieldset>
          <fieldset>
            <fieldset class='sacado'>
              <label for='sacado'>
                Sacado
              </label>
              <select id='sacado' name='sacado'>
                 <option value='null'>---=== Clientes ===---</option>          
			<?		
				$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ".								
				"WHERE cli_estahativo = 's' ORDER BY pes_nome";
					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];
					  $nome_cliente  = $linha[1];								
			?>	
				 <option value='<? echo $cod_cliente;?>' <? if($_SESSION['sacado'] == $cod_cliente){ echo "selected='selected'";}?> >
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
			          
			
			<?		
				$sql = "SELECT for_fornecedor, for_estahativo, pes_nome ". 
				"FROM fornecedores ".				
				"INNER JOIN ".
				"pessoas ON for_fornecedor = pes_pessoa ".							
				"ORDER BY pes_nome";
					
				$resultado = execute_query($sql);
				if($resultado -> numRows>0)
				{
				?>
				<option value='null'>---=== Fornecedores ===---</option>
				<?
					while ($linha = $resultado->fetchRow()) 
					{		 			
						  $cod_fornecedor  = $linha[0];
						  $nome_fornecedor  = $linha[2];								
				?>	
					 <option value='<? echo $cod_fornecedor;?>' <?=$selected?> >
					 <? echo $nome_fornecedor;?> 
					 </option> 
				<?		  
					}				
				}
			?>      
                
              </select>
            </fieldset>	

            <fieldset class='categoria'>
              <label for='categoria'>
                Categoria
              </label>
              <select id='categoria' name='categoria'>
                 <option value='null'>Todas</option>          
			<?		
				$sql = "SELECT cat_categoria, cat_descricao, gcat_descricao ". 
				"FROM categoriasdemovimentacao INNER JOIN gruposcategorias ON gcat_grupo = cat_grupo ORDER BY cat_grupo, cat_descricao";					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_categoria  = $linha[0];
					  $descricao  = $linha[1];								
					  $descGrupo = $linha[2];
			?>	
				 <option value='<? echo $cod_categoria;?>' <? if($_SESSION['categoria'] == $cod_categoria){ echo "selected='selected'";}?>>
				 <? echo $descGrupo." - ".$descricao;?> 
				 </option> 
			<?		  
				}				
			?>                  
            </select>
            </fieldset>	
			<fieldset class='exibir'>
              <label for='exibir'>
               Exibir
              </label>
              <select id='exibir' name='exibir'>
                <option selected='selected' value='1'>
                  Todas
                </option>
                <option value='2' <? if($_SESSION['exibir'] == 2){ echo "selected='selected'";}?>>
                  Pagas
                </option>                
                <option value='3' <? if($_SESSION['exibir'] == 3){ echo "selected='selected'";}?>>
                  Não pagas
                </option>
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
				else { $mes = 12; $ano = $ano - 1; }
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
            <fieldset class='ordenarPor'>
              <label for='ordenarPor'>

                Ordenar por
              </label>
              <select id='ordenarPor' name='ordenarPor'>
                <option selected='selected' value='1'>
                  Código
                </option>
                <option value='2'>
                  Sacado
                </option>
                <option value='3'>
                  Vencimento
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



