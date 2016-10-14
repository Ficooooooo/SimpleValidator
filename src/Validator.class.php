<?php
/**
 * This file is part of SimpleValidator.
 *
 * @author lizishi <lizishi@baidu.com>
 */
include_once __DIR__.'/CheckMethod.class.php';

/**
 * Base class of Validator
 */
class Validator {
	/**
	 * @param array $schema
	 * @param mixed $value
	 * @param string $errmsg
	 *
	 * @return boolean
	 */
	public static function validate($schema, $value, &$errmsg) {
		try {
			$result = true;
			$obj = new CheckMethod();
			if (is_array($schema) && count($schema) > 0) {
				foreach($schema as $method => $rule) {
					if (method_exists($obj, $method)) {
						if (is_array($value)) {
							try {
								$ret = $obj->dealArray($method, $rule, $value);
							} catch (Exception $e) {
								$errmsg = $e->getMessage();
								return false;
							}
						}else{
							try {
								$ret = $obj->$method($rule, $value);
							} catch (Exception $e) {
								$errmsg = $e->getMessage();
								return false;
							}
						}
					}else{
						$errmsg = 'validate method not exist';
						return false;
					}
				}
				return true;
			}else{
				$errmsg = 'validate method is empty';
				return false;
			}
		} catch (Exception $e) {
			$errmsg = 'unknown error';
			return false;
		}
	}
}