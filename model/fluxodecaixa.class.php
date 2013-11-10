<?php
class FluxoDeCaixa{
	
	private $id; //único
	private $codigo; //mesmo para todas as parcelas da mesma conta
	private $parcela;
	private $qtdparcelas;
	private $codpessoa;
	private $dataemissao;
	private $datavencimento;
	private $datapagamento;
	private $valor;
	private $valortotal;
	private $codagenda;
	private $estahpago;
	private $descricao;
	private $formapagamento;
	private $codconta; //conta banco movimentacao
	private $tipopagamento;
	private $categoriamovimentacao;
	private $cedente;
	private $dataentrada;
	
	function __construct()
	{
		$this->set('estahpago', "N");
		$this->set('dataemissao', date("Y-m-d"));
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

class FluxoDeCaixaModel{
	
	public function insertFluxo($FluxoDeCaixa)
	{
		
		////CONECTA O BANCO E INICIA A TRANSAÇÃO///
		$conn = conecta_banco();
		$conn->StartTrans();
		
		$sql = "SELECT flux_agenda FROM fluxodecaixa WHERE flux_agenda = ".$FluxoDeCaixa->get('codagenda');			
		$resultado = Execute($conn, $sql);
		if($resultado -> numRows() > 0)
		{			
			throw new Exception("Já existe um lançamento no fluxo de caixa relativo a esta consulta.", $e);
			return false;
			
		}else{
			
			
			$sql = "SELECT MAX(flux_codigo) as codigo FROM fluxodecaixa";
			$resultado = $conn->query($sql);
			while ($linha = $resultado->fetchRow())
			{
				$FluxoDeCaixa->set('codigo', $linha[0]+1 );
			}
			for($i=0; $i<$FluxoDeCaixa->get('qtdparcelas'); $i++)
			{
				if ($i == 0)
				{
					$FluxoDeCaixa->set('datavencimento', $FluxoDeCaixa->get('dataentrada') );
				}else{
					$FluxoDeCaixa->set('datavencimento', dataparacartao(30*($i+1), $FluxoDeCaixa->get('dataemissao')) );
				}

				$FluxoDeCaixa->set('parcela', $i+1);
				$FluxoDeCaixa->set('valor', round($FluxoDeCaixa->get('valortotal') / $FluxoDeCaixa->get('qtdparcelas'), 2) );
				
				
				$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
				$resultado = $conn->query($sql);
				while ($linha = $resultado->fetchRow())
				{
					$FluxoDeCaixa->set('id', $linha[0]+1 );
				}
				
				$sql = "INSERT INTO fluxodecaixa (
							flux_fluxodecaixa, 
							flux_codigo,
							flux_parcela, 
							flux_codpessoa, 
							flux_dataemissao, 
							flux_datavencimento, 
							flux_tipopagamento, 
							flux_formapagamento,							 
							flux_qtdparcelas, 
							flux_valor,
							flux_valortotal, 
							flux_codconta, 
							flux_estahpago, 
							flux_categoriamovimentacao, 
							flux_descricao,
							flux_agenda						
						) values (
						'".$FluxoDeCaixa->get('id')."',
						'".$FluxoDeCaixa->get('codigo')."',
						'".$FluxoDeCaixa->get('parcela')."',
						'".$FluxoDeCaixa->get('codpessoa')."',
						'".$FluxoDeCaixa->get('dataemissao')."',
						'".$FluxoDeCaixa->get('datavencimento')."',
						'".$FluxoDeCaixa->get('tipopagamento')."',
						'".$FluxoDeCaixa->get('formapagamento')."',
						'".$FluxoDeCaixa->get('qtdparcelas')."',
						'".$FluxoDeCaixa->get('valor')."',
						'".$FluxoDeCaixa->get('valortotal')."',
						".$FluxoDeCaixa->get('codconta').",
						'".$FluxoDeCaixa->get('estahpago')."',
						'".$FluxoDeCaixa->get('categoriamovimentacao')."',
						'".$FluxoDeCaixa->get('descricao')."',
						".$FluxoDeCaixa->get('codagenda')."						
						)";
				//echo $sql;
				Execute($conn, $sql);
					
				if($conn->HasFailedTrans())
				{
					$conn->FailTrans();					
					
					throw new Exception("Erro ao inserir no fluxo de caixa.", $e);
					return false;
				}
			}
							
			$conn->CompleteTrans();
			return true;
		}
			
		
		$conn->disconnect();
	}
	
}