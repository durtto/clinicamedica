<?

include("conexao.php");

function anti_sql_injection($string)
{
    $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;

    $string = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($string) : mysql_escape_string($string);

    return $string;
} 
function getSQL($cont)
{
	if($cont == 0)
	{
		return " WHERE ";
	}else{
		return " AND ";
	}
}

# /* 
#  *  Função de busca de Endereço pelo CEP 
#  *  -   Desenvolvido Felipe Olivaes para ajaxbox.com.br 
#  *  -   Utilizando WebService de CEP da republicavirtual.com.br 
#  */  
function busca_cep($cep){       
 $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');       
 if(!$resultado){  
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
    }  
    parse_str($resultado, $retorno);   
    return $retorno;  
} 
function campotextoparaobanco($campo)
{
	if(!empty($campo) && $campo != "null")
	{
		return "'".$campo."'";
	}else{
		return "null";
	}
}
/**
 * Verifica se a diretiva magic_quotes está ativada ou não
 * e remove os caracteres de escape
 * @param string str String a ser tratada
 * @return string String passada sem os caracteres de escape
 */
function exibeStr($str){

	if(get_magic_quotes_gpc()){
	 $str= stripslashes($str);
	}
	return $str;
}

/**
 * Adiciona os caracteres de escape caso a diretiva magic_quotes
 * esteja desativada
 * @param string str String a ser tratada
 * @return string String com os caracteres de escape
 */
function strParaBD($str){
	if($str)
	{
		if(!get_magic_quotes_gpc()){
		 $str = addslashes($str);
		}
	}
	return $str;
} 
function dataparaobanco($data)
{
	if($data)
	{
		$dia = $mes = $ano = "";
		list($dia,$mes,$ano)= split("/",$data);		
		$data = $ano."-".$mes."-".$dia;	
	}
	else{
		$data = "null";
	}
	return $data;
}

function dataparaousuario($data){
  $dia = $mes = $ano = "";
  $ano = substr($data,0,4);
  $mes = substr($data,5,2);
  $dia = substr($data,8,8);
  if(($dia == "00") and ($mes == "00") and ($ano == "0000")){return "";}
  else{return $dia."/".$mes."/".$ano;}         
}
function horaparaobanco($hora){
  $vhora = "00";
  $vminuto = $vsegundo = ":00";    
  if(strlen($hora) >= 8){
    $vhora = substr($hora,0,2);
    $vminuto = ":".substr($hora,3,2);
    $vsegundo = ":".substr($hora,6,2); 
  }elseif(strlen($hora) >= 5){
    $vhora = substr($hora,0,2);
    $vminuto = ":".substr($hora,3,2);
    $vsegundo = ":00"; 
  }elseif(strlen($hora) >= 2){
    $vhora = substr($hora,0,2);
    $vminuto = $vsegundo = ":00"; 
  }
  return $vhora.$vminuto.$vsegundo;
}

function valorparaobanco($valor){
	if($valor != "" && $valor > 0)
	{			  	
		$valor = str_replace(".","",$valor);
		$valor = str_replace(",",".",$valor);
	}else if($valor === 0 || $valor == "")
	{	
		$valor = "0.00";
	}else
	{
		$valor = str_replace(",",".",$valor);
	}
		
	return $valor;
}

function valorparaousuario($valor){
  if($valor != "" && $valor > 0)
  {			  	
	$valor = str_replace(".",",",$valor);
	if(strpos($valor, ",")===false)
	{
		$valor = $valor.",00";
	}
  }
  else if($valor === 0 || $valor == 0)
  {
  	$valor = "0,00";
  }
  else
  {			  
	$valor = str_replace(".",",",$valor);
  }
  return $valor;
}
function valorparaousuario_new($var)
{		
	$valor = number_format($var, 2, ',', '.');
	return $valor;
}
function precisao_semanal($precisao_atual)
{
	$precisao = array();
	$y=2;
	for($i=0;$i<5;$i++)
	{
		array_push($precisao, $y);
		$y++;
	}
	$options = "<option value='1'>Sem precisão</option>";
	for($i=0; $i<5; $i++)
	{
		if($precisao[$i] == 2){
			if($precisao_atual == $precisao[$i])
			{
				$selected = "selected";
			}else{$selected = '';}
			$options .= "\n<option value='".$precisao[$i]."' ".$selected.">Segunda-feira</option>";			
		}
		if($precisao[$i] == 3){
			if($precisao_atual == $precisao[$i])
			{
				$selected = "selected";
			}else{$selected = '';}
			$options .= "\n<option value='".$precisao[$i]."' ".$selected.">Terça-feira</option>";			
		}
		if($precisao[$i] == 4){
			if($precisao_atual == $precisao[$i])
			{
				$selected = "selected";
			}else{$selected = '';}
			$options .= "\n<option value='".$precisao[$i]."' ".$selected.">Quarta-feira</option>";			
		}
		if($precisao[$i] == 5){
			if($precisao_atual == $precisao[$i])
			{
				$selected = "selected";
			}else{$selected = '';}
			$options .= "\n<option value='".$precisao[$i]."' ".$selected.">Quinta-feira</option>";			
		}
		if($precisao[$i] == 6){
			if($precisao_atual == $precisao[$i])
			{
				$selected = "selected";
			}else{$selected = '';}
			$options .= "\n<option value='".$precisao[$i]."' ".$selected.">Sexta-feira</option>";			
		}
				
	}	
	return $options;
}
function execute_query($sql)
{		
	$conn = conecta_banco();		
	$resultado = $conn->query($sql);
	$conn->disconnect();
	return $resultado;
}
////EXECUTA UMA INSERÇÃO COM A CONEXÃO ABERTA
function executeOpened($conexao, $sql, &$retornoid)
{
	if($conexao)
	{
		$resultado = $conexao->Execute($sql);
		//echo $sql;
		if (!$resultado) {
			throw new Exception("Classe SQL, linha " . __LINE__ . " - Falha ao executar query: " .$conexao->ErrorMsg());
			$resultado = false;
		}else{
			$retornoid = $conexao->Insert_ID();
			$resultado = true;
		}
	}
	return $resultado;
}
///EXECUTA UMA QUERY COM A CONEXÃO ABERTA///
function Execute($conn, $sql)
{
	if($conn)
	{
		$resultado = $conn->query($sql);
		if (empty($resultado)) {
			throw new Exception("Classe SQL, linha " . __LINE__ . " - Falha ao executar query: " .$conn->ErrorMsg());
		}
	}else{
		throw new Exception("Não foi possível conectar com o banco de dados.");
	}
	return $resultado;
}
function dataporextenso()
{
	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');
	$semana = date('w');
	
	switch($mes)
	{
		case 1: $mes = "Janeiro"; break;
		case 2: $mes = "Fevereiro"; break;
		case 3: $mes = "Março"; break;
		case 4: $mes = "Abril"; break;
		case 5: $mes = "Maio"; break;
		case 6: $mes = "Junho"; break;
		case 7: $mes = "Julho"; break;
		case 8: $mes = "Agosto"; break;
		case 9: $mes = "Setembro"; break;
		case 10: $mes = "Outubro"; break;
		case 11: $mes = "Novembro"; break;
		case 12: $mes = "Dezembro"; break;
	}
	
	switch($semana)
	{
		case 0: $semana = "Domingo"; break;
		case 1: $semana = "Segunda-feira"; break;
		case 2: $semana = "Terça-feira"; break;
		case 3: $semana = "Quarta-feira"; break;
		case 4: $semana = "Quinta-feira"; break;
		case 5: $semana = "Sexta-feira"; break;
		case 6: $semana = "Sábado"; break;
	}
	return "$semana, $dia de $mes de $ano";	
}
function dataporextenso2($dia,$mes,$ano,$semana)
{
	switch($mes)
	{
		case 1: $mes = "Janeiro"; break;
		case 2: $mes = "Fevereiro"; break;
		case 3: $mes = "Março"; break;
		case 4: $mes = "Abril"; break;
		case 5: $mes = "Maio"; break;
		case 6: $mes = "Junho"; break;
		case 7: $mes = "Julho"; break;
		case 8: $mes = "Agosto"; break;
		case 9: $mes = "Setembro"; break;
		case 10: $mes = "Outubro"; break;
		case 11: $mes = "Novembro"; break;
		case 12: $mes = "Dezembro"; break;
	}
	
	switch($semana)
	{
		case 0: $semana = "Domingo"; break;
		case 1: $semana = "Segunda-feira"; break;
		case 2: $semana = "Terça-feira"; break;
		case 3: $semana = "Quarta-feira"; break;
		case 4: $semana = "Quinta-feira"; break;
		case 5: $semana = "Sexta-feira"; break;
		case 6: $semana = "Sábado"; break;
	}
	return "$semana, $dia de $mes de $ano";	
}
////FUNÇÃO QUE RETORNA O ÚLTIMO DIA DO MÊS DE ACORDO COM A DATA INFORMADA///
function ultimoDiaMes($data){
	// Usando data: 01/02/2008 00:00:00
	// O Modificador "t" exibe o ultimo dia de um mês
	$dia = $mes = $ano = "";
	list($dia,$mes,$ano)= split("/",$data);			
    return date("t/m/Y", mktime(0, 0, 0, $mes, $dia, $ano));
    
 }
function retornaMes($mes)
{
	switch($mes)
	{		
		case 1: $mes = "Janeiro"; break;
		case 2: $mes = "Fevereiro"; break;
		case 3: $mes = "Março"; break;
		case 4: $mes = "Abril"; break;
		case 5: $mes = "Maio"; break;
		case 6: $mes = "Junho"; break;
		case 7: $mes = "Julho"; break;
		case 8: $mes = "Agosto"; break;
		case 9: $mes = "Setembro"; break;
		case 10: $mes = "Outubro"; break;
		case 11: $mes = "Novembro"; break;
		case 12: $mes = "Dezembro"; break;
	}
	return $mes;		
}
///OBS: PASSAR A DATA NO FORMATO BANCO ANO-MES-DIA///
function dataparacartao($carencia, $data)
{
	list($ano,$mes,$dia) = split("-",$data);
	
	$qtdmes = $carencia / 30;
	
	$mes = $mes + $qtdmes - 1;
			
	if($mes > 12)
	{
		$mes = $mes - 12;
		$ano += 1;
	}
	
	if($mes == 2 && $dia > 28)
	{
		$dia = 28;
	}
	if(strlen($dia)<2)
	{
		$dia = "0".$dia;
	}
	if(strlen($mes)<2)
	{
		$mes = "0".$mes;
	}
	///caso tenha entrado 31 no dia, vai sair 31 no vencimento, aí faço a última verificação///
	if($dia > 30)
	{
		$dia = 30;
	}
	return $ano."-".$mes."-".$dia;
}
///ADICIONA VÍRGULA DOS CENTAVOS AO VALOR//
//Passar valor apenas sem vírgula///
function money($var)
{				
	if(strrchr($var,".") === false)
		{
			$valor = $var.",00";				
		}
		else{						
			$valor= number_format($var, 2, ",", ".");
		}			
		
	if($valor == '')
	{
		$valor = $var.",00";
		$valor= number_format($valor, 2, ",", ".");
	}		
	return $valor;
}

?>
