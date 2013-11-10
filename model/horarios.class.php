<?php
class Horario{
	
	private $horario;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}

class ModelHorarios{
	
	public function loadHorarios()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
							
			$sql = "SELECT horario FROM horarios ORDER BY horario ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Horario = new Horario();
					$Horario->set('horario', $linha[0]);
					
					$arrayHorarios[$i] = $Horario;
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayHorarios;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
	/**
	 * Retorna todos os horário da tabela de horários e mais os horários de encaixe na tabela agenda, se houver.
	 * @param $data
	 */
	public function loadAllHorariosFromDay($data, $medico)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
				
			$sql = "SELECT horario as hora
					FROM horarios
					UNION
					SELECT ag_horainicio as hora FROM agenda
					WHERE ag_dataconsulta = '".$data."' AND ag_medico = '".$medico."' 
					ORDER BY hora ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Horario = new Horario();
					$Horario->set('horario', $linha[0]);
						
					$arrayHorarios[$i] = $Horario;
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayHorarios;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}