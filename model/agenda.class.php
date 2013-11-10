<?php
class Agenda{
	
	private $cod_agenda;
	private $cod_medico;
	private $cod_paciente;
	private $dataconsulta;
	private $horainicio;
	private $horafim;
	private $tipoconsulta;
	private $atendido;
	private $convenio;
	private $valorconsulta;
	private $observacoes;
	
	function __construct()
	{
		$this->set('atendido', "0");
		$this->set('tipoconsulta', "C");
		$this->set('dataconsulta', date("Y-m-d"));
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

class ModelAgenda
{	
	
	public function insert($Agenda)
	{
		////CONECTA O BANCO E INICIA A TRANSA플O///
		$conn = conecta_banco();
		$conn->StartTrans();
		
		$sql = "INSERT INTO agenda (
					ag_dataconsulta,
					ag_horainicio,
					ag_horafim,
					ag_tipoconsulta,
					ag_atendido,
					ag_paciente,
					ag_convenio,
					ag_valorconsulta,
					ag_observacoes,
					ag_medico 				
					) VALUES (
				'".$Agenda->get('dataconsulta')."',
				'".$Agenda->get('horainicio')."',
				'".$Agenda->get('horafim')."',
				'".$Agenda->get('tipoconsulta')."',
				'".$Agenda->get('atendido')."',
				'".$Agenda->get('cod_paciente')."',
				'".$Agenda->get('convenio')."',
				'".$Agenda->get('valorconsulta')."',
				'".$Agenda->get('observacoes')."',
				'".$Agenda->get('cod_medico')."')";
		//echo $sql;
		executeOpened($conn, $sql, $cod);
			
		if($conn->HasFailedTrans())
		{
			$conn->FailTrans();
				
			throw new Exception("Erro ao inserir.", $e);
			return false;
			
		}else{
			$conn->CompleteTrans();
			return $cod;
		}
	}
	
	
	public function marcarComoAtendido($Agenda)
	{
		////CONECTA O BANCO E INICIA A TRANSA플O///
		$conn = conecta_banco();
		$conn->StartTrans();
	
		$sql = "UPDATE agenda SET ag_atendido = '".$Agenda->get('atendido')."' WHERE ag_agenda = ".$Agenda->get('cod_agenda');
		Execute($conn, $sql);
					
		if($conn->HasFailedTrans())
		{
			$conn->FailTrans();
	
			throw new Exception("Erro ao atualizar.", $e);
			return false;
	
		}else{
			$conn->CompleteTrans();
			return true;
		}
	}
	
	public function update($Agenda)
	{
		////CONECTA O BANCO E INICIA A TRANSA플O///
		$conn = conecta_banco();
		$conn->StartTrans();
	
		$sql = "UPDATE agenda SET
						ag_dataconsulta = '".$Agenda->get('dataconsulta')."',
						ag_horainicio = '".$Agenda->get('horainicio')."', 
						ag_horafim = '".$Agenda->get('horafim')."',
						ag_tipoconsulta = '".$Agenda->get('tipoconsulta')."',
						ag_atendido = '".$Agenda->get('atendido')."',
						ag_paciente = '".$Agenda->get('cod_paciente')."',
						ag_convenio = '".$Agenda->get('convenio')."',
						ag_valorconsulta = '".$Agenda->get('valorconsulta')."'				
						WHERE ag_agenda = ".$Agenda->get('cod_agenda');
		//echo $sql;
		Execute($conn, $sql);
			
		if($conn->HasFailedTrans())
		{
			$conn->FailTrans();
	
			throw new Exception("Erro ao atualizar.", $e);
			return false;
				
		}else{
			$conn->CompleteTrans();
			return true;
		}
	}
	
	public function delete($Agenda)
	{
		////CONECTA O BANCO E INICIA A TRANSA플O///
		$conn = conecta_banco();
		$conn->StartTrans();
	
		$sql = "DELETE FROM agenda WHERE ag_agenda = ".$Agenda->get('cod_agenda');
		//echo $sql;
		Execute($conn, $sql);
			
		if($conn->HasFailedTrans())
		{
			$conn->FailTrans();
	
			throw new Exception("Erro ao excluir.", $e);
			return false;
	
		}else{
			$conn->CompleteTrans();
			return true;
		}
	}
	public function loadById($codagenda)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSA플O///
			$conn = conecta_banco();
			$conn->StartTrans();
					
			$sql = "SELECT
						ag_agenda,
						ag_dataconsulta,
						ag_horainicio,
						ag_horafim,
						ag_tipoconsulta,
						ag_atendido,
						ag_paciente,
						ag_convenio,
						ag_valorconsulta,
						ag_observacoes,
						ag_medico  							
						FROM agenda 
						WHERE ag_agenda = '".$codagenda."'";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Agenda = new Agenda();
					$Agenda->set('cod_agenda', $linha[0]);
					$Agenda->set('dataconsulta', dataparaousuario($linha[1]));
					$Agenda->set('horainicio', $linha[2]);
					$Agenda->set('horafim', $linha[3]);
					$Agenda->set('tipoconsulta', $linha[4]);
					$Agenda->set('atendido', $linha[5]);
					$Agenda->set('cod_paciente', $linha[6]);
					$Agenda->set('convenio', $linha[7]);
					$Agenda->set('valorconsulta', valorparaousuario_new($linha[8]));
					$Agenda->set('observacoes', $linha[9]);
					$Agenda->set('cod_medico', $linha[10]);
					if($Agenda->get('tipoconsulta') == 'C')
					{
						$Agenda->set('tipoconsultadescricao', "Consulta");
					}else{
						$Agenda->set('tipoconsultadescricao', "Reconsulta");
					}
					
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $Agenda;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function loadDataOfDay()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSA플O///
			$conn = conecta_banco();
			$conn->StartTrans();
			
			$data = date('Y-m-d');
			$sql = "SELECT 
					ag_agenda					
					FROM agenda 
					WHERE ag_dataconsulta = '".$data."' 
					ORDER BY ag_horainicio ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$arrayAgenda[$i] = $linha[0];
					$i++;
				}
						
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayAgenda;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function loadByDataHorario($data, $horario, $medico)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSA플O///
			$conn = conecta_banco();
			$sql = "SELECT
							ag_agenda					
							FROM agenda 
							WHERE ag_dataconsulta = '".$data."' AND ag_horainicio = '".$horario."' AND ag_medico = '".$medico."' LIMIT 1";
			
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$codagenda = $linha[0];
				}
				return $codagenda;
			}else{
				return false;
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function verificaHorarioLivre($data, $horario, $medico)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSA플O///
			$conn = conecta_banco();					
			$sql = "SELECT
						ag_agenda					
						FROM agenda 
						WHERE ag_dataconsulta = '".$data."' AND ag_horainicio = '".$horario."' AND ag_medico = '".$medico."' LIMIT 1";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				return false;
			}else{
				return true;
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function loadByPaciente($codpaciente)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSA플O///
			$conn = conecta_banco();
			$conn->StartTrans();
						
			$sql = "SELECT
						ag_agenda					
						FROM agenda 
						WHERE ag_paciente = '".$codpaciente."' 
						ORDER BY ag_dataconsulta, ag_horainicio ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$arrayAgenda[$i] = $linha[0];
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayAgenda;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}