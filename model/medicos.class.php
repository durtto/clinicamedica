<? 
class Medico{
	
	private $codmedico;
	private $nome;
	private $especialidade;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}

class ModelMedicos{
	public function loadById($codmedico)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
	
			$sql = "SELECT med_medico, med_nome, med_especialidade FROM medicos WHERE med_medico = ".$codmedico;
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Medico = new Medico();
					$Medico->set('codmedico', $linha[0]);
					$Medico->set('nome', $linha[1]);
					$Medico->set('especialidade', $linha[2]);
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $Medico;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function loadMedicos()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
				
			$sql = "SELECT med_medico, med_nome, med_especialidade FROM medicos ORDER BY med_medico ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Medico = new Medico();
					$Medico->set('codmedico', $linha[0]);
					$Medico->set('nome', $linha[1]);
					$Medico->set('especialidade', $linha[2]);
						
					$arrayMedicos[$i] = $Medico;
					$i++;
				}
				
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayMedicos;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}