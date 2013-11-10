<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<html id='fornecedores-cadastro' class='fornecedores' xmlns='http://www.w3.org/1999/xhtml'>";

include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-fornecedores/Principal.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body >";

include("../componentes/cabecalho.php");


$conn = conecta_banco();
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-fornecedores" class="fornecedores">Fornecedores</a>
		Fornecedores > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-fornecedores">Listagem de Fornecedores</a>				
	</li>
</div>

<form id="form-fornecedores" name="form-fornecedores" class="form-auto-validated" action="insert-fornecedores.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />      

 <h3>
        Fornecedor
      </h3>
      <fieldset>
        <legend>
          Tipo de Fornecedor
        </legend>

        <fieldset>
          <fieldset class='fisica'>
            <label class='fisica'>		
              <input name='tipoDeFornecedor' value='fisica' class='radio' type='radio' checked='checked'/>
              Pessoa Física
            </label>
          </fieldset>
          <fieldset class='juridica'>
            <label class='juridica'>			
              <input name='tipoDeFornecedor' value='juridica' class='radio' type='radio'  />
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
            <input id='pesNome' maxlength='256' name='pesNome' class='validate=notnull onsubmit:notnull' type='text' />
          </fieldset>
          <fieldset class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              CPF
            </label>
            <input id='pesfCpf' maxlength='14' name='pesfCpf' class='validate=cpf-null cpf-mask' type='text' />

          </fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              RG
            </label>
            <input id='pesfRg' maxlength='16' name='pesfRg' type='text'  />
          </fieldset>
        </fieldset>
      </fieldset>

      <fieldset id='campos-juridica'>
        <fieldset>
          <fieldset class='pesNomeFantasia validate=notnull onsubmit:notnull'>
            <label for='pesNomeFantasia'>
              Nome Fantasia
            </label>
            <input id='pesNomeFantasia' maxlength='256' name='pesNomeFantasia' class='validate=notnull onsubmit:notnull' type='text' />
          </fieldset>
          <fieldset class='pesjRazaosocial'>

            <label for='pesjRazaosocial'>
              Razão Social
            </label>
            <input id='pesjRazaosocial' maxlength='256' name='pesjRazaosocial' type='text' />
          </fieldset>
          <fieldset class='pesjNomepessoacontato'>
            <label for='pesjNomepessoacontato'>
              Pessoas para contato
            </label>
            <input id='pesjNomepessoacontato' maxlength='40' name='pesjNomepessoacontato' type='text' />

          </fieldset>
        </fieldset>
        <fieldset>
          <fieldset class='pesjCnpj cnpj-mask validate=cnpj-null'>
            <label for='pesjCnpj'>
              CNPJ
            </label>
            <input id='pesjCnpj' maxlength='18' name='pesjCnpj' class='cnpj-mask validate=cnpj-null' type='text' />
          </fieldset>

          <fieldset class='pesjInscricaoestadual numbers-only'>
            <label for='pesjInscricaoestadual'>
              Inscrição Estadual
            </label>
            <input id='pesjInscricaoestadual' maxlength='10' name='pesjInscricaoestadual' class='numbers-only' type='text' />
          </fieldset>
        </fieldset>
      </fieldset>
      <fieldset>

        <legend>
          Situação
        </legend>
        <fieldset>
          <fieldset class='ativo'>
            <label class='ativo'>
              <input name='situacao' value='ativo' class='radio' type='radio' checked='checked' />
              Ativo
            </label>
          </fieldset>

          <fieldset class='inativo'>
            <label class='inativo'>
              <input name='situacao' value='inativo' class='radio' type='radio' />
              Inativo
            </label>
          </fieldset>
        </fieldset>
      </fieldset>
      <fieldset>

        <fieldset>
          <fieldset class='forObservacoes'>
            <label for='forObservacoes'>
              Observações
            </label>
            <textarea id='forObservacoes' name='forObservacoes' ></textarea>
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
            <input id='logradouro' maxlength='40' name='logradouro' class='onsubmit:notnull' type='text' />
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Número
            </label>
            <input id='numero' maxlength='7' name='numero' class='onsubmit:notnull' type='text' />
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
            <input id='bairro' maxlength='40' name='bairro' class='onsubmit:notnull' type='text' />
          </fieldset>              
        </fieldset>
        <fieldset>
        <fieldset class='cep onsubmit:notnull'>
            <label for='cep'>
              Cep
            </label>
            <input id='cep' maxlength='8' name='cep' class='onsubmit:notnull numbers-only' type='text' />
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
            <input id='conComercial' name='conComercial' class='telefone-ddd-mask' type='text' />

          </fieldset>
          <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Telefone celular
            </label>
            <input id='conCelular' name='conCelular' class='telefone-ddd-mask' type='text'  />
          </fieldset>		 
		  </fieldset>
		  <fieldset>
		  <fieldset class='conResidencial'>
            <label for='conResidencial'>
              Telefone residencial
            </label>
            <input id='conResidencial' name='conResidencial' type='text' />
          </fieldset>
          <fieldset class='conEmail'>
            <label for='conEmail'>
              E-mail
            </label>
            <input id='conEmail' name='conEmail' type='text' />
          </fieldset>		  
        </fieldset>
      </fieldset>
	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-fornecedores" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
