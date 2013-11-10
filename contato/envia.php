<?
require_once("../_funcoes/funcoes.php");
include "../_funcoes/_classes/smtp/smtp.class.php";

$contatos = $_POST['cliente'];
$mensagem = $_POST['mensagem'];
$assunto = $_POST['assunto'];

$smtp = new Smtp("smtp.decorcasagramado.com.br");
$smtp->user = "robot@decorcasagramado.com.br";
$smtp->pass = "robot5";
$smtp->debug = true;

echo "Enviando...";

$mime_list = array("html"=>"text/html","htm"=>"text/html", "txt"=>"text/plain", "rtf"=>"text/enriched","csv"=>"text/tab-separated-values","css"=>"text/css","gif"=>"image/gif");

$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

if(file_exists($arquivo["tmp_name"]) and !empty($arquivo))
{
	///COM ANEXO///
	
	/*________LOGO_______*/
	$logo = "logo_.jpg";
	$fplogo = fopen($logo,"rb");
	$anlogo = fread($fplogo,filesize($logo));           
	$anlogo = base64_encode($anlogo); 
	fclose($fplogo);		
	$anlogo = chunk_split($anlogo); 	
	
	/*________ANEXO_______*/	
	$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb");
	$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"]));           
	$anexo = base64_encode($anexo); 
	fclose($fp);		
	$anexo = chunk_split($anexo); 
	
	$cid = date('YmdHms').'.'.time();
	$mensagem = "<html><body>
				<img src=\"cid:$cid\"><br><br>".$mensagem;
				
	$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
	
	$message = "--$boundary\n";
	$message .= "Content-Transfer-Encoding: 8bits\n";
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; //plain
	$message .= $mensagem."\n";
	$message .= "--$boundary\r\n";	
	$message .= "Content-Type: image/jpeg; name=$logo\r\n";
	$message .= "Content-Disposition: inline; filename=$logo\r\n"; 
	$message .= "Content-Transfer-Encoding: base64\r\n";	
	$message .= "Content-ID: <$cid>\r\n\n"; 	
	$message .= $anlogo."\r\n";	
	$message .= "--$boundary\n";
	$message .= "Content-Type: ".$arquivo["type"]."\n"; 
	$message .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n"; 
	$message .= "Content-Transfer-Encoding: base64\n\n"; 
	$message .= "$anexo\n"; 
	$message .= "--$boundary--\r\n"; 
	
}else{
	///SEM ANEXO///
	
	/*________LOGO_______*/
	$logo = "logo_.jpg";
	$fp = fopen($logo,"rb");
	$anexo = fread($fp,filesize($logo));           
	$anexo = base64_encode($anexo); 
	fclose($fp);		
	$anexo = chunk_split($anexo); 	
	
	$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
	/*$boundary2 = "XYZ1-" . date("dmYis") . "-ZYX";	
    $message = "--$boundary2\n";	
	$message .= "Content-Type: image/jpeg\n";
	$message .= "boundary=\"$boundary\"\r\n\n";	
	
	$message .= "--$boundary\n";	
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n"; 
	$message .= "Content-Transfer-Encoding: 8bits\n\n";	
	$message .= $mensagem."\n";
	$message .= "--$boundary--\n\n";
	$message .= "--$boundary2\n";	
	$message .= "Content-Type: image/jpeg; name=$logo \n";
	//$message .= "Content-Disposition: inline; filename=$logo\n"; 
	$message .= "Content-Transfer-Encoding: base64\n";	
	$message .= "Content-ID: <decor_logo> \n\n"; 	
	$message .= $anexo."\n";	
	$message .= "--$boundary2--\r\n"; */
	
	$cid = date('YmdHms').'.'.time();
	$mensagem = "<html><body>
				<img src=\"cid:$cid\"><br><br>".$mensagem;
				
    $message = "--$boundary\r\n";	
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n"; 
	$message .= "Content-Transfer-Encoding: 7bit\r\n\n";
	$message .= $mensagem."\n";
	$message .= "--$boundary\r\n";	
	$message .= "Content-Type: image/jpeg; name=$logo\r\n";
	$message .= "Content-Disposition: inline; filename=$logo\r\n"; 
	$message .= "Content-Transfer-Encoding: base64\r\n";	
	$message .= "Content-ID: <$cid>\r\n\n"; 	
	$message .= $anexo."\r\n";	
	$message .= "--$boundary--\r\n"; 
	
}

for($i=0;$i<sizeof($contatos);$i++)
{
	if($contatos[$i] != "todos")
	{	
		$sql = "SELECT cli_con_email FROM clientes WHERE cli_cliente = ".$contatos[$i];	 
		$resultado = execute_query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$email  = $linha[0];						
		}		
		if($smtp->Send($email, "decorcasa@decorcasagramado.com.br", $assunto, $message, $boundary)){
			 echo "<script>
					 location.href='home-contato.php?status=ok';
			  </script>";
		}else{
			echo "<script>
					 location.href='home-contato.php?status=erro';
			  </script>";
		}		
	}
}

/*if($emails){
	$enderecos = explode(";", $emails);
	for($i=0;$i<count($enderecos);$i++)
	{
		if($enderecos[$i])
		{
			$recipients = $enderecos[$i];
			echo "<br>".$recipients;
			
			if($smtp->Send($recipients, "denes@nexun.com.br", $assunto, $message, $boundary)){
						
			}else{
			echo "<script>
					 location.href='home-contato.php?status=erro';
			  </script>";
			}
		}
	}
}*/


?>
