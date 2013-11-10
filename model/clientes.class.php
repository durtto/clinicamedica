<?php
class Cliente{
	
	private $codcliente;
	private $nomecliente;
	private $fonecomercial;
	private $foneresidencial;
	private $fonecelular;
	private $cpf;
	private $logradouro;
	private $numero;
	private $complemento;
	private $bairro;
	private $cep;
	private $situacao;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}

class ModelClientes{
	
	public function insert($Cliente)
	{
		////CONECTA O BANCO E INICIA A TRANSAÇÃO///
		$conn = conecta_banco();
		$conn->StartTrans();
		
		$sql = "SELECT MAX(pes_pessoa) as codigo FROM pessoas";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow())
		{
			$codpessoa  = $linha[0]+1;
		}		
		$sql = "insert into pessoas (pes_pessoa, pes_nome) values ('$codpessoa','".$Cliente->get('nomecliente')."')";
		Execute($conn, $sql);
		
		$sql = "INSERT INTO clientes (
						cli_cliente,
						cli_estahativo,
						cli_tipodepessoa,
						cli_con_celular					
						) VALUES (
					'".$codpessoa."',
					'S',
					'F',
					'".$Cliente->get('fonecelular')."')";
		//echo $sql;
		Execute($conn, $sql);
			
		if($conn->HasFailedTrans())
		{
			$conn->FailTrans();
	
			throw new Exception("Erro ao inserir.", $e);
			return false;
				
		}else{
			$conn->CompleteTrans();
			return $codpessoa;
		}
	}
	
	public function loadClientes()
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
			
			$sql = "SELECT  
					cli_cliente, 					 
					pes_nome, 
					cli_estahativo,
					cli_contato, 
					cli_con_comercial,
					cli_con_residencial,
					cli_con_celular  
					FROM clientes  
					INNER JOIN	pessoas ON cli_cliente = pes_pessoa 
					WHERE cli_estahativo = 'S' 
					ORDER BY pes_nome ASC";
			$i=0;
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Cliente = new Cliente();
					$Cliente->set('codcliente', $linha[0]);
					$Cliente->set('nomecliente', utf8_encode($linha[1]));
					$Cliente->set('situacao', $linha[2]);
					$Cliente->set('cli_contato', utf8_encode($linha[3]));
					$Cliente->set('fonecomercial', $linha[4]);
					$Cliente->set('foneresidencial', $linha[5]);
					$Cliente->set('fonecelular', $linha[6]);
									
					$arrayClientes[$i] = $Cliente;
					$i++;
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $arrayClientes;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function loadById($codcliente)
	{
		try{
			////CONECTA O BANCO E INICIA A TRANSAÇÃO///
			$conn = conecta_banco();
			$conn->StartTrans();
				
			$sql = "SELECT
						cli_cliente, 					 
						pes_nome, 
						cli_estahativo,
						cli_contato, 
						cli_con_comercial,
						cli_con_residencial,
						cli_con_celular  
						FROM clientes 
						INNER JOIN	pessoas ON cli_cliente = pes_pessoa   
						WHERE cli_cliente = ".$codcliente;
			
			$resultado = Execute($conn, $sql);
			if($resultado -> numRows() > 0)
			{
				while($linha = $resultado->fetchRow())
				{
					$Cliente = new Cliente();
					$Cliente->set('codcliente', $linha[0]);
					$Cliente->set('nomecliente', utf8_encode($linha[1]));
					$Cliente->set('situacao', $linha[2]);
					$Cliente->set('cli_contato', utf8_encode($linha[3]));
					$Cliente->set('fonecomercial', $linha[4]);
					$Cliente->set('foneresidencial', $linha[5]);
					$Cliente->set('fonecelular', $linha[6]);				
				}
	
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();
					return false;
				}else{
					$result = $conn->CompleteTrans();
					return $Cliente;
				}
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}