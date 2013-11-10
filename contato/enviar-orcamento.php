<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
?>
<script type="text/javascript" src="../_javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Office example CSS
	content_css : "css/office.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});
</script>
<?
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");

?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-contatos" class="contatos">Contatos</a>
		Contatos
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="send-orcamento.php" method="post" enctype="multipart/form-data">
<h3>
	Mensagem
</h3>     
        <fieldset>
		<?
		  $status = $_GET['status'];
		  if($status == 'ok')
		  {		  
		  ?>
			  <fieldset>		         
			  <fieldset>
				<p style="color:#000099; font-size:12; font-weight:bold">Mensagem enviada!</p>
				</fieldset>
			  </fieldset>
		  <?
		  }else if($status == 'erro')
		  {
		  ?>
		  	<fieldset>		         
			  <fieldset>
				<p style="color:#FF0000; font-size:12; font-weight:bold">Erro ao enviar.</p>
				</fieldset>
			  </fieldset>
		  <?
		  }
		  ?>
        <fieldset>		         
          <fieldset class='cliente onsubmit:notnull'>
            <label for='cliente'>
              Cliente
            </label>
            <select id='cliente[]' name='cliente[]' class='onsubmit:notnull'>  
			
				<option value='null' >
				 Selecione um cliente
				 </option>            
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
			?>	
				 <option value='<? echo $cod_cliente;?>' >
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>		  
		  <fieldset>
          <fieldset class='assunto'>
            <label for='assunto'>
              Assunto
            </label>
            <input type="text" name="assunto" class='onsubmit:notnull'>			
          </fieldset>
		</fieldset>
		  <fieldset>
          <fieldset class='mensagem'>
            <label for='mensagem'>
              Mensagem
            </label>
            <textarea id='mensagem' name='mensagem' style="width:100%;border-width:1px;border-style:solid;" rows="20" cols="60">
			
				<?


					$cod_orcamento = $_GET['cod'];
					
					$sql = "SELECT orc_orcamento, orc_descricao, pes_nome, orc_data, orc_total, orc_situacao, orc_responsavel ". 
							"FROM orcamentos INNER JOIN pessoas ON pes_pessoa = orc_cliente WHERE orc_orcamento = '$cod_orcamento'";		
					$resultado = execute_query($sql);
					while ($linha = $resultado->fetchRow()) 
					{		 			
						$cod_orcamento  = $linha[0];
						$descricao  = $linha[1];
						$nome_cliente  = $linha[2];
						$data  = $linha[3];
						$valor_total  = $linha[4];
						$situacao = $linha[5];	
						$cod_usuario = $linha[6];
						
						$valor_total = valorparaousuario_new($valor_total);
						$data = dataparaousuario($data);		 
					}
					?>
						  
						  <p> 
							<h3>Orçamento</h3>
						  </p>
						  <p class='codigo-data'>             
						   <? echo dataporextenso(); ?> 
						  </p> 
						
						<br />
						<div id='dados-gerais'>	
							  <p>				
								   À
								   <?
								   echo $nome_cliente;									  
								   ?>
							  </p>
							  <p>
								   <?
								   echo $descricao;									  
								   ?>			   
							  </p>
						</div>
						<?
						
						?>	
						<div>
						<p><h4>Produtos</h4></p>				
						<table border="0" style="border-style:none">							
						<thead bgcolor="#f3f3f3">
							  <tr style=" border-style:none">	 			
								<td style="border-style:none" width="220px">Produto</td>										
								<td style="border-style:none" width="100px">Valor</td>
								<td style="border-style:none" width="100px">Qtde.</td>
								<td style="border-style:none" width="120px">Subtotal</td>
							  </tr>
						</thead>						
							<?
							$sql = "SELECT orcpro_produto, orcpro_quantidade, orcpro_subtotal, pro_unidade, orcpro_valorunitario ". 
								"FROM orcamentos_produtos INNER JOIN produtos ON pro_produto = orcpro_produto WHERE orcpro_orcamento = $cod_orcamento";		
						
							$resultado = execute_query($sql);
							$i = 0;
					
							while($linha = $resultado->fetchRow()) 
							{		 			
								$cod_produto  = $linha[0];
								$qtd  = $linha[1];
								$subtotal  = $linha[2];
								$unidade = $linha[3];
								$valor_produto = $linha[4];
								
								$sql = "SELECT pro_nome, pro_valorvenda ". 
								"FROM produtos WHERE pro_produto = $cod_produto";	
								$resultado1 = execute_query($sql);
								$linha = $resultado1->fetchRow();
								$nome_produto = $linha[0];
								//$valor_produto = $linha[1];
								$valor_produto = valorparaousuario_new($valor_produto);
								$subtotal = valorparaousuario_new($subtotal);
							?>
							
							<tr style=" border-style:none">	 			
								<td style="border-style:none"><?=$nome_produto?></td>
								<td style="border-style:none"><? echo $valor_produto."/".$unidade?></td>			
								<td style="border-style:none"><? echo $qtd." ".$unidade?></td>
								<td style="border-style:none"><?=$subtotal?></td>
							</tr>
							<?
							}
							?>
							<tr style=" border-style:none">	 			
								<td style="border-style:none"></td>
								<td style="border-style:none"></td>
								<td style="border-style:none"><strong>Total:</strong></td>	
								<td style="border-style:none">R$ <b><?=$valor_total?></b></td>
							</tr>
							</table>
						
									
							<?		
							
							
							$sql = "SELECT ocon_condicaopagamento, ocon_qtdparcelas, ocon_desconto ". 
							"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento";		
					
							$resultado = execute_query($sql);
							$i = 0;
							while ($linha = $resultado->fetchRow()) 
							{		 			
								$condicoes[$i]  = $linha[0];
								$qtdparcelas[$i]  = $linha[1];
								$desconto[$i]  = $linha[2];
								$i++;
							}	
							?>	
							<p><h4>Condições de Pagamento</h4></p>	
							<table border="0" style="border-style:none">
							<thead bgcolor="#f3f3f3">
							  <tr style=" border-style:none">	 			
								<td style="border-style:none" width="100px">Condição</td>				
								<td style="border-style:none" width="100px">Desconto</td>				
								<td style="border-style:none" width="140px">Valor</td>			
								<td style="border-style:none">Total</td>				
							  </tr>
							</thead>
							<tbody>	
							<?
							for($i=0;$i<sizeof($condicoes);$i++)
							{
							?>
								<tr>				
									<td style="border-style:none">
									<?
										$sql = "SELECT con_condicao, con_descricao FROM condicoespagamento WHERE con_condicao = $condicoes[$i]";				
										$resultado = execute_query($sql);
										while ($linha = $resultado->fetchRow()) 
										{		 			
											  $cod_condicao  = $linha[0];
											  $descricao  = $linha[1];
										}
										echo $descricao;
									?></td>
									<td style="border-style:none">
									<?
										if($condicoes[$i] == 1)
										{
											echo $desconto[$i]."%";
										}else{
											echo "-";
										}
									?></td>				
									<td style="border-style:none"><? 
										$valor_parcelas = $valor_total;
										if($condicoes[$i] == 2)
										{
											$valor_parcelas = str_replace(".","", $valor_parcelas);
											$valor_parcelas = str_replace(",",".", $valor_parcelas);
											$valor_parcelas = ($valor_parcelas/$qtdparcelas[$i]);
											$valor_parcelas = valorparaousuario_new($valor_parcelas);
											
											echo $qtdparcelas[$i]." x R$ ".$valor_parcelas;
										}else{
										echo "R$ $valor_parcelas";
										}
									?></td>					
									<td style="border-style:none"><?
										$valoraux = $valor_total;
										if($condicoes[$i] == 1)
										{
											$valoraux = str_replace(".","", $valoraux);
											$valoraux = str_replace(",",".", $valoraux);
											$valoraux = $valoraux - ($valoraux*($desconto[$i]/100));
											$valoraux = valorparaousuario_new($valoraux);
										}
										echo "R$ <b>$valoraux</b>";
										
									?></td>						
								</tr>
								<?
								}
								?>
							</tbody>	
							</table>
						
						</div>	
						 <div id='dados-gerais'>
						 <p style="font-size:9px">
							Validade deste orçamento: 10 dias
						</p>
							<br />  
						 <p class='entrega'>
							Atenciosamente,
						</p>	
						<p class='entrega'>
					<?
						$sql = "SELECT	usu_usuario, pes_nome, usu_login ". 
						"FROM	usuarios ". 
						"INNER JOIN pessoas ".
						"ON usu_usuario = pes_pessoa WHERE usu_usuario = $cod_usuario";								
						$resultado = execute_query($sql);				
						while ($linha = $resultado->fetchRow()) 
						{		 			
							  $cod_usuario  = $linha[0];
							  $nome_usuario  = $linha[1];					 			  	
							  $login  = $linha[3];						  
						}
						echo $nome_usuario; 
					?>		<br />
								Nexun Informática</p>
						</div>	
						</body>
					</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	

			
			</textarea>
			
          </fieldset>
		</fieldset>
		  <fieldset>		         
          <fieldset class='arquivo'>
            <label for='arquivo'>
              Selecione um arquivo:
            </label>
			<input type="file" name="arquivo" class="campo300" value="Procurar">
		</fieldset>
		</fieldset>
		</fieldset>
		<input type="submit" id='submit-button' value="Enviar" class="bt">
</form>
</body>
</html>
