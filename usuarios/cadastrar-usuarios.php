<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-funcionarios/Principal.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>

<div id="menu-secao">
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-usuarios" class="usuarios">Usuários</a>
		Usuários > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-usuarios">Listagem de Usuários</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./insert-usuario.php" method="post" enctype="multipart/form-data">
      

<h3>
	Usuário
</h3>     
        <fieldset>
        <fieldset>
          <fieldset class='nome onsubmit:notnull'>
            <label for='nome'>
              Nome
            </label>
            <input id='nome' maxlength='60' name='nome' type='text' />
          </fieldset>                 
        </fieldset>
      
        <fieldset>        
         <fieldset class='telefone onsubmit:notnull telefone-ddd-mask'>
            <label for='telefone'>
              Telefone
            </label>
            <input id='telefone' maxlength='10' name='telefone' class='phone' type='text' />  
          </fieldset>
		   <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Celular
            </label>
            <input id='celular' name='celular' class='phone' type='text'  />
          </fieldset>	
         </fieldset>
         <fieldset>        
         <fieldset class='celular telefone-ddd-mask'>
            <label for='celular'>
              E-mail
            </label>
            <input id='email' maxlength='40' name='email' class='' type='text' />  
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
            <input id='logradouro' maxlength='40' name='logradouro' class='' type='text' />
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Número
            </label>
            <input id='numero' maxlength='7' name='numero' class='' type='text' />
          </fieldset> 
          </fieldset> 
          <fieldset>
          <fieldset class='complemento'>
            <label for='complemento'>
              Complemento
            </label>
            <input id='complemento' maxlength='60' name='complemento' type='text' />
          </fieldset>              
        <fieldset class='bairro onsubmit:notnull' >
            <label for='bairro'>
              Bairro
            </label>
            <input id='bairro' maxlength='40' name='bairro' class='' type='text' />
          </fieldset>              
        </fieldset>
        <fieldset>
        <fieldset class='cep onsubmit:notnull'>
            <label for='cep'>
              Cep
            </label>
            <input  maxlength='9' name='cep' class='cep' type='text' />
          </fieldset>   
          <fieldset class='cidade onsubmit:notnull'>
            <label for='cidade'>
              Cidade
            </label>
            <select id='cidade' name='cidade' class=''>
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
					 
					
			?>	
				 <option value='<? echo $cid_cidade;?>' >
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
            <select id='estado' name='estado' class=''>
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
					 
			?>	
				 <option value='<? echo $est_estado;?>'>
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
			?>	
				 <option value='<? echo $set_setor;?>'>
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
            <input id='login' maxlength='14' name='login' class='' type='text' />
          </fieldset>
          <fieldset class='usuSenha onsubmit:notnull'>
            <label for='usuSenha'>
              Senha
            </label>
            <input id='senha' maxlength='10' name='senha' class='' type='password' />

          </fieldset>
          <fieldset class='usuRepetirSenha onsubmit:notnull'>
            <label for='usuRepetirSenha'>
              Repetir senha
            </label>
            <input id='repetirSenha' name='repetirSenha' class='' type='password' />
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
			?>	
				  <input type="checkbox" id='permissoes[]' name='permissoes[]' class="radio" value="<?= $permissao?>" />
				  <?=$descricao?>					 
			<?		  
				}
				$resultado->free();
				
			?>    
			<input type="checkbox" id='ehadministrador' name='ehadministrador' class="radio" />é administrador
            
          </fieldset>         
        </fieldset>
	</fieldset>
		
      
<fieldset class="buttons">
<input value="Cancelar" class="reset action:/decorcasa/_funcoes/controller.php?opcao=home-usuarios" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
