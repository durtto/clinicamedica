<?
session_start();
require_once("../_funcoes/funcoes.php");

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='pauta-listagem' xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "<script src='../_javascript/cadastro-de-pits/Listagem.js' type='text/javascript'></script>\n";
?>

</head>
<body>
<?
include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pauta" class="pauta">Pauta</a>
		Pauta > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="cadastrar.php">Cadastrar</a>					
	</li>
     
</div>
<?
include "./filtros/filtro.php";
?>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
        <tr>
        	<td class="ckecks" width="20px">Cod.</td>
            <td class='col-2' >T&iacute;tulo</td>            
            <td class='col-4'>Cliente</td>
            <td class='col-3'>Cria&ccedil;&atilde;o</td>
            <td class='col-3'>Prazo</td>    
            <td class='col-3'>Valor</td>
            <td class='col-3'>Status</td>
            <td colspan="2" class='grid-action'>A&ccedil;&otilde;es</td>
            
        </tr>
        </thead>			
		<tbody>
	<?
		
		function getSQL($cont)
		{
			if($cont == 0)
			{
				return " WHERE ";
			}else{
				return " AND ";
			}
		}
		$cont = 0;
		
		
		include("../model/pits.class.php");
		include("../model/filtropit.class.php");
		
		$codusuario = $_SESSION['responsavel'];					
		$data = $_POST['data'];		
		$usardata = $_SESSION['usardata'];
		$status = $_SESSION['status'];
		$codcliente = $_SESSION['cliente'];
		
		if(!empty($_POST['tipo']))
		{
			$tipo = $_POST['tipo'];
		}	
						
		$FiltroPit = new FiltroPit();
		$FiltroPit->set('datainicio', dataparaobanco($inicio));
		$FiltroPit->set('datafim',dataparaobanco($fim));
		
		if($codusuario != "null")
		{
			$FiltroPit->set('codresponsavel', $codusuario);
		}
		if($codcliente != "null")
		{
			$FiltroPit->set('codcliente', $codcliente);
		}			
		if($status != "null")
		{
			$FiltroPit->set('codstatus', $status);
		}	
		if($usardata)
		{
			$FiltroPit->set('usardata', $usardata);
		}
		
		$PitsModel = new PitsModel();
		$arrayPits = $PitsModel->loadPitsByFiltro($FiltroPit);
		
		if(sizeof($arrayPits)>0)
		{
		
			for($i=0; $i<sizeof($arrayPits); $i++)
			{		 			
				 $Pit = new Pit();
				 $Pit = $arrayPits[$i];
				 
				  $y = 2;	 
				  $resto = fmod($x, $y);	
				 if($resto == 0)
				 {
					$par = "par";
				 }
				 else
				 { 
					$par = "";
				 }		 		
				$x = $x+1;	 
					
			?>
			<tr class="<? echo $par; ?>">			        
		        <td class='col-1'><? echo $Pit->get('id'); ?> </td>
		        <td class='col-1'><? echo $Pit->get('titulo'); ?> </td>
		        <td class='col-4'><? echo $PitsModel->getClienteByValue($Pit->get('codcliente'));?></td>
		        <td class='col-3'><? echo $Pit->get('datacriacao'); ?> </td>
		        <td class='col-3'><? echo $Pit->get('dataprazo'); ?> </td>
		        <td class='col-3'><?echo $Pit->get('valor'); ?> </td>
		        <td class='col-4'><?echo $PitsModel->getStatusByValue($Pit->get('codstatus')); ?> </td>     
		        
		        <td class="grid-action">
		        	<a href="editar.php?cod=<?=$Pit->get('id')?>" class="editar" title="editar"></a> 
		        </td>
				<td class="grid-action">
					<a href="delete.php?cod=<?=$Pit->get('id')?>" class="excluir" title="excluir"></a> 
				</td>
			</tr>		
			<?		
			}
		}			
     
     ?>
        </tbody>
	</table>
</form>			

</body>
</html>	