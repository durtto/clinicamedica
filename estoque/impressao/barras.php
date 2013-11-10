<?
require_once('../../_funcoes/_classes/barcodes/barcode.inc.php'); 
$code_number = $_GET['codigo'];
new barCodeGenrator($code_number,0,'hello.gif'); 
?> 