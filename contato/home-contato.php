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

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="envia.php" method="post" enctype="multipart/form-data">
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
			
			
				<br><br>
				Digite aqui o seu texto				
				<br><br>
				
				<HR WIDTH="600px" SIZE="1" COLOR="#3E4166">
				<p align="center"><B>NEXUN</B> Informática<BR>
				Rua Felisberto Soares, 55 Sl. 05 - Centro - Canela/RS<BR>
				Fone: (54) 3282 3730<BR>			
				</p>
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
