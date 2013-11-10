<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$cod = $_POST['cod'];

$marca = $_POST['marca'];
$percentual = $_POST['percentual'];

$sinal = substr($percentual, 0,1);
$percentual = substr($percentual, 1,2);

$sql = "select pro_produto, pro_valorvenda from produtos where pro_marca = '$marca'";
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	  $cod_produto = $linha[0];
	  $valor_venda  = $linha[1]; 
	  
	  if($sinal == "+")
	  {
	  	$valor_venda = ($valor_venda * ($percentual/100)) + $valor_venda; 
	  }
	  else{
	  	$valor_venda = $valor_venda - ($valor_venda * ($percentual/100)); 
	  }
	  
	  $sql = "update produtos set pro_valorvenda = '$valor_venda' where pro_produto = '$cod_produto'";	
	   //echo $sql."<br>$sinal";
	  execute_query($sql);
}	  		

echo "<script>
         location.href='../_funcoes/controller.php?opcao=home-estoque';
      	  </script>";
	  


?>