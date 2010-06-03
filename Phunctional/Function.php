<?php

class Phunctional_Function
{
	
	private $_function;
	private $_function_size;
	private $_parameters = array();
	
	static public function factory( $function )
	{
		return new self( $function );
	}
	
	function __construct( $function )
	{
		$this->_function = $function;
		$function_reflection = new ReflectionFunction( $function );
		$this->_function_size = count( $function_reflection->getParameters() );
	}
	
	function __invoke()
	{
		$param_array = func_get_args();
		if( ! $param_array ) {
			return call_user_func_array( $this->_function, $this->_parameters );		
		}
		
		$new_function = clone $this;
		$new_function->_parameters = array_merge( $new_function->_parameters, $param_array );
		
		if( count( $new_function->_parameters ) > $this->_function_size ) {
			throw new Exception( "To many variables were curried" );
		}
		
		if( count( $new_function->_parameters ) === $this->_function_size ) {
			return call_user_func_array( $new_function->_function, $new_function->_parameters );			
		} else {
			return $new_function;			
		}
	}
	
	function curry()
	{
		$param_array = func_get_args();
		if( ! $param_array ) {
			return call_user_func_array( $this->_function, $this->_parameters );		
		}
		
		$new_function = clone $this;
		$new_function->_parameters = array_merge( $new_function->_parameters, $param_array );
		
		if( count( $new_function->_parameters ) > $this->_function_size ) {
			throw new Exception( "To many variables were curried" );
		}
		
		if( count( $new_function->_parameters ) === $this->_function_size ) {
			return call_user_func_array( $new_function->_function, $new_function->_parameters );			
		} else {
			return $new_function;			
		}
	}
	
	function fix()
	{
		$new_function = clone $this;
		$new_function->_parameters = array_merge( $new_function->_function, $new_function->_parameters );
		return $new_function;
	}
	
}

?>