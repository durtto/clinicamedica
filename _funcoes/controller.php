<?
session_start();
include("../componentes/realpath.php");
include("verificar.php");

$login = $_POST['login'];
$senha  = $_POST['senha'];
$opcao = $_GET['opcao'];

$id = $_SESSION['id'];

$resultado = verifica_login($login,$senha,$id);
//$resultado1 = esta_logado($id);
function frontcontroller($resultado,$opcao)
{
	list($opcao,$param)= split("/",$opcao);
	$opcao = $opcao;
	$param = $param;	
	
	if($resultado == 0 || $opcao == "sair")
	{
		$destino = "view/login.php";
		session_destroy();	
	}
	else if($opcao == "home-basicos")
	{
		$destino = "basicos/home-basicos.php";
	}
	else if($opcao == "home-marcas")
	{
		$destino = "basicos/marcas/home-marcas.php";
	}
	else if($opcao == "cadastro-de-marcas")
	{
		$destino = "basicos/marcas/cadastrar-marcas.php";
	}
	else if($opcao == "edicao-de-marcas")
	{
		$destino = "basicos/marcas/editar-marcas.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-marcas")
	{
		$destino = "basicos/marcas/delete-marcas.php?cod=".$param;
	}
	else if($opcao == "home-procedimentos")
	{
		$destino = "basicos/procedimentos/home.php";
	}
	else if($opcao == "home-setores")
	{
		$destino = "basicos/setores/home-setores.php";
	}
	else if($opcao == "cadastro-de-setores")
	{
		$destino = "basicos/setores/cadastrar-setores.php";
	}
	else if($opcao == "edicao-de-setores")
	{
		$destino = "basicos/setores/editar-setores.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-setores")
	{
		$destino = "basicos/setores/delete-setores.php?cod=".$param;
	}
	else if($opcao == "home-usuarios")
	{
		$destino = "usuarios/home-usuarios.php";
	}
	else if($opcao == "cadastro-de-usuarios")
	{
		$destino = "usuarios/cadastrar-usuarios.php";
	}
	else if($opcao == "edicao-de-usuarios")
	{
		$destino = "usuarios/editar-usuarios.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-usuarios")
	{
		$destino = "usuarios/delete_usuario.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-clientes")
	{
		$destino = "usuarios/delete_usuario.php?cod=".$param;
	}
	else if($opcao == "home-clientes")
	{
		$destino = "clientes/home-clientes.php";
	}
	else if($opcao == "cadastro-de-clientes")
	{
		$destino = "clientes/cadastrar-clientes.php";
	}
	else if($opcao == "edicao-de-clientes")
	{
		$destino = "clientes/editar-clientes.php?cod=".$param;
	}
	else if($opcao == "visualiza-clientes")
	{
		$destino = "clientes/visualiza-clientes.php?cod=".$param;
	}
	else if($opcao == "home-fornecedores")
	{
		$destino = "fornecedores/home-fornecedores.php";
	}
	else if($opcao == "cadastro-de-fornecedores")
	{
		$destino = "fornecedores/cadastrar-fornecedores.php";
	}
	else if($opcao == "edicao-de-fornecedores")
	{
		$destino = "fornecedores/editar-fornecedores.php?cod=".$param;
	}	
	else if($opcao == "visualiza-fornecedores")
	{
		$destino = "fornecedores/visualiza-fornecedores.php?cod=".$param;
	}	
	
	else if($opcao == "home-agenda")
	{
		$destino = "agenda/home.php";
	}
	
	
	
	else if($opcao == "home-estoque")
	{
		$destino = "estoque/home-estoque.php";
	}
	else if($opcao == "cadastro-de-estoque")
	{
		$destino = "estoque/cadastrar-estoque.php";
	}
	else if($opcao == "edicao-de-estoque")
	{
		$destino = "estoque/editar-estoque.php?cod=".$param;
	}
	else if($opcao == "alterar-precos")
	{
		$destino = "estoque/alterar-precos.php";
	}
	else if($opcao == "exclusao-de-estoque")
	{
		$destino = "estoque/delete-estoque.php?cod=".$param;
	}
	else if($opcao == "home-orcamentos")
	{
		$destino = "orcamentos_pedidos/home-orcamentos-pedidos.php";
	}
	else if($opcao == "cadastro-de-orcamento")
	{
		$destino = "orcamentos_pedidos/cadastrar-orcamento.php";
	}
	else if($opcao == "edicao-de-orcamento")
	{
		$destino = "orcamentos_pedidos/editar-orcamentos.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-orcamento")
	{
		$destino = "orcamentos_pedidos/delete-orcamentos.php?cod=".$param;
	}	
	else if($opcao == "home-pedidos")
	{
		$destino = "orcamentos_pedidos/home-pedidos.php";
	}	
	else if($opcao == "cadastrar-pedidos")
	{
		$destino = "orcamentos_pedidos/cadastrar-pedidos.php";
	}
	else if($opcao == "edicao-de-pedido")
	{
		$destino = "orcamentos_pedidos/editar-pedidos.php?cod=".$param;
	}	
	else if($opcao == "exclusao-de-pedido")
	{
		$destino = "orcamentos_pedidos/delete-pedidos.php?cod=".$param;
	}
	else if($opcao == "home-financeiro")
	{
		$destino = "financeiro/home-financeiro.php";
	}
	else if($opcao == "cadastro-de-movimentacao")
	{
		$destino = "financeiro/cadastrar-movimentacao.php";
	}
	else if($opcao == "edicao-de-movimentacao")
	{
		$destino = "financeiro/editar-movimentacao.php?cod=".$param;
	}
	else if($opcao == "deletar-movimentacao")
	{
		$destino = "financeiro/delete-movimentacao.php?cod=".$param;
	}
	else if($opcao == "home-contas")
	{
		$destino = "financeiro/contas/home-contas.php";
	}
	else if($opcao == "cadastro-de-contas")
	{
		$destino = "financeiro/contas/cadastrar-conta.php";
	}
	else if($opcao == "home-categorias")
	{
		$destino = "financeiro/categorias/home-categorias.php";
	}
	else if($opcao == "cadastro-de-categorias")
	{
		$destino = "financeiro/categorias/cadastrar-categorias.php";
	}
	else if($opcao == "edicao-de-categorias")
	{
		$destino = "financeiro/categorias/editar-categorias.php?cod=".$param;
	}
	else if($opcao == "exclusao-de-categorias")
	{
		$destino = "financeiro/categorias/delete-categorias.php?cod=".$param;
	}
	else if($opcao == "home-contatos")
	{
		$destino = "contato/home-contato.php";
	}
	else if($opcao == "home-contas")
	{
		$destino = "financeiro/contas/home-contas.php";
	}
	else if($opcao == "cadastro-de-contas")
	{
		$destino = "financeiro/contas/cadastrar-conta.php";
	}
	else if($opcao == "edicao-de-contas")
	{
		$destino = "financeiro/contas/editar-contas.php?cod=".$param;
	}	
	else if($opcao == "home-relatorios")
	{
		$destino = "relatorios/home-relatorios.php";
	}
	else if($opcao == "home" || $resultado > 0)
	{
		$destino = "view/home.php";
	}		
	
	return $destino;
	
}

$_SESSION['id'] = $resultado;
$pagina = frontcontroller($resultado,$opcao);

echo "<script>
         location.href='".$_CONF['realpath']."/$pagina';
      </script>";

	  
?>