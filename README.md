# Simple Validator
---
A component that provide validate function written by php


## Start up 
---
To use Simple Validator you just need to inlude the `Validator.class.php` file which in dir `src/` into your code.

After this, you just need construct a schema, and call method static method `validate()` to check argument's type, range and length.


	boolean validate(array $schema, mixed $value, string, $errmsg)
	
Example:

	$errmsg = '';
	$schema = array(
		'CheckType' => 'string',
		'CheckValue' => array(
			'=' => 'abc',
			),
		);
	$ret = Validator::validate($schema, $value, $errmsg);

After Calling this function, `$errmsg` will be null and `$ret` will be true if the value if meet the condition in `$schema`, in this example, method will check if `$value`'s type is string and whether it's value is equal to `abc`.


## Parameters
---
####schema
This parameter is describe the validate method and validate rule, the format of it is:
	
	array(string $methodName1 => mixed $rule1 [, string $methodName2 => mixed rule2 [,...]]);
Different method has different rule, all methods are listed in  chapter **CheckMethod**.
####value
Parameter that user want to validate.
####errmsg
The error message in check process will save in this parameter.


## CheckMethod
---
####CheckType
This method is for validating the type of argument, rule's format is:
	
	string $type
	
	value is taken from 'string', 'integer', 'double', 'array', 'boolean', 'object'
	
####CheckValue
This method is for validating the value of argument, rule's format is:
	
	array(string $operator => mixed $limitvalue)
	
	operator can be: >, <, =, >=, <=, in,
	when operator is 'in', the limitvalue needs to by a array all comparison value 	
	
####CheckLength
This method is for validating the length of a string, rule's format is:
	
	array(int $lowerlimit, int $upperlimit)
	
	if $lowerlimit's value is -1, means no lowerlimit, so does $upperlimit
	
####CheckReg
This method is for validating the length of a string, rule's format is:

	string $regex

## DealWithArray
---
When `$value` of valiate's type is array, `rule` of `$schema` needs to be array, and has some extend field, format of rule is:

	array(
		'rule' => regularRule,
		'range' => 0 or 1  
		/**
		 * 0: check all item of array by rule above   
		 * 1: just check some specific item of array which keys are given
		 */
		'keys' => array(
			keys1 => 0 or 1 
			/**
			 * 0: has to be exist, if item of this key doesn't exist, there will be an exception 
			 * 1: if item of this key is exist, then check by rule, if not, then skip this item's checking
			 */
			keys2 => 0 or 1
			
		)
	)
	
For example:
	
	$schema = array(
            'checkType' => array(
                'rule' => 'integer',
                'range' => 1,
                'keys' => array(
                    'five' => 1,
                    'four' => 0,
                ),
            ),
            'checkValue' => array(
                'rule' => array('>' => '0'),
                'range' => 0,
            ),
        );
        $array = array(
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
        );
        Validator::validate($schema, $array, $errmsg);
        
The code intent to check is value's type of item of key `five` and 
`four` is integer, and is key `four` exist, and every value of item in array is greater than 0, in this case, validate will failed if anyone condition is not satisfied.

##Creating customized check method
---
All check method is in file `./src/CheckMethod.class.php`, you can create check method to meet your special demand by the followed steps

1. add a function named whatever you want in class `CheckMethod.class.php`.

2. design and implement that method.

3. construct the `$schema` follow the format like
	
	
	array('yourOwnMethodName' => 'yourOwnRule');
	
	
4. Validator::validate($schema, $value, $errmsg)
	

