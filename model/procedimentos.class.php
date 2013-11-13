<?php
class Procedimento{
	
	private $codprocedimento;
	private $nome;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}

class ModelProcedimentos{
	
	public function loadById($codprocedimento)
	{
		if($codprocedimento)
		{
			try{
				////CONECTA O BANCO E INICIA A TRANSAÇÃO///
				$conn = conecta_banco();
				$conn->StartTrans();
				
				$sql = "SELECT pro_procedimento, pro_nome FROM procedimentos WHERE pro_procedimento = ".$codprocedimento;
				$i=0;
				$resultado = Execute($conn, $sql);
				if($resultado -> numRows() > 0)
				{
					while($linha = $resultado->fetchRow())
					{
						$Procedimento = new Procedimento();
						$Procedimento->set('codprocedimento', $linha[0]);
						$Procedimento->set('nome', $linha[1]);				
					}
		
					if($conn->HasFailedTrans())
					{
						$conn->FailTrans();
						return false;
					}else{
						$result = $conn->CompleteTrans();
						return $Procedimento;
					}
				}
			}catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
	public function loadProcedimentos()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
				
			$sql = "SELECT pro_procedimento, pro_nome FROM procedimentos ORDER BY pro_procedimento ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Procedimento = new Procedimento();
					$Procedimento->set('codprocedimento', $linha[0]);
					$Procedimento->set('nome', $linha[1]);
						
					$arrayProcedimentos[$i] = $Procedimento;
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayProcedimentos;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function insert($Procedimento)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
	
			$sql = "INSERT INTO procedimentos (pro_nome) VALUES ('".$Procedimento->get('nome')."')";
			$i=0;
			executeOpened($conn, $sql, $cod);
			
	
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();
				return false;
			}else{
				$result = $conn->CompleteTrans();
				return $cod;
			}
			
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function update($Procedimento)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
	
			$sql = "UPDATE procedimentos SET pro_nome = '".$Procedimento->get('nome')."' WHERE pro_procedimento = '".$Procedimento->get('codprocedimento')."'";
			
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
	}
	public function delete($Procedimento)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
	
			$sql = "DELETE FROM procedimentos WHERE pro_procedimento = '".$Procedimento->get('codprocedimento')."'";				
			Execute($conn, $sql);
			if($conn->HasFailedTrans())
			{
				$conn->FailTrans();		
				throw new Exception("Erro ao excluir, este registro pode possuir dependências.", $e);
				return false;
		
			}else{
				$conn->CompleteTrans();
				return true;
			}	
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}