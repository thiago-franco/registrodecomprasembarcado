<?php

abstract class RepositorioAbstrato {
	
	/**
	 * Retorna o nome da tabela associada ao repositório. 
	 */
	function tabela( ) {
		return $this->tabela;
	}
	
	/**
	 * Recebe um comando, preenche-o com os valores, também recebidos, e o executa
	 * @param unknown $comando
	 * @param unknown $valores
	 * @throws RepositorioException
	 * @return unknown
	 */
	function executar( $comando, $valores ) {
		$ps = $this->pdo->prepare( $comando );
		if ( $ps && $ps->execute( $valores ) )		
			return $ps;
		else throw new RepositorioException( "Erro SQL: ".$comando );
	}
	
	/**
	 * Retorna o objeto correspondente ao id recebido
	 * @param unknown $id
	 * @return Ambigous <NULL>|NULL
	 */
	function comId( $id ) {
		$comando = "SELECT * FROM $this->tabela WHERE id = :id";
		$objs = $this->buscarObjetos( $comando, array( 'id' => $id ) );
		if( count( $objs ) > 0 )
			return $objs[0];
		return null;
	}
	
	/**
	 * Verifica se o objeto recebido existe no banco
	 * @param unknown $obj
	 * @return boolean
	 */
	function existe( $obj ) {
		if( $this->comId( $obj->getId() ) !== null )
			return true;
		return false;
	}
	
	/**
	 * Atualiza no banco o objeto recebido, realizando as alterações parametrizadas
	 * @param unknown $obj Objeto que representa entidade a ser alterada. Deve estar preenchido com os novos valores a serem usados na atualização
	 * @param array $alteracoes Array contendo nome e valor dos campos a serem alterados
	 * @param array $restricoes Array contendo nome e valor dos campos a srem usados como restrição da atualização no banco de dados. 
	 * @throws RepositorioException
	 
	function atualizar( array $alteracoes, array $restricoes ) {
		$update = '';
		$where = '';
		$valores = array();
		if( !empty( $alteracoes ) ) {
			$i = 0;
			foreach ( $alteracoes as $alteracao => $valor ) {
				if( $i > 0 )
					$update .= ', ';
				$update .= " $alteracao = :$alteracao";
				$valores[ $alteracao ] = $valor;
				$i++;
			}
		}
		if( !empty( $restricoes ) ) {
			$i = 0;
			foreach ( $restricoes as $restricao ) {
				if( $i > 0 )
					$where .= ' AND ';
				$where .= "WHERE $restricao = :$restricao";
				$valores[ $restricao ] =  $valor;
				$i++;
			}
		}
	
		$comando = "UPDATE $this->tabela SET $update $where";
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização no banco mal sucessedida." );
	}**?
	
	/**
	 * Remove do banco o objeto recebido
	 * @param unknown $obj
	 * @throws RepositorioException
	 */
	function remover( $obj ) {
		$comando = "DELETE FROM $this->tabela WHERE id = :id";
		$valores = array( 'id' => $obj->getId() );
		if ( $this->executar( $comando, $valores )->rowCount() < 1)
			throw new RepositorioException("Exclusão de caixa do banco mal sucessida.");
	}
	
	/**
	 * Conta a quantidade de entradas existentes na tabela associada ao repositorio
	 * @param string $where
	 * @param array $valores
	 * @return unknown
	 */
	function contarLinhas( $where = '', array $valores = array()	) {
		$campo = 'id';
		$comando = "SELECT COUNT( $campo ) FROM $this->tabela $where" ;
		$ps = $this->executar( $comando, $valores );
		$total = $ps->fetch( PDO::FETCH_NUM );
		return $total[0];
	}
	
	/**
	 * Realiza busca no banco, retornando o resultado em forma de objetos
	 * @param unknown $comando
	 * @param array $valores
	 * @return multitype:NULL
	 */
	function buscarObjetos( $comando, array $valores = array() ) {
		$objs = array();
			$ps = $this->executar( $comando, $valores );
			foreach ( $ps as $linha )
				$objs[] = $this->linhaParaObjeto( $linha );
		return $objs;
	}
	
	/**
	 * Realiza busca parametrizada
	 * @param number $limit
	 * @param number $offset
	 * @param array $ordenacoes Deve obedecer o formato: array( $nomeDoCampoOrdenador [=> 'desc' [, ... ]] )
	 * @param array $filtros Deve obedecer o formato: array( $nomeDoCampoFiltrador => $valorParaCampoFiltrador [, ... ] ) 
	 * @param string $exato
	 * @return multitype:NULL
	 */
    function todos($limit = 0, $offset = 0, array $ordenacoes = array(), array $filtros = array(), $exato = false ) {
		$operador = $exato ? ' = ' : ' LIKE ';
		$operador2 = $exato ? ''    : '%';
		$conectivo = $exato ? 'AND '    : 'OR ';
			
		// FILTRO
		$where = '';
		$valores = array();
	
		foreach( $filtros as $campo => $filtro ) {
			$valores[ $campo ] = $operador2 . $filtro . $operador2;
			if ( empty( $where ) ) {
				$where .= $campo . ' ' . $operador . ' :' . $campo . ' ';
			} else {
				$where .= $conectivo . $campo . ' ' . $operador . ' :' . $campo . ' ';
			}
		}
	
		// Adiciona a cláusula WHERE
		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}
	
		// ORDENAÇÃO
		$ordenacao = '';
	
		foreach ( $ordenacoes as $campo => $tipo  ) {
			if ( empty( $ordenacao ) ) {
				$ordenacao .= ' ORDER BY ' . $campo;
			} else {
				$ordenacao .= ', ' . $campo;
			}
				
			if (strtoupper($tipo) === 'DESC') {
				$ordenacao .= ' DESC';
			}
		}
		
		//LIMITACAO
		$limitacao = '';
		if( $limit > 0)
			$limitacao .= " LIMIT $limit OFFSET $offset ";
			
		$comando = "SELECT * FROM $this->tabela $where $ordenacao $limitacao";

		// Recupera os objetos
		return $this->buscarObjetos( $comando, $valores ); 
	}
	
}

?>