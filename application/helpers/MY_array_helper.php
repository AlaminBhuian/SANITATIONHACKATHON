<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
	Copyright (c) 2011 Lonnie Ezell

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

/*
	File: Array Helper
	
	Provides additional functions for working with arrays.
*/

/*
	Function: array_index_by_key()
	
	When given an array of arrays (or objects) it will return the index of the 
	sub-array where $key == $value.
	
	Given the following array
	
	> $array = array(
	> 	[0] => array(
	>		'value'	=> 1
	>	),
	>	[1] => array(
	>		'value'	=> 2
	>	)
	> );
	
	you could find the index of the second array with the command
	
	> // Returns 1
	> array_index_by_key('value', 2, $array);
	
	Parameters:
		$key		- The key to search on
		$value		- The value the key should be
		$array		- The array to search through
		$identical	- Whether to perform a strict type-checked comparison
		
	Returns:
		An INT that is the index of the sub-array, or false.
*/
if (!function_exists('array_index_by_key'))
{

	function array_index_by_key($key=null, $value=null, $array=null, $identical=false)
	{	
		if (empty($key) || empty($value) || !is_array($array))
		{
			return false;
		}
		
		foreach ($array as $index => $sub_array)
		{		
			$sub_array = (array)$sub_array;
			
			if (array_key_exists($key, $sub_array))
			{
				if ($identical)
				{
					if ($sub_array[$key] === $value)
					{
						return $index;
					}
				} else
				{
					if ($sub_array[$key] == $value)
					{
						return $index;
					}
				}
			}
		}
	}

}


/*
 * multi-dimensional array, but only the keys I wanted, not all keys
 * 
 //   $needle = array('date_start' => '27-10-2010', 'date_end' => '29-10-2010');
//    $haystack = array();
//    $haystack[] = array('date_start' => '25-10-2010', 'date_end' => '26-10-2010', 'promos' => array('test', 'test1');
//    $haystack[] = array('date_start' => '27-10-2010', 'date_end' => '28-10-2010', 'promos' => array('test2', 'test3');
//    $haystack[] = array('date_start' => '27-10-2010', 'date_end' => '29-10-2010', 'promos' => array('test4', 'test5');
//
//    $key = my_array_search($needle, $haystack);
//    // will output (bool)false for not found or (int)key_no with the key number
//    // this example outputs (int)2
//    var_dump($key);
 */

if (!function_exists('multi_dimensional_array_search'))
{
    /*
     * 2D array data findings
     */

    function multi_dimensional_array_search($needle, $haystack)
    {
        if (empty($needle) || empty($haystack))
        {
            return false;
        }

        foreach ($haystack as $key => $value)
        {
            $exists = 0;
            foreach ($needle as $nkey => $nvalue)
            {
                if (!empty($value[$nkey]) && $value[$nkey] == $nvalue)
                {
                    $exists = 1;
                } else
                {
                    $exists = 0;
                }
            }
            if ($exists)
                return $key;
        }

        return false;
    }
}

//--------------------------------------------------------------------