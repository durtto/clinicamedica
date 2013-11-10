<?
session_start();
require_once("../_funcoes/funcoes.php");


$cod_usuario = $_GET['cod'];

$sql = "delete from usuarios where cod_usuario = '$cod_usuario'";

$conn = conecta_banco();
$resultado = $conn->query($sql);

echo "<script>
         location.href='../_funcoes/controller.php?opcao=home-usuarios';
      </script>";





?>