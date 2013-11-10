<?
session_start();
require_once("../../_funcoes/funcoes.php");

$cod_conta = $_GET['cod'];

$sql =			"SELECT ".
						" flux_fluxodecaixa, flux_conta, flux_parcela, flux_codpessoa, flux_datavencimento, flux_datapagamento, flux_tipopagamento, flux_formapagamento, flux_valor, flux_qtdparcelas, flux_codorcamentoaprovado, flux_codconta ".				
						" FROM fluxodecaixa ".
						//" INNER JOIN orcamentos ON flux_codorcamentoaprovado = orc_orcamento ".
						" INNER JOIN pessoas ON pes_pessoa = flux_codpessoa ".
						" WHERE flux_conta = $cod_conta";
		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	  $cod_fluxodecaixa  = $linha[0];
	  $cod_conta  = $linha[1];
	  $parcela  = $linha[2];
	  $sacado  = $linha[3];
	  $datavencimento  = $linha[4];  
	  $datapagamento = $linha[5];
	  $tipopagamento = $linha[6];
	  $formapagto = $linha[7];
	  $valor = $linha[8];
	  $qtdparcelas = $linha[9];
	  $codorcamentoaprovado = $linha[10];
	  $conta = $linha[11];
	
	  $valor = valorparaousuario_new($valor);
	  $datavencimento = dataparaousuario($datavencimento);
	  
	  if($datapagamento != "")
	  {
		$datapagamento = dataparaousuario($datapagamento);
	  }
	
	/*$sql = "SELECT ocon_qtdparcelas ". 
		"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_pedido AND ocon_estahaprovado = 's'";		
				
	$resultado3 = execute_query($sql);				
	while ($linha = $resultado3->fetchRow()) 
	{		 								
		$qtdparcelas  = $linha[0];	

	}	*/
	
}
$sql = "SELECT pes_nome ". 
		"FROM orcamentos INNER JOIN pessoas ON pes_pessoa = orc_cliente WHERE orc_orcamento = '$cod_pedido'";		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$nome_cliente  = $linha[0];		 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
    <title>
      Grisè Comunicação - Recibo
    </title>
    <link rel='stylesheet' type='text/css' href='../../_css/impressao/recibos/print.css' />
  </head>
  <body>
    <div id='cabecalho'>
      <img align='Grisè' class='logo' src='../../_images/logo.jpg' />
      <h2>
        Recibo
      </h2>
      <p class='codigo-data'>            
       <? echo dataporextenso(); ?> 
      </p>
    </div>
	<br />
	<div id='dados-gerais'>	
		  <table>
			<tr>          
			  <td id="orcliente">				
			   Recebemos de 
			   <b><?=$nome_cliente?></b>
			   a quantia de R$ <?=$valor?> 
			   proveniente da parcela 
			   <?
			    if($qtdparcelas == "")
				{
				echo "única";
				
				}
				else
				{
				echo "<b>$parcela</b>";
				} 
				?> do pedido cód. <strong><?=$cod_pedido?></strong>.
			  </td>         
			</tr>					
		  </table>
	 
	<p class='entrega'>
<?
	$id_usuario = $_SESSION['id'];
	$sql = "SELECT	usu_usuario, pes_nome, usu_login ". 
	"FROM	usuarios ". 
	"INNER JOIN pessoas ".
	"ON usu_usuario = pes_pessoa WHERE usu_usuario = $id_usuario";								
	$resultado = execute_query($sql);				
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $cod_usuario  = $linha[0];
		  $nome_usuario  = $linha[1];					 			  	
		  $login  = $linha[3];						  
	}
	echo $nome_usuario; 
?>		<br />
			Grisè Comunicação</p>
	</div>	
	</body>
</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	
