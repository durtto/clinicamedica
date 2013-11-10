<?
require_once("../_funcoes/funcoes.php");
/**
busca o endereço no webservice
*/

$cep = $_GET['cep'];
$resultado_busca = busca_cep($cep);  
  
/*echo "<pre> Array Retornada: 
 ".print_r($resultado_busca, true)."</pre>";  */
   
switch($resultado_busca['resultado']){  
      case '2': 
	 //CIDADE COM LOGRADOURO ÚNICO// 
      $texto = "".$resultado_busca['cidade']." - ".$resultado_busca['uf']."";     
     break;  
       
     case '1':  
	 $cidade =  utf8_encode($resultado_busca['cidade']);	 
     $texto = "".$cidade."&nbsp; - ".$resultado_busca['uf']."";     
     break; 
       
     default:  
         $texto = "Falha ao buscar cep. ";  
     break;  
}  
   
echo $texto;  


?>