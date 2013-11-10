<?php
/*
* Created on 29/11/2006
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/

error_reporting(E_ALL);

require("Mail.php");
require("AttachmentMail.php");
require("Multipart.php");

$to = "denes.stumpf@gmail.com";
//$addTo = "outro@empresa.com.br";
$msgOK = "Email enviado";
$msgFAILED = "Email não enviado";
$subject = $message = "Nothing";
$arquivo = isset($_FILES["imagem"]) ? $_FILES["imagem"] : FALSE;
  if(!$arquivo){
    echo "Arquivo não carregado ou problemas no envio! Tente novamente!".$_FILES["imagem"];	  
  }
/**
* Enviar em varios formatos
* Envio 1: Prioridade Alta e conteúdo em HTML (Já contem as tags <html>)
* Envio 2: Prioridade Normal e conteúdo em HTML (não contém as tags <html>)
* Envio 3: Prioridade Baixa e conteúdo em texto simples
*/
$mail = new Mail($to, $subject, "", "denes@nexun.com.br");

$mail->setBodyHtml("<h1>".$message."</h1>");
$mail->setPriority(AbstractMail::HIGH_PRIORITY);
if ($mail->send())
    echo $msgOK;
else
    echo $msgFAILED;

$mail->resetHeaders();
$mail->setHtml("<h1>".$message."</h1>");
$mail->setPriority(AbstractMail::NORMAL_PRIORITY);
if ($mail->send())
    echo $msgOK;
else
    echo $msgFAILED;

$mail->resetHeaders();
$mail->setBodyText($message);
$mail->setPriority(AbstractMail::LOW_PRIORITY);
if ($mail->send())
    echo $msgOK;
else
    echo $msgFAILED;
/**/

/**
* Enviar em varios formatos com ANEXO
* Envio 1: Prioridade Alta e conteúdo em HTML (Já contem as tags <html>)
* Envio 2: Prioridade Normal e conteúdo em HTML (não contém as tags <html>)
* Envio 3: Prioridade Baixa e conteúdo em texto simples
*/
$mail2 = new AttachmentMail($to, $subject, "", "denes@nexun.com.br");

$mp1 = new Multipart($arquivo);
$mail2->addAttachment($mp1);
$mail2->addAttachment(new Multipart($arquivo));

$mail2->addTo($addTo);
$mail2->setBodyHtml("<h1>".$message."</h1>");
$mail2->setPriority(AbstractMail::HIGH_PRIORITY);
if ($mail2->send())
    echo $msgOK;
else
    echo $msgFAILED;

$mail2->resetHeaders();
$mail2->setHtml("<h1>".$message."</h1>");
$mail2->setPriority(AbstractMail::NORMAL_PRIORITY);
if ($mail2->send())
    echo $msgOK;
else
    echo $msgFAILED;

$mail2->resetHeaders();
$mail2->setBodyText($message);
$mail2->setPriority(AbstractMail::LOW_PRIORITY);
if ($mail2->send())
    echo $msgOK;
else
    echo $msgFAILED;
/**/
?>