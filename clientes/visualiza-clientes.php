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
$sql = "SELECT	pes_nome, pes_tipodepessoa, cli_estahativo, cli_observacoes from pessoas".
		" inner join clientes on cli_pessoa = pes_pessoa and pes_pessoa = '$cod'";
$resultado = $conn->query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $nome_cliente  = utf8_decode($linha[0]);
			  $tipodecliente  = $linha[1];
	  		  $situacao  = $linha[2];
			  $observacoes = utf8_decode($linha[3]);   		     
	} 	
	if($tipodecliente == 1)
	{
		$sql2 = "SELECT	pesf_cpf, pesf_rg ". 
				"FROM	pessoasfisicas ". 
				"WHERE pesf_pessoa = '$cod'";
		$resultado = $conn->query($sql2);			
		while ($linha = $resultado->fetchRow()) 
		{		 			
				  $cpf  = $linha[0];
				  $rg  = $linha[1];
		}		
	}else{
		$sql2 = "SELECT	pesj_razaosocial, pesj_cnpj, pesj_inscricaoestadual, pesj_nomepessoacontato ". 
				"FROM	pessoasjuridicas ". 
				"WHERE pesj_pessoa = '$cod'";
				
		$resultado = $conn->query($sql2);			
		while ($linha = $resultado->fetchRow()) 
		{		 			
				  $razaosocial  = utf8_decode($linha[0]);
				  $cnpj  = $linha[1];
				  $inscricao  = $linha[2];
				  $nome_contato  = utf8_decode($linha[3]);	
		}		
	}
	
		
/// BUSCANDO DADOS DE ENDEREÇO COMERCIAL ////		 
$sql = "SELECT	end_endereco, end_cep, end_logradouro, end_numero, end_complemento, end_bairro, pese_pessoa, pese_endereco, cep_cep, cep_estado, cep_cidade ". 
				"FROM	enderecos ". 
				"INNER JOIN pessoasenderecos ".
				"ON end_endereco = pese_endereco ".
				"INNER JOIN ceps ".
				"ON cep_cep = end_cep ".				
				"WHERE pese_pessoa = '$cod' and pese_tipodeendereco = 2";	
							
	$resultado = $conn->query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $com_cod_endereco  = utf8_decode($linha[0]);
			  $com_cep  = $linha[1];
			  $com_logradouro  = utf8_decode($linha[2]);
			  $com_numero  = $linha[3];
			  $com_complemento  = utf8_decode($linha[4]);			  
			  $com_bairro  = utf8_decode($linha[5]);	
			  $com_cod_pessoa  = $linha[6];	
			  $com_codpessoaendereco  = $linha[7];				  
			  $com_cep  = $linha[8];	
			  $com_cod_estado  = $linha[9];				  			  
			  $com_cod_cidade  = $linha[10];
			  $com_tipoendereco  = $linha[11];				
	}
			 			
/// BUSCANDO DADOS DE ENDEREÇO DE COBRANÇA ////		 
$sql = "SELECT	end_endereco, end_cep, end_logradouro, end_numero, end_complemento, end_bairro, pese_pessoa, pese_endereco, cep_cep, cep_estado, cep_cidade ". 
				"FROM	enderecos ". 
				"INNER JOIN pessoasenderecos ".
				"ON end_endereco = pese_endereco ".
				"INNER JOIN ceps ".
				"ON cep_cep = end_cep ".				
				"WHERE pese_pessoa = '$cod' and pese_tipodeendereco = 3";	
							
	$resultado = $conn->query($sql);			
	while ($linha = $resultado->fetchRow()) 
	{		 			
			  $cob_cod_endereco  = $linha[0];
			  $cob_cep  = $linha[1];
			  $cob_logradouro  = utf8_decode($linha[2]);
			  $cob_numero  = $linha[3];
			  $cob_complemento  = utf8_decode($linha[4]);			  
			  $cob_bairro  = utf8_decode($linha[5]);	
			  $cob_cod_pessoa  = $linha[6];	
			  $cob_codpessoaendereco  = $linha[7];				  
			  $cob_cep  = $linha[8];	
			  $cob_cod_estado  = $linha[9];				  			  
			  $cob_cod_cidade  = $linha[10];
			  $cob_tipoendereco  = $linha[11];		
	}		
	
	
/// BUSCANDO OS CONTATOS ////	
$sql1 = "select con_contato from contatos WHERE con_pessoa = '$cod' AND con_tipodecontato = 1";	
$sql2 = "select con_contato from contatos WHERE con_pessoa = '$cod' AND con_tipodecontato = 3";					
$sql3 = "select con_contato from contatos WHERE con_pessoa = '$cod' AND con_tipodecontato = 4";					
$sql4 = "select con_contato from contatos WHERE con_pessoa = '$cod' AND con_tipodecontato = 5";					
$sql5 = "select con_contato from contatos WHERE con_pessoa = '$cod' AND con_tipodecontato = 6";					
							
$resultado1 = $conn->query($sql1);			
$resultado2 = $conn->query($sql2);			
$resultado3 = $conn->query($sql3);			
$resultado4 = $conn->query($sql4);			
$resultado5 = $conn->query($sql5);			

$linha1 = $resultado1->fetchRow(); 
$linha2 = $resultado2->fetchRow();
$linha3 = $resultado3->fetchRow(); 
$linha4 = $resultado4->fetchRow(); 
$linha5 = $resultado5->fetchRow(); 

$comercial  = $linha1[0];	  		  			  						  			  						  
$fax  = $linha2[0];	  		  			  						  			  						  
$celular  = $linha3[0];	  		  			  						  			  						  
$email  = $linha4[0];	  		  			  						  			  						  
$site  = $linha5[0];	  		  			  						  			  						  

?>

<div id="menu-secao">
	<li>
		<a href="/grise/_funcoes/controller.php?opcao=home-clientes" class="clientes">Clientes</a>
		Clientes > Visualização
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="/grise/_funcoes/controller.php?opcao=home-clientes">Listagem de Clientes</a>
		<a href="/grise/_funcoes/controller.php?opcao=cadastro-de-clientes">Cadastro de Clientes</a>		
	</li>
</div>

<form id="form-clientes" name="form-clientes" class="form-auto-validated" action="update-clientes.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />      
<input type="hidden" name="cod_enderecopadrao" value='<? echo $com_cod_endereco; ?>' />      
<input type="hidden" name="cod_enderecocobranca" value='<? echo $cob_cod_endereco; ?>' />      

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
			if($tipodecliente ==1)
			{	$checked_fisica = "checked='checked'";
			}?>
              <input name='tipoDeCliente' value='fisica' class='radio' type='radio' <? echo $checked_fisica; ?> disabled="disabled"/>
              Pessoa Física
            </label>
          </fieldset>
          <fieldset class='juridica'>
            <label class='juridica'>
			<? 
			if($tipodecliente ==2)
			{	$checked_juridica = "checked='checked'";
			}?>
              <input name='tipoDeCliente' value='juridica' class='radio' type='radio' <? echo $checked_juridica; ?> disabled="disabled"/>
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
            <input id='pesNome' maxlength='256' name='pesNome' class='validate=notnull onsubmit:notnull' type='text' value='<? echo $nome_cliente; ?>'disabled="disabled" />
          </fieldset>
          <fieldset class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              CPF
            </label>
            <input id='pesfCpf' maxlength='14' name='pesfCpf' class='validate=cpf-null cpf-mask' type='text' value='<? echo $cpf; ?>' disabled="disabled"/>

          </fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              RG
            </label>
            <input id='pesfRg' maxlength='16' name='pesfRg' type='text' value='<? echo $rg; ?>' disabled="disabled"/>
          </fieldset>
        </fieldset>
      </fieldset>

      <fieldset id='campos-juridica'>
        <fieldset>
          <fieldset class='pesNomeFantasia validate=notnull onsubmit:notnull'>
            <label for='pesNomeFantasia'>
              Nome Fantasia
            </label>
            <input id='pesNomeFantasia' maxlength='256' name='pesNomeFantasia' class='validate=notnull onsubmit:notnull' type='text' value='<? echo $nome_cliente; ?>' disabled="disabled"/>
          </fieldset>
          <fieldset class='pesjRazaosocial'>

            <label for='pesjRazaosocial'>
              Razão Social
            </label>
            <input id='pesjRazaosocial' maxlength='256' name='pesjRazaosocial' type='text' value='<? echo $razaosocial; ?>' disabled="disabled"/>
          </fieldset>
          <fieldset class='pesjNomepessoacontato'>
            <label for='pesjNomepessoacontato'>
              Pessoas para contato
            </label>
            <input id='pesjNomepessoacontato' maxlength='40' name='pesjNomepessoacontato' type='text' value='<? echo $nome_contato; ?>' disabled="disabled"/>

          </fieldset>
        </fieldset>
        <fieldset>
          <fieldset class='pesjCnpj cnpj-mask validate=cnpj-null'>
            <label for='pesjCnpj'>
              CNPJ
            </label>
            <input id='pesjCnpj' maxlength='18' name='pesjCnpj' class='cnpj-mask validate=cnpj-null' type='text' value='<? echo $cnpj; ?>' disabled="disabled"/>
          </fieldset>

          <fieldset class='pesjInscricaoestadual numbers-only'>
            <label for='pesjInscricaoestadual'>
              Inscrição Estadual
            </label>
            <input id='pesjInscricaoestadual' maxlength='10' name='pesjInscricaoestadual' class='numbers-only' type='text' value='<? echo $inscricao; ?>' disabled="disabled"/>
          </fieldset>
        </fieldset>
      </fieldset>
      <fieldset>

        <legend>
          Situação
        </legend>
        <fieldset>
		<?
		if($situacao == "s")
		{
		 	$ativo = "checked='checked'";
		}else{ $inativo = "checked='checked'";}
		?>
          <fieldset class='ativo'>		  
            <label class='ativo'>
              <input name='situacao' value='ativo' class='radio' type='radio' <? echo $ativo;?> disabled="disabled"/>
              Ativo
            </label>
          </fieldset>

          <fieldset class='inativo'>
            <label class='inativo'>
              <input name='situacao' value='inativo' class='radio' type='radio' <? echo $inativo;?>disabled="disabled" />
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
            <textarea id='cliObservacoes' name='cliObservacoes' disabled="disabled"><? echo $observacoes; ?></textarea>
          </fieldset>
        </fieldset>
      </fieldset>

      <ul class="abas">
        <li>
          <a class="selecionada" id="enderecoPadraoAba">

            Endereço padrão
          </a>
        </li>
        <li>
          <a class="" id="enderecoCobrancaAba">
            Endereço de cobrança
          </a>
        </li>
      </ul>
      <fieldset id="enderecoPadrao" class="endereco-padrao-aba">  
        <fieldset>
          <fieldset class='endPadraoLogradouro onsubmit:notnull'>
            <label for='endPadraoLogradouro'>
              Logradouro
            </label>
            <input id='endPadraoLogradouro' name='endPadraoLogradouro' maxlength='60' class='onsubmit:notnull' type='text' value='<? echo $com_logradouro; ?>' disabled="disabled" />

          </fieldset>
          <fieldset class='endPadraoNumero onsubmit:notnull'>
            <label for='endPadraoNumero'>
              Número
            </label>
            <input id='endPadraoNumero' maxlength='10' name='endPadraoNumero' class='onsubmit:notnull' type='text' value='<? echo $com_numero; ?>' disabled="disabled"/>
          </fieldset>
          <fieldset class='endPadraoComplemento'>
            <label for='endPadraoComplemento'>

              Complemento
            </label>
            <input id='endPadraoComplemento' maxlength='20' name='endPadraoComplemento' type='text' value='<? echo $com_complemento; ?>'disabled="disabled" />
          </fieldset>
      </fieldset>
	  
		<fieldset>
          <fieldset class='endPadraoCep numbers-only onsubmit:notnull'>
            <label for='endPadraoCep'>
              CEP
            </label>
            <input id='endPadraoCep' maxlength='8' name='endPadraoCep' class='numbers-only onsubmit:notnull' type='text' value='<? echo $com_cep; ?>' disabled="disabled"/>
          </fieldset>
		  <fieldset class='endPadraoBairro onsubmit:notnull'>
            <label for='endPadraoBairro'>
              Bairro
            </label>
            <input id='endPadraoBairro' maxlength='24' name='endPadraoBairro' class='onsubmit:notnull' type='text' value='<? echo $com_bairro; ?>'  disabled="disabled"/>
          </fieldset>

        </fieldset>
        <fieldset>
         
		  <fieldset class='cidPadraoCidade onsubmit:notnull'>
            <label for='cidPadraoCidade'>
              Cidade
            </label>            
			<select id='cidPadraoCidade' name='cidPadraoCidade' class='onsubmit:notnull' disabled="disabled">
			<option value='null'>
                Selecione uma cidade
              </option>
			<?		
				$sql = "SELECT cid_cidade, cid_nome FROM cidades";				
				$resultado = $conn->query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cid_cidade  = $linha[0];
					  $cid_nome  = $linha[1];
					  if($com_cod_cidade == $cid_cidade)
					{
						$selected = "selected";
					}else{ $selected = "";}
					
			?>	
				 <option value='<? echo $cid_cidade;?>' <? echo $selected; ?>>
				 <? echo utf8_decode($cid_nome);?> 
				 </option> 
			<?		  
				}				
				
			?>            
            </select>
          </fieldset>
		  <fieldset class='estPadraoEstado onsubmit:notnull'>
            <label for='estPadraoEstado'>
              Estado
            </label>
            
			<select id='estPadraoEstado' name='estPadraoEstado' class='onsubmit:notnull' disabled="disabled">
			<option value='null'>
                Selecione um estado
              </option>
			<?		
				$sql = "SELECT est_estado, est_nome FROM estados";
				
				$resultado = $conn->query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $est_estado  = $linha[0];
					  $est_nome  = $linha[1];
					  if($com_cod_estado == $est_estado)
					{
						$selected = "selected";
					}else{ $selected = "";}
			?>	
				 <option value='<? echo $est_estado;?>' <? echo $selected; ?> disabled="disabled">
				 <? echo utf8_decode($est_nome);?> 
				 </option>
			<?		  
				}
				
			?>            
            </select>
          </fieldset>
       
           
	<fieldset class='cidPadraoNome'>
            <label for='cidPadraoNome'>
              Outra cidade
            </label>
            <input id='cidPadraoNome' maxlength='50' name='cidPadraoNome' type='text' disabled="disabled"/>
          </fieldset>         
        </fieldset>
      </fieldset>
  <fieldset id="enderecoCobranca" class="endereco-cobranca-aba">
	        <fieldset>
          <fieldset class='endCobrancaLogradouro onsubmit:notnull'>
            <label for='endCobrancaLogradouro'>
              Logradouro
            </label>
            <input id='endCobrancaLogradouro' name='endCobrancaLogradouro' maxlength='60' class='onsubmit:notnull' type='text' value='<? echo $cob_logradouro; ?>' disabled="disabled"/>

          </fieldset>
          <fieldset class='endCobrancaNumero onsubmit:notnull'>
            <label for='endCobrancaNumero'>
              Número
            </label>
            <input id='endCobrancaNumero' maxlength='10' name='endCobrancaNumero' class='onsubmit:notnull' type='text' value='<? echo $cob_numero; ?>' disabled="disabled"/>
          </fieldset>
          <fieldset class='endCobrancaComplemento'>
            <label for='endCobrancaComplemento'>

              Complemento
            </label>
            <input id='endCobrancaComplemento' maxlength='20' name='endCobrancaComplemento' type='text' value='<? echo $cob_complemento; ?>' disabled="disabled"/>
          </fieldset>
      </fieldset>
	  
		<fieldset>
          <fieldset class='endCobrancaCep numbers-only onsubmit:notnull'>
            <label for='endCobrancaCep'>
              CEP
            </label>
            <input id='endCobrancaCep' maxlength='8' name='endCobrancaCep' class='numbers-only onsubmit:notnull' type='text' value='<? echo $cob_cep; ?>' disabled="disabled"/>
          </fieldset>
		  <fieldset class='endBairro onsubmit:notnull'>
            <label for='endCobrancaBairro'>
              Bairro
            </label>
            <input id='endCobrancaBairro' maxlength='24' name='endCobrancaBairro' class='onsubmit:notnull' type='text' value='<? echo $cob_bairro; ?>'  disabled="disabled"/>
          </fieldset>

        </fieldset>
        <fieldset>
         
		  <fieldset class='cidCobrancaCidade onsubmit:notnull'>
            <label for='cidCobrancaCidade'>
              Cidade
            </label>            
			<select id='cidCobrancaCidade' name='cidCobrancaCidade' class='onsubmit:notnull' disabled="disabled">
			<option value='null'>
                Selecione uma cidade
              </option>
			<?		
				$sql = "SELECT cid_cidade, cid_nome FROM cidades";
				
				$resultado = $conn->query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cid_cidade  = $linha[0];
					  $cid_nome  = $linha[1];
					  if($cob_cod_cidade == $cid_cidade)
					{
						$selected = "selected";
					}else{ $selected = "";}
					
			?>	
				 <option value='<? echo $cid_cidade;?>' <? echo $selected; ?> disabled="disabled">
				 <? echo utf8_decode($cid_nome);?> 
				 </option> 
			<?		  
				}			
				
			?>            
            </select>
          </fieldset>
		  <fieldset class='estCobrancaEstado onsubmit:notnull'>
            <label for='estCobrancaEstado'>
              Estado
            </label>
            
			<select id='estCobrancaEstado' name='estCobrancaEstado' class='onsubmit:notnull' disabled="disabled">
			<option value='null'>
                Selecione um estado
              </option>
			<?		
				$sql = "SELECT est_estado, est_nome FROM estados";
				
				$resultado = $conn->query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $est_estado  = $linha[0];
					  $est_nome  = $linha[1];
					  if($cob_cod_estado == $est_estado)
					{
						$selected = "selected";
					}else{ $selected = "";}
			?>	
				 <option value='<? echo $est_estado;?>' <? echo $selected; ?> disabled="disabled">
				 <? echo utf8_decode($est_nome);?> 
				 </option>
			<?		  
				}
				
			?>            
            </select>
          </fieldset>
       
           
			<fieldset class='cidCobrancaNome'>
            <label for='cidCobrancaNome'>
              Outra cidade
            </label>
            <input id='cidCobrancaNome' maxlength='50' name='cidCobrancaNome' type='text' disabled="disabled"/>
          </fieldset>         
        </fieldset>
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
            <input id='conComercial' name='conComercial' class='telefone-ddd-mask' type='text' value='<? echo $comercial; ?>' disabled="disabled"/>

          </fieldset>
          <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Telefone celular
            </label>
            <input id='conCelular' name='conCelular' class='telefone-ddd-mask' type='text' value='<? echo $celular; ?>' disabled="disabled"/>
          </fieldset>
		  <fieldset class='conFax telefone-ddd-mask'>
            <label for='conFax'>
              Fax
            </label>
            <input id='conFax' name='conFax' class='telefone-ddd-mask' type='text' value='<? echo $fax; ?>' disabled="disabled"/>
          </fieldset>
		  </fieldset>
		  <fieldset>
          <fieldset class='conEmail'>
            <label for='conEmail'>
              E-mail
            </label>
            <input id='conEmail' name='conEmail' type='text' value='<? echo $email; ?>' disabled="disabled"/>
          </fieldset>
		  <fieldset class='conSite'>
            <label for='conSite'>
              Site
            </label>
            <input id='conSite' name='conSite' type='text' value='<? echo $site; ?>' disabled="disabled"/>
          </fieldset>
        </fieldset>
      </fieldset>
	<h3>
	Descrição
	</h3>
	<fieldset>
    <?
	
	$sql = "SELECT perpc_perguntapadraocliente, perpc_ordem, perpc_pergunta, clip_resposta ".
		   "FROM perguntaspadraoclientes ".
			"inner join clientesperguntas on clip_perguntapadraocliente = perpc_perguntapadraocliente ".
			"where clip_pessoa = '$cod' order by perpc_ordem";
			
	$resultado = $conn->query($sql);
	while($linha = $resultado->fetchRow()) 
	{
		$perc_cli = utf8_decode($linha[0]);
		$perc_ordem = utf8_decode($linha[1]);
		$pergunta = utf8_decode($linha[2]);
		$resposta = utf8_decode($linha[3]);
	?>	
		<fieldset>
          <label for='pergunta[]'>
            <? echo $pergunta; ?>
          </label>
          <textarea name='pergunta_<? echo $perc_cli;?>' class='onsubmit:notnull' disabled="disabled"><? echo $resposta; ?></textarea>
        </fieldset>
	<? 
	} 
	$resultado->free();
	$conn->disconnect();
	?>
	

</form>
</body>
</html>
