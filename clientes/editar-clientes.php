<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html id='clientes-cadastro' class='clientes' xmlns='http://www.w3.org/1999/xhtml'>";

include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-clientes/Principal.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");

$cod = $_GET['cod'];
$conn = conecta_banco();

/// BUSCANDO DADOS PESSOAIS ////
$sql = "SELECT	
       		pes_nome, 
       		cli_tipodepessoa, 
       		cli_estahativo, 
       		cli_observacoes, 
       		cli_cpf, 
       		cli_cnpj, 
       		cli_inscricao_rg, 
       		cli_razaosocial, 
       		cli_contato, 
       		cli_endereco, 
       		cli_con_comercial, 
       		cli_con_residencial, 
       		cli_con_celular, 
       		cli_con_email,
       		cli_datanascimento  
       		FROM pessoas 
			INNER JOIN clientes on cli_cliente = pes_pessoa and pes_pessoa = '$cod'";
		
$resultado = $conn->query($sql);			
while ($linha = $resultado->fetchRow()) 
{		 			
		  $nome_cliente  = $linha[0];
		  $tipodecliente  = $linha[1];
		  $situacao  = $linha[2];
		  $observacoes = $linha[3];   	
		  $cpf = $linha[4];
		  $cnpj = $linha[5];
		  $inscricao = $linha[6];
		  $razaosocial = $linha[7];	     
		  $contato = $linha[8];
		  $cod_endereco = $linha[9];
		  $comercial = $linha[10];
		  $residencial = $linha[11];
		  $celular = $linha[12];
		  $email = $linha[13];	
		  $datanascimento = dataparaousuario($linha[14]);		  
} 			
/// BUSCANDO DADOS DE ENDEREÇO///		 
$sql = "SELECT	end_endereco, end_cep, end_logradouro, end_numero, end_complemento, end_bairro, end_estado, end_cidade ". 
				"FROM	enderecos ". 						
				"WHERE end_endereco = '$cod_endereco'";	
							
	$resultado = $conn->query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $cod_endereco  = $linha[0];
			  $cep  = $linha[1];
			  $logradouro  = $linha[2];
			  $numero  = $linha[3];
			  $complemento  = $linha[4];			  
			  $bairro  = $linha[5];			 
			  $com_cod_estado  = $linha[6];				  			  
			  $com_cod_cidade  = $linha[7];			 			
	}

?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-clientes" class="clientes">Clientes</a>
		Clientes > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-clientes">Listagem de Clientes</a>
		<a href="../_funcoes/controller.php?opcao=cadastro-de-clientes">Cadastro de Clientes</a>		
	</li>
</div>

<form id="form-clientes" name="form-clientes" class="form-auto-validated" action="update-clientes.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />      
<input type="hidden" name="cod_endereco" value='<? echo $cod_endereco; ?>' />      
 <h3>
        Cliente
      </h3>
      <fieldset>
        <legend>
          Tipo de cliente
        </legend>

        <fieldset>
          <fieldset class='fisica'>
            <label class='fisica'>
			<? 
			if($tipodecliente =="F")
			{	$checked_fisica = "checked='checked'";
			}else{
				$checked_juridica = "checked='checked'";
			}?>
              <input name='tipoDeCliente' value='fisica'  id="tipoDeCliente" class='radio tipoDeCliente' type='radio' <? echo $checked_fisica; ?>/>
              Pessoa Física
            </label>
          </fieldset>
          <fieldset class='juridica'>
            <label class='fisica'>		
              <input name='tipoDeCliente' value='juridica' id="tipoDeCliente" class='radio tipoDeCliente' type='radio' <? echo $checked_juridica; ?>/>
              Pessoa Jurídica
            </label>
          </fieldset>
          
        </fieldset>
      </fieldset>
      <fieldset id='campos-fisica'>
        <fieldset>
          <fieldset class='pesNome validate=notnull onsubmit:notnull'>

            <label for='pesNome'>
              Nome
            </label>
            <input id='pesNome' maxlength='256' name='pesNome' type='text' value='<? echo $nome_cliente; ?>' />
          </fieldset>
          <fieldset class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              CPF
            </label>
            <input id='pesfCpf' maxlength='14' name='pesfCpf' type='text' value='<? echo $cpf; ?>' />

          </fieldset>
          </fieldset>
          <fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              Data de Nascimento
            </label>
            <input id='nascimento' class="data-mask" name='nascimento' type='text' value='<? echo $datanascimento; ?>' />
          </fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              RG
            </label>
            <input id='pesfRg' maxlength='16' name='pesfRg' type='text' value='<? echo $inscricao; ?>' />
          </fieldset>
        </fieldset>
      </fieldset>

      
      <fieldset id='campos-juridica'>
        <fieldset>
          <fieldset class='pesNome validate=notnull onsubmit:notnull'>

            <label for='pesNome'>
              Nome
            </label>
            <input id='pesNome' maxlength='256' name='pesNome' type='text' value="<?=$nome_cliente?>"/>
          </fieldset>
          <fieldset id="cpf" class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              Razao Social
            </label>
            <input id='razaosocial' name='razaosocial' type='text' value="<?=$razaosocial?>"/>

          </fieldset>
          </fieldset>
          <fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              CNPJ
            </label>
            <input id='cnpj' class="cnpj" name='cnpj' type='text' value="<?=$cnpj?>"/>
          </fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              Inscrição Estadual
            </label>
            <input id='inscricao' maxlength='16' name='inscricao' type='text'  value="<?=$inscricao?>"/>
          </fieldset>          
        </fieldset>
      </fieldset>
      <fieldset>

        <legend>
          Situação
        </legend>
        <fieldset>
		<?
		if($situacao == "S")
		{
		 	$ativo = "checked='checked'";
		}else{ $inativo = "checked='checked'";}
		?>
          <fieldset class='ativo'>		  
            <label class='ativo'>
              <input name='situacao' value='S' class='radio' type='radio' <? echo $ativo;?> />
              Ativo
            </label>
          </fieldset>

          <fieldset class='inativo'>
            <label class='inativo'>
              <input name='situacao' value='N' class='radio' type='radio' <? echo $inativo;?> />
              Inativo
            </label>
          </fieldset>
        </fieldset>
      </fieldset>
      <fieldset>

        <fieldset>
          <fieldset class='cliObservacoes'>
            <label for='cliObservacoes'>
              Observações
            </label>
            <textarea id='cliObservacoes' name='cliObservacoes'><? echo $observacoes; ?></textarea>
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
            <input id='logradouro' maxlength='40' name='logradouro'  type='text'  value="<?=$logradouro?>"/>
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Número
            </label>
            <input id='numero' maxlength='7' name='numero'  type='text'  value="<?=$numero?>"/>
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
            <input id='bairro' maxlength='40' name='bairro' type='text'  value="<?=$bairro?>"/>
          </fieldset>              
        </fieldset>
        <fieldset>
        <fieldset class='cep onsubmit:notnull'>
            <label for='cep'>
              Cep
            </label>
            <input id='cep' maxlength='8' name='cep' type='text' value="<?=$cep?>" />				
          </fieldset>   
         <div id='cid-estado'>
		 </div>
         </fieldset>
      </fieldset>
      <h3>
        Contatos
      </h3>
      <fieldset>
        <fieldset>
          <fieldset class='conComercial telefone-ddd-mask'>
            <label for='conComercial'>
              Telefone comercial
            </label>
            <input id='conComercial' name='conComercial' class="phone" type='text' value='<? echo $comercial; ?>' />

          </fieldset>
          <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Telefone celular
            </label>
            <input id='conCelular' name='conCelular'  type='text' class="phone" value='<? echo $celular; ?>' />
          </fieldset>		 
		  </fieldset>
		  <fieldset>
		   <fieldset class='conComercial telefone-ddd-mask'>
            <label for='conComercial'>
              Telefone residencial
            </label>
            <input id='conResidencial' name='conResidencial' class="phone"  type='text' value='<? echo $residencial; ?>' />

          </fieldset>
          <fieldset class='conEmail'>
            <label for='conEmail'>
              E-mail
            </label>
            <input id='conEmail' name='conEmail' type='text' value='<? echo $email; ?>'/>
          </fieldset>		 
        </fieldset>
      </fieldset>	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-clientes" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
