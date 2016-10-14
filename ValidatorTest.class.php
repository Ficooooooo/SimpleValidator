<?php
/**
 * This file is testcase of SimpleValidator used PHPUnit
 *
 * @author lizishi <lizishi@baidu.com>
 */
include_once __DIR__.'/src/Validator.class.php';

/**
 * A set of testcase of Validator
 */
class ValidatorTest extends PHPUnit_Framework_TestCase {
	public function testCheckRange() {
		$schema = array('checkValue' => array('=' => 'abc'));
		$this->assertEquals(true, Validator::validate($schema, 'abc', $errmsg));
		$schema = array('checkValue' => array('in' => array('abc','bcd')));
		$this->assertEquals(true, Validator::validate($schema, 'abc', $errmsg));
		$schema = array('checkValue' => array('>' => '5'));
		$this->assertEquals(true, Validator::validate($schema, '6', $errmsg));
		$schema = array('checkValue' => array('<' => '5'));
		$this->assertEquals(true, Validator::validate($schema, '4', $errmsg));
		$schema = array('checkValue' => array('>=' => '5'));
		$this->assertEquals(true, Validator::validate($schema, '5', $errmsg));
		$schema = array('checkValue' => array('<=' => '5'));
		$this->assertEquals(true, Validator::validate($schema, '5', $errmsg));
	}

	public function testCheckLength() {
		$schema = array('checkLength'  =>  array(1, 9));
		$this->assertEquals(true, Validator::validate($schema, 'asdasdasd', $errmsg));
		$schema = array('checkLength'  =>  array(1, 5));
		$this->assertEquals(false, Validator::validate($schema, 'asdasdasd', $errmsg));
	}

	public function testCheckType() {
		$schema = array('checkType' => 'string');
		$this->assertEquals(true, Validator::validate($schema, '123', $errmsg));
		$schema = array('checkType' => 'string');
		$this->assertEquals(false, Validator::validate($schema, 123, $errmsg));
	}

	public function testCheckReg() {
		$schema = array('checkReg' => '/^\d+$/');
		$this->assertEquals(true, Validator::validate($schema, '123', $errmsg));
		$schema = array('checkReg' => '/^\d+$/');
		$this->assertEquals(false, Validator::validate($schema, '12aa', $errmsg));
	}

	public function testCheckArrayFunc() {
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
		$this->assertEquals(true, Validator::validate($schema, $array, $errmsg));
	}
	
}
