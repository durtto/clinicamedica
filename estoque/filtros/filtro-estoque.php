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
      <form action='home-estoque.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>			
       <fieldset>        
          <fieldset>
		   <fieldset class='produto '>
              <label for='produto'>
                Produto
              </label>			 
              <input id='produto' name='produto' value="<?=$_POST['produto']?>" type='text' title="Informe o nome do produto"/>
            </fieldset>
			<fieldset class='categoriaproduto'>
              <label for='categoriaproduto'>
                Categoria
              </label>
              <select id='categoriaproduto' name='categoriaproduto'>
                <option value='null'>
                  Todos as categorias
                </option>
				<?
				
				$sql = "SELECT catpro_categoriaproduto, catpro_descricao ". 
						"FROM categoriasdeprodutos ".								
						"ORDER BY catpro_descricao";		 
			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_categoria  = $linha[0];			  
					  $nome_categoria = $linha[1];
					  if($cod_categoria == $_SESSION['categoriaproduto'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_categoria; ?>' <?=$selected?>>
                <?  echo $nome_categoria; ?>
                </option>
				<? 
				}
				?>
                
              </select>
            </fieldset>	            
		   <fieldset class='cliente'>
              <label for='cliente'>
                Marca
              </label>
              <select id='marca' name='marca'>
                <option value='null'>
                  Todos as marcas
                </option>
				<?
				
				$sql = "SELECT mar_marca, mar_nome ". 
						"FROM marcas ".								
						"ORDER BY mar_nome";		 
			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_marca  = $linha[0];			  
					  $nome_marca = $linha[1];
					  if($cod_marca == $_SESSION['marca'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_marca; ?>' <?=$selected?>>
                <?  echo $nome_marca; ?>
                </option>
				<? 
				}
				?>
                
              </select>
            </fieldset>	   
			
			</fieldset>
			<fieldset class='linha-dois'>
			<fieldset class='produto '>
              <label for='produto'>
                Cód. de Barras
              </label>			 
              <input id='codbarras' name='codbarras' value="<?=$_POST['codbarras']?>" type='text' title="Informe código de barras do produto"/>
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
				<option value='500' <? if($_SESSION['resultados_pagina'] == 500){ echo "selected='selected'";}?>>
                  500
                </option>
              </select>
            </fieldset>
			 <fieldset class='ordenarPor'>
              <label for='ordenarPor'>
                Ordenar por
              </label>
              <select id='ordenarPor' name='ordenarPor'>
                <option  value='1'>
                  Código
                </option>
                <option value='2' selected='selected'>
                  Nome
                </option>                
                <option value='3'>
                  Marca
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
 

