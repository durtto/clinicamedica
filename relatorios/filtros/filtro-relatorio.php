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
            <select id='mesInicio' name='mesInicio'> 
			  	<option value="1" <? if($_SESSION['mesInicio'] == 1){ echo "selected='selected'";}?>>Janeiro</option>
				<option value="2" <? if($_SESSION['mesInicio'] == 2){ echo "selected='selected'";}?>>Fevereiro</option>
				<option value="3" <? if($_SESSION['mesInicio'] == 3){ echo "selected='selected'";}?>>Março</option>
				<option value="4" <? if($_SESSION['mesInicio'] == 4){ echo "selected='selected'";}?>>Abril</option>
				<option value="5" <? if($_SESSION['mesInicio'] == 5){ echo "selected='selected'";}?>>Maio</option>
				<option value="6" <? if($_SESSION['mesInicio'] == 6){ echo "selected='selected'";}?>>Junho</option>
				<option value="7" <? if($_SESSION['mesInicio'] == 7){ echo "selected='selected'";}?>>Julho</option>
				<option value="8" <? if($_SESSION['mesInicio'] == 8){ echo "selected='selected'";}?>>Agosto</option>
				<option value="9" <? if($_SESSION['mesInicio'] == 9){ echo "selected='selected'";}?>>Setembro</option>
				<option value="10" <? if($_SESSION['mesInicio'] == 10){ echo "selected='selected'";}?>>Outubro</option>
				<option value="11" <? if($_SESSION['mesInicio'] == 11){ echo "selected='selected'";}?>>Novembro</option>
				<option value="12" <? if($_SESSION['mesInicio'] == 12){ echo "selected='selected'";}?>>Dezembro</option>
			</select>                  
			
           a
             	  	
            <select id='mesFim' name='mesFim'> 
			  	<option value="1" <? if($_SESSION['mesFim'] == 1){ echo "selected='selected'";}?>>Janeiro</option>
				<option value="2" <? if($_SESSION['mesFim'] == 2){ echo "selected='selected'";}?>>Fevereiro</option>
				<option value="3" <? if($_SESSION['mesFim'] == 3){ echo "selected='selected'";}?>>Março</option>
				<option value="4" <? if($_SESSION['mesFim'] == 4){ echo "selected='selected'";}?>>Abril</option>
				<option value="5" <? if($_SESSION['mesFim'] == 5){ echo "selected='selected'";}?>>Maio</option>
				<option value="6" <? if($_SESSION['mesFim'] == 6){ echo "selected='selected'";}?>>Junho</option>
				<option value="7" <? if($_SESSION['mesFim'] == 7){ echo "selected='selected'";}?>>Julho</option>
				<option value="8" <? if($_SESSION['mesFim'] == 8){ echo "selected='selected'";}?>>Agosto</option>
				<option value="9" <? if($_SESSION['mesFim'] == 9){ echo "selected='selected'";}?>>Setembro</option>
				<option value="10" <? if($_SESSION['mesFim'] == 10){ echo "selected='selected'";}?>>Outubro</option>
				<option value="11" <? if($_SESSION['mesFim'] == 11){ echo "selected='selected'";}?>>Novembro</option>
				<option value="12" <? if($_SESSION['mesFim'] == 12){ echo "selected='selected'";}?>>Dezembro</option>
			</select>           
             	de
            <select id='ano' name='ano'> 
			  	<option value="2008" <? if($_SESSION['ano'] == 2008){ echo "selected='selected'";}?>>2008</option>
				<option value="2009" <? if($_SESSION['ano'] == 2009){ echo "selected='selected'";}?>>2009</option>
				<option value="2010" <? if($_SESSION['ano'] == 2010){ echo "selected='selected'";}?>>2010</option>
				<option value="2011" <? if($_SESSION['ano'] == 2011){ echo "selected='selected'";}?>>2011</option>
				<option value="2012" <? if($_SESSION['ano'] == 2012){ echo "selected='selected'";}?>>2012</option>
				<option value="2013" <? if($_SESSION['ano'] == 2013){ echo "selected='selected'";}?>>2013</option>
				<option value="2014" <? if($_SESSION['ano'] == 2014){ echo "selected='selected'";}?>>2014</option>
				<option value="2015" <? if($_SESSION['ano'] == 2015){ echo "selected='selected'";}?>>2015</option>
			</select>
            </fieldset>
          </fieldset>
		   <!--<fieldset class='categorias'>
              <a id='link-categorias' title='Selecione as categorias para o filtro'>
                Categorias
              </a>
            </fieldset>	-->
          <fieldset class='linha-dois'>
            <fieldset class='exibir'>
              <label for='exibir'>
               Exibir
              </label>
              <select id='exibir' name='exibir'>
                <option value='1'>
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
			
            <fieldset>
              <label>
               Categorias
              </label>
              <select id='categorias' name='categorias'>
			  <option value='null'>
                  Todas
                </option>
			  <?
			$sql = "SELECT cat_categoria, cat_descricao ". 
				"FROM categoriasdemovimentacao ORDER BY cat_descricao ";					
				$resultado = execute_query($sql);
				$i++;
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_categoria  = $linha[0];
					  $descricao  = utf8_decode($linha[1]);
				
			?>		
			  <option value='<?=$cod_categoria?>' <? if($_SESSION['categorias'] == $cod_categoria){ echo "selected='selected'";}?>/>
                <? echo $descricao; ?>
				</option>
                
               <?
			   }
			   
			   ?>
              </select>
			 </fieldset>			
          </fieldset>          
        </fieldset>		
        <!--<div id='categorias-box'>
          <ul>
		  <?
		  $i = 0;
		  ?>
		  <li>
              <label class='checkbox'>
                <input name='categoria_<?=$i?>' value='null' class='checkbox' type='checkbox' />
                Todas
              </label>
            </li>
		  <?
			/*$sql = "SELECT cat_categoria, cat_descricao ". 
				"FROM categoriasdemovimentacao ORDER BY cat_descricao ";					
				$resultado = execute_query($sql);
				$i++;
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_categoria  = $linha[0];
					  $descricao  = utf8_decode($linha[1]);	*/			
			?>		
			
            <li>
              <label class='checkbox'>
                <input name='categorias[]' value='<?=$cod_categoria?>' class='checkbox' type='checkbox' />
                <? echo $descricao; ?>
              </label>
            </li>
			<?
			$i++;			
			//}
			?> 			  
          </ul>
          <a id='ok-categorias-box'>
            Ok
          </a>
        </div>-->
        <fieldset class='buttons'>
          <input value='aplicar filtro' class='submit' type='submit' />
        </fieldset>
      </form>

    </div>



