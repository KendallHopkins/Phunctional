<?php

require( "../Phunctional.php" );

function doubleValue( $n )
{
	return $n * 2;
}

function add5( $n )
{
	return $n + 5;
}

//composition: (f.g)x == f(g(x))
$not_return_value = composition( "doubleValue", "add5" );
var_dump( $not_return_value( 1 ) );
var_dump( $not_return_value( 0 ) );

//fix: passes the function into it's self as the first parameter, allows resursive annoymous functions
$fib = fix( function( $fib, $n ) {
	if( $n <= 0 ) return 0;
	if( $n <= 2 ) return 1;
	
	return $fib( $fib, $n - 1 ) + $fib( $fib, $n - 2 ); 
} );

//lazy_map: maps each element in the array to the function (like array_map). Outputted value is only evaluated on demand
$lazy_map = lazy_map( $fib, array( 2, 5, 100000, 10 ) ); //$fib( 100000 ) is never evaluated

var_dump( $lazy_map[0], $lazy_map[1], $lazy_map[3] );

?>