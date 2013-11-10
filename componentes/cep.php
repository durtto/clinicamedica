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
      $texto = "<label for='cidade_label' id='cidade_label'>&nbsp;</label>		
		  Cidade: <b>".$resultado_busca['cidade']."</b> Estado: <b>".$resultado_busca['uf']."</b>";     
     break;  
       
     case '1':  
	 $cidade =  utf8_encode($resultado_busca['cidade']);	 
     $texto = "<label for='cidade_label' id='cidade_label'>&nbsp;</label>		
		  Cidade: <b>".$cidade."</b>&nbsp; Estado: <b>".$resultado_busca['uf']."</b>";     
     break;  
       
     default:  
         $texto = "Falha ao buscar cep. ";  
     break;  
}  
   
echo $texto;  


?>