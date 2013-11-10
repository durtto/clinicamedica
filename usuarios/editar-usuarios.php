<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-funcionarios/Principal.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");

$cod = $_GET['cod'];


/// BUSCANDO DADOS PROFISSIONAIS E PESSOAIS ////
$sql = "SELECT	usu_usuario, pes_nome, set_setor, usu_login, usu_senha, usu_endereco, usu_telefone, usu_celular, usu_email, usu_ehadministrador ". 
				"FROM	usuarios ". 
				"INNER JOIN pessoas ".
				"ON usu_usuario = pes_pessoa ".
				"INNER JOIN setores ".
				"ON usu_setor = set_setor ".
				"INNER JOIN enderecos ".
				"ON usu_endereco = end_endereco WHERE pes_pessoa = '$cod'";
				
	$resultado = execute_query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $cod_usuario  = $linha[0];
			  $nome_usuario  = $linha[1];
			  $cod_setor  = $linha[2];
			  $login  = $linha[3];			
			  $senha  = $linha[4];
			  $cod_endereco = $linha[5];
			  $telefone = $linha[6];
			  $celular = $linha[7];
			  $email = $linha[8];
			  $ehadministrador = $linha[9];				  	  		
	}	
	///ENDEREÇO///
	$sql = "SELECT	end_logradouro, end_numero, end_complemento, end_bairro, end_cep, end_cidade, end_estado ". 
				"FROM	enderecos ". 
				"WHERE end_endereco = '$cod_endereco'";
				
	$resultado = execute_query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $logradouro  = $linha[0];
			  $numero  = $linha[1];
			  $complemento  = $linha[2];
			  $bairro  = $linha[3];			
			  $cep  = $linha[4];
			  $cod_cidade = $linha[5];
			  $cod_estado = $linha[6];			  			  	  		
	}	
	
	$sql = "SELECT	up_permissao ". 
				"FROM	usuarios_permissoes ". 
				"WHERE up_usuario = '$cod_usuario'";
				
	$resultado = execute_query($sql);	
	$i = 0;		
	while ($linha = $resultado->fetchRow()) 
	{		 						  
			  $permissoes[$i]  = $linha[0];	
			  $i++;		  
	}	
	
	
		
		  			  						  			  						  

?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-usuarios" class="usuarios">Usuários</a>
		Usuários > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-usuarios">Listagem de Usuários</a>
		<a href="../_funcoes/controller.php?opcao=cadastro-de-usuarios">Cadastro de Usuários</a>		
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-usuario.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />
<input type="hidden" name="cod_endereco" value='<? echo $cod_endereco; ?>' />      

<h3>
	Usuário
</h3>     
        <fieldset>
        <fieldset>
          <fieldset class='nome onsubmit:notnull'>
            <label for='nome'>
              Nome
            </label>
            <input id='nome' maxlength='60' name='nome'  type='text' value="<?=$nome_usuario?>" />
          </fieldset>                 
        </fieldset>
      
        <fieldset>        
         <fieldset class='telefone onsubmit:notnull telefone-ddd-mask'>
            <label for='telefone'>
              Telefone
            </label>
            <input id='telefone' maxlength='10' name='telefone' class='phone' type='text' value="<?=$telefone?>" />  
          </fieldset>
		   <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Celular
            </label>
            <input id='celular' name='celular' class='phone' type='text' value="<?=$celular?>"/>
          </fieldset>	
         </fieldset>
         <fieldset>        
         <fieldset class='celular telefone-ddd-mask'>
            <label for='celular'>
              E-mail
            </label>
            <input id='email' maxlength='40' name='email' class='' type='text' value="<?=$email?>" />  
          </fieldset>
         </fieldset>
      </fieldset>

<h3>
	Endereço
</h3>     
        <fieldset>
        <fieldset>
        <fieldset class='logradouro onsubmit:notnull'>
            <label for='logradouro'>
              Logradouro
            </label>
            <input id='logradouro' maxlength='40' name='logradouro' type='text' value="<?=$logradouro?>" />
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Número
            </label>
            <input id='numero' maxlength='7' name='numero'  type='text' value="<?=$numero?>" />
          </fieldset> 
          </fieldset> 
          <fieldset>
          <fieldset class='complemento'>
            <label for='complemento'>
              Complemento
            </label>
            <input id='complemento' maxlength='60' name='complemento' type='text' value="<?=$complemento?>" />
          </fieldset>              
        <fieldset class='bairro onsubmit:notnull' >
            <label for='bairro'>
              Bairro
            </label>
            <input id='bairro' maxlength='40' name='bairro' type='text' value="<?=$bairro?>"/>
          </fieldset>              
        </fieldset>
        <fieldset>
        <fieldset class='cep onsubmit:notnull'>
            <label for='cep'>
              Cep
            </label>
            <input name='cep' class='cep' type='text' value="<?=$cep?>" />
          </fieldset>   
          <fieldset class='cidade onsubmit:notnull'>
            <label for='cidade'>
              Cidade
            </label>
            <select id='cidade' name='cidade' >
             <option value='null'>
                Selecione uma cidade
              </option>
			<?		
				$sql = "SELECT cid_cidade, cid_nome FROM cidades";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cid_cidade  = $linha[0];
					  $cid_nome  = $linha[1];
					  if($cod_cidade == $cid_cidade)
					  {
					  		$selected = "selected";
					  }else{ $selected = "";}					 
					
			?>	
				 <option value='<? echo $cid_cidade;?>' <?=$selected?>>
				 <? echo $cid_nome;?> 
				 </option> 
			<?		  
				}				
				
			?>      
            </select>  
          </fieldset>             
         <fieldset class='estado onsubmit:notnull'>
            <label for='estado'>
              Estado
            </label>
            <select id='estado' name='estado' >
             <option value='null'>
                Selecione um estado
              </option>
			<?		
				$sql = "SELECT est_estado, est_nome FROM estados";
				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $est_estado  = $linha[0];
					  $est_nome  = $linha[1];
					   if($cod_estado == $est_estado)
					  {
					  		$selected = "selected";
					  }else{ $selected = "";}		
					 
			?>	
				 <option value='<? echo $est_estado;?>'  <?=$selected?>>
				 <? echo $est_nome;?> 
				 </option>
			<?		  
				}
				
			?>            
            </select>
          
          </fieldset>
         </fieldset>
      </fieldset>
        
	  <h3>
        Profissionais
      </h3>

      <fieldset>
        <fieldset>
          <fieldset class='funSetor onsubmit:notnull'>
            <label for='funSetor'>
              Setor
            </label>
            <select id='setor' name='setor' class='onsubmit:notnull'>
			<option value='null'>
                Selecione um setor
              </option>
			<?		
				$sql = "SELECT set_setor, set_nome FROM setores";
				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $set_setor  = $linha[0];
					  $set_nome  = $linha[1];
					  if($cod_setor == $set_setor)
					  {
					  		$selected = "selected";
					  }else{ $selected = "";}	
			?>	
				 <option value='<? echo $set_setor;?>' <? echo $selected;?>>
				 <? echo $set_nome;?> 
				 </option>
			<?		  
				}
				$resultado->free();
				
			?>            
            </select>
          </fieldset>         
        </fieldset>
        <fieldset>
          <fieldset class='usuLogin onsubmit:notnull'>

            <label for='usuLogin'>
              Usuário
            </label>
            <input id='login' maxlength='14' name='login' type='text' value="<?=$login?>"/>
          </fieldset>
          <fieldset class='usuSenha onsubmit:notnull'>
            <label for='usuSenha'>
              Senha
            </label>
            <input id='senha' name='senha'  type='password' value="<?=$senha?>"/>

          </fieldset>
          <fieldset class='usuRepetirSenha onsubmit:notnull'>
            <label for='usuRepetirSenha'>
              Repetir senha
            </label>
            <input id='repetirSenha' name='repetirSenha'  type='password' value="<?=$senha?>"/>
          </fieldset>
        </fieldset> 
		</fieldset>
<h3>
     Permissões
</h3>
      <fieldset>
        <fieldset>
          <fieldset class='permissoes onsubmit:notnull'>          		
			<?		
				$sql = "SELECT per_permissao, per_descricao FROM permissoes";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $permissao  = $linha[0];
					  $descricao  = $linha[1];
					  for($x=0;$x<sizeof($permissoes);$x++)
					  {					  		
					  		if($permissoes[$x] == $permissao)
							{														
								$checked = "checked='checked'";									
								break;																
							}else{
								$checked = "";								
							}
					  }				 
			?>	
				  <input type="checkbox" id='permissoes[]' name='permissoes[]' class="radio" value="<?= $permissao?>" <?=$checked?>/>
				  <?=$descricao?>					 
			<?		  
				}
				$resultado->free();				
			?>            
			<input type="checkbox" id='ehadministrador' name='ehadministrador' class="radio" <? if($ehadministrador == "on"){ echo "checked"; }?> />é administrador
            
          </fieldset>         
        </fieldset>
	</fieldset>
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-usuarios" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
