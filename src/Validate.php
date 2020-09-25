<?php

namespace Granada\Builder;

class Validate {

	/**
	 * Check that the data is not empty
	 *
	 * @param mixed $data
	 * @return boolean
	 */
	public static function check_not_null($data) {

		if (\Respect\Validation\Validator::nullType()->validate($data)) {
			return 'This cannot be left empty';
		}

		return true;
	}

	public static function check_not_empty($data) {

		if (\Respect\Validation\Validator::nullType()->validate($data)) {
			return 'This cannot be left empty';
		}

		if (!\Respect\Validation\Validator::notEmpty()->validate($data)) {
			return 'This cannot be left empty';
		}

		return true;
	}

	public static function check_boolean($data) {
		if (\Respect\Validation\Validator::boolVal()->validate($data)) {
			return true;
		}

		return 'This should be a boolean';
	}

	public static function check_integer($data) {
		if (\Respect\Validation\Validator::intVal()->validate($data)) {
			return true;
		}

		return 'Please enter a whole number';
	}

	public static function check_float($data) {
		if (\Respect\Validation\Validator::floatVal()->validate($data)) {
			return true;
		}

		return 'Please enter a number';
	}

	public static function check_color($data) {
		if (\Respect\Validation\Validator::hexRgbColor()->validate($data)) {
			return true;
		}

		return 'Please enter a html colour';
	}

	public static function check_url($data) {
		if (\Respect\Validation\Validator::slug()->validate($data)) {
			return true;
		}

		return 'This slug is not valid';
	}

	public static function check_enum($data, $optstring) {
		$optx = explode(',', $optstring);
		foreach ($optx as $opt) {
			$optname = str_replace('&#039;', '', $opt);
			if ($data == $optname) {
				return true;
			}
		}
		return 'Choose an item from the list';
	}

	public static function check_datetime($data) {
		if (\Respect\Validation\Validator::date()->validate($data)) {
			return true;
		}

		return 'Please enter a date/time';
	}

	public static function check_date_of_birth($data) {
		if (\Respect\Validation\Validator::date('d/m/Y')->validate($data)) {
			return true;
		}

		return 'Please enter a date';
	}

	public static function check_string($data, $length) {
		if (\Respect\Validation\Validator::stringType()->length(null, $length)->validate($data)) {
			return true;
		}
		if (\Respect\Validation\Validator::stringType()->validate($data)) {
			return 'String too long. Max ' . $length . ' characters';
		}

		return 'Invalid';
	}

	public static function check_reference($data, $refmodel) {
		if (!is_numeric($data)) {
			return 'Not a reference';
		}
		$count = $refmodel::model()->where('id', $data)->count();
		if ($count) {
			return true;
		}

		return 'Could not find this item';
	}

	public static function check_email($data) {
		if (\Respect\Validation\Validator::email()->validate($data)) {
			return true;
		}

		return 'Please enter an email address';
	}

	public static function check_phone($data) {
		if (\Respect\Validation\Validator::stringType()->length(10, null)->validate($data)) {
			if (\Respect\Validation\Validator::phone()->validate($data)) {
				return true;
			}
		}
		if ($data == 'N/A') {
			return true;
		}

		return 'Please enter a valid phone number with area code';
	}

}
