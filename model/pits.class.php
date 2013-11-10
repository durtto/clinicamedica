<?php
class Pit{

	private $id;	
	private $dataprazo;
	private $datacriacao;	
	private $titulo;
	private $descricao;
	private $codcliente;
	private $codcategoria;
	private $codstatus;
	private $valor;
	private $codresponsavel;
	
	
	function __construct()
	{
		$this->set('datacriacao', date("Y-m-d"));
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}


class PitsModel
{		 
		
	public function __construct()
	{
		
	}
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
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
	
	public function insertPit($Pit)
	{
		try{			
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			$sql = "INSERT INTO pit (					
					pit_titulo,
					pit_descricao,
					pit_datacriacao,
					pit_dataprazo,
					pit_status,
					pit_categoria,
					pit_valor,
					pit_cliente,
					pit_responsavel
					) values (
					
					'".$Pit->get('titulo')."',
					'".$Pit->get('descricao')."',
					'".$Pit->get('datacriacao')."',
					'".$Pit->get('dataprazo')."',
					'".$Pit->get('codstatus')."',
					'".$Pit->get('codcategoria')."',
					'".$Pit->get('valor')."', 
					'".$Pit->get('codcliente')."',
					'".$Pit->get('codresponsavel')."')";
			//echo $sql;			
			executeOpened($conn, $sql, $cod);
			
			if($conn->HasFailedTrans())
			{				
				$conn->FailTrans();
			}else{
				$result = $conn->CompleteTrans();
				return $cod;
			}
		}catch(Exception $e)
		{			
			echo $e->getMessage();			
		}
		$conn->disconnect();
	}
	
	/**
	 * 
	 * Atualiza o Pit...
	 * @param unknown_type $Pit
	 * @return boolean
	 */
	public function updatePit($Pit)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			$sql = "UPDATE pit SET 
						pit_titulo = '".$Pit->get('titulo')."',
						pit_descricao = '".$Pit->get('descricao')."',						
						pit_dataprazo = '".$Pit->get('dataprazo')."',
						pit_status = '".$Pit->get('codstatus')."',
						pit_categoria = '".$Pit->get('codcategoria')."',
						pit_valor = '".$Pit->get('valor')."',
						pit_cliente = '".$Pit->get('codcliente')."' 
						WHERE pit_pit = '".$Pit->get('id')."' ";
			
			Execute($conn, $sql);
				
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
				return false;
			}else{
				$result = $conn->CompleteTrans();
				return true;
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$conn->disconnect();
	}
	/**
	 * 
	 * Carrega os Pits de acordo com o filtro..
	 * @param $FiltroPit
	 */
	public function loadPitsByFiltro($FiltroPit)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			
			
			$sql = "SELECT 
					pit_pit,
					pit_titulo,
					pit_descricao,
					pit_datacriacao,
					pit_dataprazo,
					pit_status,
					pit_categoria,
					pit_cliente,
					pit_valor,
					pit_responsavel 
					FROM pit ";
			$cont = 0;
			if($FiltroPit)
			{
				
				if($FiltroPit->get('datainicio') && $FiltroPit->get('datafim'))
				{					
					switch ($FiltroPit->get('usardata'))
					{
						case 1:
							$data = "pit_datacriacao";
							break;
						case 2:
							$data = "pit_dataprazo";
							break;
						default:
							$data = "pit_datacriacao";
						break;
					}
					$sql .= getSQL($cont)." ".$data." BETWEEN '".$FiltroPit->get('datainicio')."' AND '".$FiltroPit->get('datafim')."'";
					$cont++;	
				}
				if($FiltroPit->get('codstatus'))
				{					
					$sql .= getSQL($cont)." pit_status = '".$FiltroPit->get('codstatus')."'";
					$cont++;	
				}
				if($FiltroPit->get('codcategoria'))
				{
					$sql .= getSQL($cont)." pit_categoria = '".$FiltroPit->get('codcategoria')."'";
					$cont++;
				}
				if($FiltroPit->get('codcliente'))
				{
					$sql .= getSQL($cont)." pit_cliente = '".$FiltroPit->get('codcliente')."'";
					$cont++;
				}
				if($FiltroPit->get('codresponsavel'))
				{
					$sql .= getSQL($cont)." pit_responsavel = '".$FiltroPit->get('codresponsavel')."'";
					$cont++;
				}
			}			
			$sql .= "  ORDER BY ".$data;
			$cont++;
			
			//echo $sql;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				$i=0;
				
				while($linha = $resultado->fetchRow())
				{
					$Pit = new Pit();
					$Pit->set('id', $linha[0]);
					$Pit->set('titulo', $linha[1]);
					$Pit->set('descricao', $linha[2]);
					$Pit->set('datacriacao', dataparaousuario($linha[3]));
					$Pit->set('dataprazo', dataparaousuario($linha[4]));
					$Pit->set('codstatus', $linha[5]);
					$Pit->set('codcategoria', $linha[6]);
					$Pit->set('codcliente', $linha[7]);
					$Pit->set('valor', valorparaousuario_new($linha[8]));
					$Pit->set('codresponsavel', $linha[9]);
					$arrayPits[$i] = $Pit;
					$i++;
				}
			}
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
				return false;
			}else{
				$result = $conn->CompleteTrans();
				return $arrayPits;
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$conn->disconnect();
	}
	
	/**
	 * Carrega um pit pelo id. 
	 * @param unknown_type $id
	 */	
	public function loadFromId($id)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			$sql = "SELECT 
					pit_pit,
					pit_titulo,
					pit_descricao,
					pit_datacriacao,
					pit_dataprazo,
					pit_status,
					pit_categoria,					
					pit_cliente,
					pit_valor
					FROM pit
					WHERE pit_pit = '".$id."' LIMIT 1";			
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{	
				$linha = $resultado->fetchRow();			
				$Pit = new Pit();
				$Pit->set('id', $linha[0]);
				$Pit->set('titulo', $linha[1]);
				$Pit->set('descricao', $linha[2]);
				$Pit->set('datacriacao', dataparaousuario($linha[3]));
				$Pit->set('dataprazo', dataparaousuario($linha[4]));
				$Pit->set('codstatus', $linha[5]);
				$Pit->set('codcategoria', $linha[6]);
				$Pit->set('codcliente', $linha[7]);
				$Pit->set('valor', valorparaousuario_new($linha[8]));
			}else{
				
				return false;
				throw new Exception("Pit nใo encontrado no banco de dados.", $e);
			}
				
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
			}else{
				$result = $conn->CompleteTrans();
				return $Pit;
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$conn->disconnect();
	}
	/**
	 * 
	 * Retorna o nome do cliente de acordo com seu c๓digo.
	 * @param integer $codcliente
	 */
	function getClienteByValue($codcliente)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			$sql = "SELECT
						pes_nome
						FROM pessoas 						
						INNER JOIN clientes ON cli_cliente = pes_pessoa 
						WHERE cli_cliente = $codcliente LIMIT 1";			
			$resultado = Execute($conn, $sql);
			
			if($resultado -> numRows() > 0)
			{
				$linha = $resultado->fetchRow();
				$nomecliente = $linha[0];
				return $nomecliente;
			}else{		
				return false;
			}
		
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
			}else{
				$result = $conn->CompleteTrans();				
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$conn->disconnect();
		
	}
	function getStatusByValue($codstatus)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAวรO///
			$conn = conecta_banco();
			$conn->StartTrans();
			$sql = "SELECT
					sit_nome
					FROM situacoes  
					WHERE sit_situacao = $codstatus LIMIT 1";			
			$resultado = Execute($conn, $sql);
				
			if($resultado -> numRows() > 0)
			{
				$linha = $resultado->fetchRow();
				$status = $linha[0];
				return $status;
			}else{
				return false;
			}
	
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
			}else{
				$result = $conn->CompleteTrans();
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$conn->disconnect();
	
	}
	
}
?>