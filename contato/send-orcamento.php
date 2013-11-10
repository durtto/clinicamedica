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
	$mensagem = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\">									  
					  <body>						
						  <img src=\"cid:$cid\">".$mensagem;
				
	$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
	
	$message = "--$boundary\n";	
	//$message .= "Content-Transfer-Encoding: quoted-printable\r\n";
	$message .= "Content-Type: text/html; charset=windows-1252\r\n\n"; //plain		
	$message .= $mensagem."\n";
	$message .= "--$boundary\r\n";	
	$message .= "Content-Type: image/jpeg; name=\"$logo\"\r\n";	 
	$message .= "Content-Disposition: inline; filename=\"$logo\"\r\n";		
	$message .= "Content-Transfer-Encoding: base64\r\n";	
	$message .= "Content-ID: <$cid>\r\n\n"; 		
	$message .= $anlogo."\r\n";	
	$message .= "--$boundary\r\n";
	$message .= "Content-Type: ".$arquivo["type"]." name=\"".$arquivo["name"]."\"\n"; 
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
	
	$cid = date('YmdHms').'.'.time();
	
	$mensagem = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\">									  
					  <body>						
						  <img align='DecorCasa' src=\"cid:$cid\">".$mensagem;
	
				
    $message = "--$boundary\r\n";	
	$message .= "Content-Type: text/html; charset=\"Windows-1252\"\r\n"; 
	$message .= "Content-Transfer-Encoding: 7bit\r\n\n";
	$message .= $mensagem."\n";
	$message .= "--$boundary\r\n";	
	$message .= "Content-Type: image/jpeg; name=$logo\r\n";
	$message .= "Content-Disposition: attachment; filename=$logo\r\n"; 
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
		$linha = $resultado->fetchRow();		
		$email  = $linha[0];						
				
		if($smtp->Send($email, "decorcasa@decorcasagramado.com.br", $assunto, $message, $boundary)){
			 echo "<script>
					 location.href='home-contato.php?status=ok';
			  </script>";
			  echo $email;
		}else{
			echo "<script>
					 location.href='home-contato.php?status=erro';
			  </script>";
		}		
	}
}



?>
