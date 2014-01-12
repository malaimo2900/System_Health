<?php

/**
 * Utilities which operate on arrays
 */
class ArrayUtils {
    
	/**
	 * Takes one array of values and equates them to the keys of a different array
	 * @param $keyVals array - an array of values which you wish to test for keys on the $dataArray parameter
	 * @param $dataArray array - an array with a key->value pair
	 * @return boolean - TRUE if values from $keyVals == keys of the $dataArray
	 */
    public static function valuesEqKeys(array $keyVals, array $dataArray) {
        return ($keyVals != array_keys($dataArray));
    }
    
	/**
	 * Returns a boolean result if every string has a length
	 * @param $data array - An array of strings
	 * @return boolean - TRUE if every string has a length
	 */
    public static function strHasLen(array $data) {
        $result = TRUE;
        foreach ($data as $d) {
            if (!strlen($d)) {
                $result = FALSE;
                break;
            }
        }
        return $result;
    }
    
}