<?php

class Phunctional_LazyMap implements ArrayAccess, Iterator
{

	private $_function;
	private $_array;
	private $_array_keys;
	private $_cached_array = array();
	
	public function __construct( $function, array $array )
	{
		$this->_function = $function;
		$this->_array = $array;
		$this->_array_keys = array_keys( $array );
	}
	
	// with function isset()
	public function offsetExists( $offset )
	{
		return array_key_exists( $offset, $this->_array );
	}
	
	public function offsetGet( $offset )
	{
		if( ! array_key_exists( $offset, $this->_cached_array ) )
			$this->_cached_array[$offset] = call_user_func( $this->_function, $this->_array[$offset] );
		
		return $this->_cached_array[$offset];
	}
	
	public function offsetSet( $offset, $value )
	{
		return $this->_cached_array[$offset] = $value;
	}
	
	public function offsetUnset( $offset )
	{
		unset( $this->_array[$offset] );
		unset( $this->_cached_array[$offset] );
	}
	
	
	private $position = 0; 

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->offsetGet( $this->_array_keys[ $this->position ] );
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return array_key_exists( $this->position, $this->_array_keys );
    }
	
}

?>