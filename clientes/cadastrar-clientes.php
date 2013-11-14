<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<html id='clientes-cadastro' class='clientes' xmlns='http://www.w3.org/1999/xhtml'>";

include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-clientes/Principal.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body >";

include("../componentes/cabecalho.php");


$conn = conecta_banco();
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-clientes" class="clientes">Clientes</a>
		Clientes > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-clientes">Listagem de Clientes</a>				
	</li>
</div>

<form id="form-clientes" name="form-clientes" class="form-auto-validated" action="insert-clientes.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />      

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
              <input name='tipoDeCliente' value='fisica' id="tipoDeCliente" class='radio tipoDeCliente' type='radio' checked='checked'/>
              Pessoa Física
            </label>
          </fieldset>
          <fieldset class='juridica'>
            <label class='fisica'>		
              <input name='tipoDeCliente' value='juridica' id="tipoDeCliente" class='radio tipoDeCliente' type='radio'/>
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
            <input id='pesNome' maxlength='256' name='pesNome' type='text' />
          </fieldset>
          <fieldset id="cpf" class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              CPF
            </label>
            <input id='pesfCpf' maxlength='14' name='pesfCpf' type='text' />

          </fieldset>
          </fieldset>
          <fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              Data de Nascimento
            </label>
            <input id='nascimento' name='nascimento' type='text' class="data-mask" />
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
          <fieldset class='pesNome validate=notnull onsubmit:notnull'>

            <label for='pesNome'>
              Nome
            </label>
            <input id='pesNome' maxlength='256' name='pesNomeJ' type='text' />
          </fieldset>
          <fieldset id="cpf" class='pesfCpf validate=cpf-null cpf-mask'>
            <label for='pesfCpf'>
              Razao Social
            </label>
            <input id='razaosocial' name='razaosocial' type='text' />

          </fieldset>
          </fieldset>
          <fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              CNPJ
            </label>
            <input id='cnpj' class="cnpj" name='cnpj' type='text'/>
          </fieldset>
          <fieldset class='pesfRg'>
            <label for='pesfRg'>
              Inscrição Estadual
            </label>
            <input id='inscricao' maxlength='16' name='inscricao' type='text'  />
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
              <input name='situacao' value='S' class='radio' type='radio' checked='checked' />
              Ativo
            </label>
          </fieldset>

          <fieldset class='inativo'>
            <label class='inativo'>
              <input name='situacao' value='N' class='radio' type='radio' />
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
            <textarea id='cliObservacoes' name='cliObservacoes' ></textarea>
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
            <input id='logradouro' maxlength='40' name='logradouro' type='text' />
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Número
            </label>
            <input id='numero' maxlength='7' name='numero' type='text' />
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
            <input id='bairro' maxlength='40' name='bairro' type='text' />
          </fieldset>              
        </fieldset>
        <fieldset>
        <fieldset class='cep onsubmit:notnull'>
            <label for='cep'>
              Cep
            </label>
            <input id='cep' maxlength='8' name='cep'  type='text' />
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
            <input id='conComercial' name='conComercial' class="phone" type='text' />

          </fieldset>
          <fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Telefone celular
            </label>
            <input id='conCelular' name='conCelular' class="phone" type='text'  />
          </fieldset>		 
		  </fieldset>
		  <fieldset>
		  <fieldset class='conResidencial'>
            <label for='conResidencial'>
              Telefone residencial
            </label>
            <input id='conResidencial' name='conResidencial' class="phone" type='text' />
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
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-clientes" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
