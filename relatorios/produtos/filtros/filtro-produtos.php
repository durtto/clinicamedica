<?
/*$cliente = $_SESSION['cliente'];
$responsavel = $_SESSION['responsavel'];
$setor = $_SESSION['setor'];
$resultados = $_SESSION['resultados'];*/

/*$ordenarPor = $_SESSION['ordenarPor'];
$ordem = $_SESSION['ordem']; 
*/

$filtrou = $_POST['filtrou'];

if($_POST['resultadosPorPagina'] != '')
{
	$_SESSION['resultados_pagina'] = $_POST['resultadosPorPagina'];
}
if($_POST['marca'] != '')
{
	$_SESSION['marca'] = $_POST['marca'];
}
if( $_POST['ordem'] != '' )
{
	$_SESSION['ordem'] = $_POST['ordem'];
}
if($_POST['ordenarPor'] != '')
{
	$_SESSION['ordenarPor'] = $_POST['ordenarPor'];
}
if( $_POST['categoriaproduto'] != '' )
{
	$_SESSION['categoriaproduto'] = $_POST['categoriaproduto'];
}
if( $_POST['fornecedor'] != '' )
{
	$_SESSION['fornecedor'] = $_POST['fornecedor'];
}
if( $_POST['codbarras'] != '' )
{
	$_SESSION['codbarras'] = $_POST['codbarras'];
}
?>
 <div>
      <form action='impressao.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>			
       <fieldset>        
          <fieldset>
		   
			<fieldset class='produto '>
              <label for='produto'>
                Cód. de Barras
              </label>			 
              <input id='codbarras' name='codbarras' value="<?=$_POST['codbarras']?>" type='text' title="Informe código de barras do produto"/>
            </fieldset> 
		   <fieldset class='cliente'>
              <label for='cliente'>
                Produto
              </label>
              <select id='produto' name='produto'>
                <option value="null">Selecione um produto</option>
				<?
				
				$sql = "SELECT pro_produto, pro_nome ". 
						"FROM produtos ".								
						"ORDER BY pro_nome";		 
			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_produto  = $linha[0];			  
					  $nome_produto = $linha[1];
					  if($cod_produto == $_SESSION['produto'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_produto; ?>' <?=$selected?>>
                <?  echo $nome_produto; ?>
                </option>
				<? 
				}
				?>
                
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
 

