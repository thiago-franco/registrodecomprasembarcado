<?php

abstract class ServicoAbstrato {
	
	function repositorio() {
		return $this->repositorio;
	}
	
	function salvar( $obj ) {
		try{
			$this->validadora->validar( $obj );
			if( $this->repositorio->existe( $obj ) )
				$this->repositorio->atualizar( $obj );
			else
				$this->repositorio->adicionar( $obj );
		}  catch ( RepositorioException $e ) {
			throw new ServicoException("Erro ao tentar salvar objeto.");
		}
	}
	
	function remover( $id ) { // throw
		if ( ! is_numeric( $id ) || $id < 0 ) {
			throw new ServicoException( 'Id deve ser um número positivo.' );
		}
		$obj = $this->repositorio->comId( $id );
		if ( ! isset( $obj ) ) {
			throw new ServicoException( 'Não foi encontrado um registro com o id fornecido.' );
		}
		$this->repositorio->remover( $obj );
	}
	
	function contar( ) {
		return $this->repositorio->contarLinhas();
	}
	
	function comId( $id ) {
		return $this->repositorio->comId( $id );
	}
	
	function existe( $obj ) {
		return $this->repositorio->existe( $obj );
	}
	
}

?>