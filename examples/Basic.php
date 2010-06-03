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

//curry: allows for functional curry techniques, (only works on functions with defined parameters).
$add_three_numbers = curry( function ( $a, $b, $c ) {
    return $a + $b + $c;
} );
$add_ten_to_two_numbers = $add_three_numbers( 10 );
var_dump( $add_ten_to_two_numbers( 1, 2 ) ); // int(13)
$add_15_to_one_number = $add_ten_to_two_numbers( 5 );
var_dump( $add_15_to_one_number( 27 ) ); // int(42)

//composition: (f.g)x == f(g(x))
$not_return_value = composition( "doubleValue", "add5" );
var_dump( $not_return_value( 1 ) ); //int(12)
var_dump( $not_return_value( 0 ) ); //int(10)

//fix: passes the function into it's self as the first parameter, allows resursive annoymous functions
$fib = fix( function( $fib, $n ) {
	if( $n <= 0 ) return 0;
	if( $n <= 2 ) return 1;
	
	return $fib( $fib, $n - 1 ) + $fib( $fib, $n - 2 ); 
} );

//lazy_map: maps each element in the array to the function (like array_map). Outputted value is only evaluated on demand
$lazy_map = lazy_map( $fib, array( 2, 5, 100000, 10 ) );

var_dump( $lazy_map[0] ); //int(1)
var_dump( $lazy_map[1] ); //int(5)
//$fib( 100000 ) is never evaluated, since we don't ask for it
var_dump( $lazy_map[3] ); //int(55)

?>