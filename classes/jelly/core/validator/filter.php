<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class that all validation filters are converted to.
 *
 * @package Jelly
 */
class Jelly_Core_Validator_Filter extends Jelly_Validator_Callback
{
	/**
	 * Creates a new filter.
	 * 
	 * If $params is empty or doesn't contain the :value context, the
	 * :value context is added to the front of the array as was the 
	 * behavior for the old validate class.
	 *
	 * @param  callback  $callback 
	 * @param  array     $params 
	 */
	public function __construct($callback, array $params = NULL)
	{
		$params = $params ? $params : array();
		
		// Check the parameters to see if we need to add ':value'
		if ( ! in_array(':value', $params))
		{
			array_unshift($params, ':value');
		}
		
		parent::__construct($callback, $params);
	}
	
	/**
	 * Calls the rule and returns a value.
	 * 
	 * For filters, the value returned replaces the value in the validation array.
	 *
	 * @param   Validation $validate
	 * @return  mixed
	 */
	public function call(Validation $validate)
	{
		$field = $validate->context('field');
		
		// Replace the current value with that which is returned
		$validate[$field] = parent::call($validate);
	}

} // End Kohana_Validate_Filter
