<?php
/**
 * This file is the demo about how to use SimpleValidator.
 */
include_once __DIR__.'/src/Validator.class.php';

/**
 * Demo that check if argument's type is integer
 */
$errmsg = '';
$schema = array('checkType' => 'integer');
$ret = Validator::validate($schema, 123, $errmsg);

/**
 * Demo that check if argument's value is equal to 3
 */
$errmsg = '';
$schema = array('checkValue' => array('=' => 3));
$ret = Validator::validate($schema, 3, $errmsg);

/**
 * Demo that check if argument's length is between 1 and 3 
 */
$errmsg = '';
$schema = array('checkLength' => array(1,3));
$ret = Validator::validate($schema, '123', $errmsg);

/**
 * Demo that check if argument's value match the given RegEx
 */
$errmsg = '';
$schema = array('checkReg' => '/^w+$/');
$ret = Validator::validate($schema, 'haha', $errmsg);

/**
 * Demo that check if the items' value in array is match the given rules
 */
$errmsg = '';
$schema = array(
	'checkType' => array(
		'rule' => 'string',
		'range' => 0,
	),
);
$ret = Validator::validate($schema, array('123', '456'), $errmsg);









