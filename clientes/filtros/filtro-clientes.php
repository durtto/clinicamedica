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
if($_POST['cliente'] != '')
{
	$_SESSION['cliente'] = $_POST['cliente'];
}
if( $_POST['ordem'] != '' )
{
	$_SESSION['ordem'] = $_POST['ordem'];
}
if($_POST['ordenarPor'] != '')
{
	$_SESSION['ordenarPor'] = $_POST['ordenarPor'];
}

?>
 <div>
      <form action='home-clientes.php' class='filtro' method='post'>
	  <input type="hidden" name="filtrou" value="on"  />
        <h3>

          Filtros
        </h3>			
       <fieldset>        
          <fieldset>
		   <fieldset class='nome '>
              <label for='nome'>
                Nome
              </label>			 
              <input id='nome' name='nome' value="<?=$_POST['nome']?>" type='text' title="Informe o nome do cliente"/>
            </fieldset>
			<fieldset class='resultadosPorPagina'>
              <label for='resultadosPorPagina'>
                Resultados por página
              </label>

              <select id='resultadosPorPagina' name='resultadosPorPagina'>
                
               
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
                <option value='2'  <? if($_SESSION['ordenarPor'] == 2){ echo "selected='selected'";}?>>
                  Nome
                </option>    
				<option value='1'  <? if($_SESSION['ordenarPor'] == 1){ echo "selected='selected'";}?>>
                  Código
                </option>
                                            
              </select>
            </fieldset>
          </fieldset>
          
        </fieldset>		
		
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>
</div>
 

