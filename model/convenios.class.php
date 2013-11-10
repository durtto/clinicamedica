<?php
class Convenio{
	
	private $codconvenio;
	private $descricao;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}

class ModelConvenios{
	public function loadById($codconvenio)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
	
			$sql = "SELECT con_convenio, con_nome FROM convenios WHERE con_convenio = ".$codconvenio;
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Convenio = new Convenio();
					$Convenio->set('codconvenio', $linha[0]);
					$Convenio->set('descricao', $linha[1]);				
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $Convenio;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function loadConvenios()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
				
			$sql = "SELECT con_convenio, con_nome FROM convenios ORDER BY con_convenio ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Convenio = new Convenio();
					$Convenio->set('codconvenio', $linha[0]);
					$Convenio->set('descricao', $linha[1]);
						
					$arrayConvenios[$i] = $Convenio;
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayConvenios;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}