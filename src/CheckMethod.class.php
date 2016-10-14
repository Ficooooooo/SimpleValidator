<?php
/**
 * This file is part of SimpleValidator.
 *
 * @author lizishi <lizishi@baidu.com>
 */

/**
 * Class that contains a set of validating methods
 */
class CheckMethod {
	/**
	 * Allowed data type to be validated
	 *
	 * @var array
	 */
	private static $_type = array('boolean', 'integer', 'double', 'string', 'array', 'object');

	/**
	 * @param array $rule
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function checkType($rule, $value) {
		$compArr = array(
			'in' => self::$_type,
		);
		try {
			$this->checkValue($compArr, $rule);
		} catch (Exception $e) {
			throw new Exception('input type is not exist', 102);
		}
		$compArr = array(
			'=' => $rule,
		);
		try {
			$this->checkValue($compArr, gettype($value));
		} catch (Exception $e) {
			throw new Exception('type not match '.$rule, 101);
		}
		return true;
	}

	/**
	 * @param array $rule
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function checkValue($rule, $value) {
		if (count($rule) > 0) {
			foreach($rule as $comp => $limit) {
				switch($comp) {
				    case '>':
						if ($value <= $limit) {
							throw new Exception($value.' is not greater than '.$limit, 104);
						}
						break;
				    case '<':
						if ($value >= $limit) {
							throw new Exception($value.' is not less than '.$limit, 104);
						}
						break;
				    case '=':
						if ($value != $limit) {
							throw new Exception($value.' is not equal to '.$limit, 104);
						}
					    break;
				    case 'in':
						if (!is_array($limit) || !in_array($value, $limit)) {
							throw new Exception($value.' is not in set', 104);
						}
					    break;
				    case '>=':
						if ($value < $limit) {
							throw new Exception($value.' is not greater than or equal to '.$limit, 104);
						}
						break;
				    case '<=':
						if ($value > $limit) {
							throw new Exception($value.' is not less than or equal to '.$limit, 104);
						}
						break;
				    default:
						throw new Exception('unknown symbol '.$comp);
				}
			}
			return true;
		}else{
			throw new Exception('input rule is empty', 103);
		}
	}
	
	/**
	 * @param array $rule
	 * @param string $value
	 *
	 * @return boolean
	 */
	public function checkLength($rule, $value) {
		$this->checkType('string', $value);
		if (count($rule) == 2) {
			$rangeArr  = array();
			$this->checkType('integer', $rule[0]);
			if ($rule[0] != -1) {
				$rangeArr['>='] = $rule[0];
			}
			$this->checkType('integer', $rule[1]);
			if ($rule[1] != -1) {
				$rangeArr['<='] = $rule[1];
			}
			try {
				$this->checkValue($rangeArr, strlen($value));
			} catch (Exception $e) {
				throw new Exception('length is out of range', 105);
			}
			return true;
		}else{
			throw new Exception('format of length rule error', 105);
		}
	}

	/**
	 * @param array $rule
	 * @param string $value
	 *
	 * @return boolean
	 */
	public function checkReg($rule, $value) {
		try {
			$this->checkType('string', $rule);
		} catch (Exception $e) {
			throw new Exception('input Regular Expression is not string', 106);
		}
		if (!preg_match($rule, $value)) {
			throw new Exception('regex match failed', 107);
		}
		
	}

	/**
	 * @param array $rule
	 * @param array $value
	 *
	 * @return boolean
	 */
	public function dealArray($method, $rule,  $value) {
		if ($rule['range'] == 0) {
			foreach($value as $item) {
				$this->$method($rule['rule'], $item);
			}
		}else if ($rule['range'] == 1 && is_array($rule['keys'])) {
			foreach($rule['keys'] as $key=>$isAlt) {
				if ($key != '') {
					if (!isset($value[$key])) {
						if ($isAlt == 1) {
							continue;
						}else{
							throw new Exception('key \''.$key.'\' is not exist', 110);
						}
					}
					$this->$method($rule['rule'], $value[$key]);
				}else{
					throw new Exception('array checked key is empty', 109);
				}
			}
		}else{
			throw new Exception('parameter \'range\' error', 108);
		}
	}
	
}