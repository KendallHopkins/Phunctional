<?php

require_once( "Phunctional/LazyMap.php" );
require_once( "Phunctional/Function.php" );

if( ! function_exists( "curry" ) ) {
	function curry( $function )
	{
		return new Phunctional_Function( $function );
	}
}

if( ! function_exists( "fix" ) ) {
	function fix( $function )
	{
		return function() use ( $function )
		{
		    $param_array = func_get_args();
		    array_unshift( $param_array, $function );
		    return call_user_func_array( $function, $param_array );
		};
	}
}

if( ! function_exists( "foldl" ) ) {
	function foldl( $function, $init_value, array $value_arary )
	{
		$current_value = $init_value;
		foreach( $value_arary as $value ) {
			$current_value = call_user_func( $function, $current_value, $value );
		}
		return $current_value;
	}
}

if( ! function_exists( "foldr" ) ) {
	function foldr( $function, $final_value, array $value_arary )
	{
		$current_value = $final_value;
		foreach( array_reverse( $value_arary ) as $value ) {
			$current_value = call_user_func( $function, $current_value, $value );
		}
		return $current_value;
	}
}

if( ! function_exists( "lazy_map" ) ) {
	function lazy_map( $function, array $array )
	{
		return new Phunctional_LazyMap( $function, $array );
	}
}

if( ! function_exists( "map" ) ) {
	function map( $function, array $array )
	{
		return array_map( $function, $array );
	}
}

if( ! function_exists( "composition" ) ) {
	function composition()
	{
		$function_array = func_get_args();
		if( ! $function_array )
			throw new Exception( "must composite at least 1 function" );
		
		return function() use ( $function_array ) {
			$current_value_array = func_get_args();
			foreach( array_reverse( $function_array ) as $function ) {
				$current_value_array = array( call_user_func_array( $function, $current_value_array ) );
			}
			return $current_value_array[0];
		};
	}
}

?>