<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/edicao-de-orcamentos/Second.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
$cod_conta = $_GET['cod'];
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Financeiro > Edição de Conta
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-financeiro">Listagem</a>
	</li>
</div>
<?
$sql = "SELECT con_conta, con_pedido, con_parcela, con_datavencimento, con_datapagamento, con_formapagto, con_valor, con_tipoconta, orc_cliente ".
		" FROM contas ".
		" INNER JOIN orcamentos ON con_pedido = orc_orcamento ".
		" INNER JOIN pessoas ON pes_pessoa = orc_cliente ".
		" INNER JOIN pedidos ON ped_pedido = orc_orcamento ".
		" WHERE con_conta = $cod_conta";
		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	  $cod_conta  = $linha[0];
	  $cod_pedido  = $linha[1];
	  $parcela  = $linha[2];
	  $datavencimento  = $linha[3];
	  $datapagamento  = $linha[4];  
	  $formapagto = $linha[5];
	  $valor = $linha[6];
	  $tipoconta = $linha[7];
	  $cliente = $linha[8];
	
	  $valor = valorparaousuario_new($valor);
	  $datavencimento = dataparaousuario($datavencimento);
	  
	  if($datapagamento != "")
	  {
		$datapagamento = dataparaousuario($datapagamento);
	  }	  
	
	$sql = "SELECT ocon_qtdparcelas ". 
		"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_pedido AND ocon_estahaprovado = 's'";		
				
	$resultado3 = execute_query($sql);				
	while ($linha = $resultado3->fetchRow()) 
	{		 								
		$qtdparcelas  = $linha[0];	

	}	
	
}
?>
<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-conta.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value="<?=$cod_conta?>"/>

<h3>
	Conta
</h3>     
        <fieldset>
        <fieldset>		         
          <fieldset class='cliente onsubmit:notnull'>
            <label for='cliente'>
              Cliente
            </label>
            <select id='cliente' name='cliente' class='onsubmit:notnull' disabled="disabled">           
			<?		
				$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ".							
				"ORDER BY pes_nome";
					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];
					  $nome_cliente  = $linha[1];	
					if($cod_cliente == $cliente)
					{
						$selected = "selected='selected'";
					}else{ $selected = ""; }				
			?>	
				 <option value='<? echo $cod_cliente;?>' <?=$selected?> >
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>		
<fieldset>		 
<fieldset>
	<legend>
	Tipo de Conta
	</legend>	
	<fieldset class='onsubmit:notnull'>
	<?		
			$sql = "SELECT tip_tipoconta, tip_descricao ". 
					"FROM tiposdeconta";				
			$resultado1 = execute_query($sql);
			while($linha2 = $resultado1->fetchRow())
			{
				$tipo = $linha2[0];
				$tipoconta_descricao = $linha2[1];	
				if($tipo == $tipoconta)
				{	
					$checked = "checked";
				}else{ $checked = ""; }						 		 
			?>	
			
		  <fieldset class='condPagamento'>
			<label class='condPagamento'>		
			  
			  <input type="radio" id='condicao' name='condicao' class="onsubmit:notnull radio" value="<?= $tipo?>" <?=$checked?> />
					  <?=$tipoconta_descricao?>
			</label>
		  </fieldset>
		 	<?
			}
			?>	 		  			  				  
	</fieldset>
  </fieldset> 
  </fieldset>	
  <fieldset>
  <fieldset class='formapagto onsubmit:notnull'>
	<label for='formapagto'>
	  Forma de pagamento
	</label>
	<select id='formapagto' name='formapagto' class='onsubmit:notnull'>	
	<?		
		$sql = "SELECT form_formapagto, form_descricao ". 
		"FROM formaspagamento";		
		$resultado = execute_query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_forma  = $linha[0];
			  $descricao  = $linha[1];
			  if($cod_forma == $formapagto)
			  {
				$checked = "selected";
			  }else{ $checked = "";}	
	?>	
		 <option value='<? echo $cod_forma;?>' <?=$checked?>>
		 <? echo $descricao;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset>
  </fieldset> 
  	<fieldset>
	<fieldset >
	  <label for="parcela">
		Parcela
	  </label>	 
	  <?
	 if($qtdparcelas == "")
	{
	echo "única";
	
	}
	else
	{
	echo "<b>$parcela</b> de $qtdparcelas";
	} 
	 ?>
	</fieldset>				
	</fieldset>	
	<fieldset>
	<fieldset>
	  <label for="valorparcela">
		Valor
	  </label>	 
	  <input id="valorparcela" name="valorparcela" type="text" class="onsubmit:notnull moeda" value="<?=$valor?>">	 
	</fieldset>	
	<fieldset id="gerar" >
	  <label for="gerar">
	  &nbsp;		
	  </label>	 
	  <input id="gerarrecibo" name="gerarrecibo" type="checkbox" class="radio">Gerar recibo
	</fieldset>					  
  </fieldset>
  <fieldset>
  <fieldset id="datas" >
	  <label for="dataentrada">
		Data da vencimento:
	  </label>	 
	  <input id="datavencimento" name="datavencimento" type="text" class="data-mask onsubmit:notnull" value="<?=$datavencimento?>">	 
	</fieldset>
	<fieldset id="datas" >
	  <label for="dataentrada">
		Data da pagamento:
	  </label>	 
	  <input id="datapagamento" name="datapagamento" type="text" class="data-mask" value="<?=$datapagamento?>">	 
	</fieldset>		
	</fieldset>		
 </fieldset>
   
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-financeiro" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
