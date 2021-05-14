<?php

/**
 * This is the base model class for the database table 'car_part'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 * If any changes are required, override them in the 'MyAppTest\CarPart' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property integer $car_id
 * @property integer $part_id
 * @property \MyAppTest\Car $car
 * @property \MyAppTest\Part $part
 *
 * @method \MyAppTest\CarPart save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseCarPart extends \MyAppTest\ORMBaseClass {
    public static $_table = 'car_part';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryCarPart
	 */
	public static function model() {
		return \Granada\Granada::factory(\MyAppTest\CarPart::class);
	}

    public function car() {
        return $this->belongs_to(\MyAppTest\Car::class, 'car_id');
    }

    public function part() {
        return $this->belongs_to(\MyAppTest\Part::class, 'part_id');
    }

	/**
	 * @return string The current namespace
	 */
	public function getNamespace() {
		return 'MyAppTest';
	}

	/**
	 * @return string The current model name
	 */
	public function getModelname() {
		return 'CarPart';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = [
		'id' => 'integer',
		'car_id' => 'reference',
		'part_id' => 'reference',
		];
		if (!array_key_exists($field_name, $fields)) {
			return false;
		}
		return $fields[$field_name];
	}

	/**
	 * Get the database table name
	 *
	 * @return string Table name
	 */
	public function tableName() {
		return 'car_part';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Car Part';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Car Part');
	}

	/**
	 * The columns used as part of the representation method
	 */
	public static function uniqueColumns() {
		return [
		];
	}

	/**
	 * Is this model a nestedSet ?
	 * @return boolean
	 */
	public static function isNestedSet() {
		return false;
	}

	/**
	 * The column used as the main identifier for the model
	 * @return string
	 */
	public static function defaultOrder() {
		return 'id';
	}

	/**
	 * The column used as the main identifier for the model
	 */
	public static function primaryColumn() {
		return 'id';
	}

	/**
	 * The value of the main identifier for the model
	 */
	public function representation() {
		return $this->id;
	}

    /**
     * The columns used as part of the representation method
     */
    public static function representationColumns() {
            return ['id'];
    }

	/**
	 * Any fields listed in this array will not affect the updated_at and created_at timestamp fields on save
	 * Override to ignore more
	 */
	public function ignoreDirtyForTimestamps() {
		return [
		];
	}

	/**
	 * Check that the model has a field name
	 *
	 * @var string $field
	 * @return boolean
	 */
	public static function hasAttribute($field) {
		return array_key_exists($field, self::attributes());
	}

	/**
	 * List of fields in the model
	 *
	 * @return string[]
	 */
	public static function attributes() {
		return [
			'id' => 'id',
			'car_id' => 'car_id',
			'part_id' => 'part_id',
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\CarPart
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\CarPart::hasAttribute($key) && $this->$key !== $val) {
				$this->$key = $val;
			}
		}
		return $this;
	}

	/**
	 * Get list of date fields, used for timezone conversion
	 *
	 * @return array list of fields
	 */
	public function datefields() {
		return [
		];
	}

	public static function enum_options($field_name) {
		return [];
	}

	/**
	 * Should we delete this record for real or just flag as deleted?
	 * Uses the is_deleted field
	 *
	 * @return boolean
	 */
	public function fakeDelete() {
		return false;
	}

	/**
	 * Get the model names for the lookup
	 *
	 * @param string name of the variable
	 * @return string
	 */
	public static function refModel($varname) {
		if ($varname == 'car_id') {
			return '\MyAppTest\Car';
		}
		if ($varname == 'part_id') {
			return '\MyAppTest\Part';
		}
		return false;
	}

	/**
	 * Get the list of tags from the database comment
	 * @param string $field the field name
	 * @return string[] list of comment tags (_ prefixes)
	 */
	public function fieldTags($field) {
		$tags = [
			'id' => [
			],
			'car_id' => [
			],
			'part_id' => [
			],
		];
		if (!array_key_exists($field, $tags)) {
			return [];
		}
		return $tags[$field];
	}

	/**
	 * Get the human name of the field
	 * @param string $field the field name
	 * @return string The field human name
	 */
	public function fieldHumanName($field) {
		$items = [
			'id' => 'Id',
			'car_id' => 'Car',
			'part_id' => 'Part',
		];
		if (!array_key_exists($field, $items)) {
			return [];
		}
		return $items[$field];
	}

	/**
	 * Get the help text from the database comment.
	 * It is basically the comment minus the tags (_ prefixes)
	 * @param string $field the field name
	 * @return string The field comment
	 */
	public function fieldHelpText($field) {
		$items = [
			'id' => '',
			'car_id' => '',
			'part_id' => '',
		];
		if (!array_key_exists($field, $items)) {
			return [];
		}
		return $items[$field];
	}

	/**
	 * Get the fields for admin list
	 * @return string[] admin list fields
	 */
	public function adminFields() {
		return [
			'car_id',
			'part_id',
		];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public function formFields() {
		return [
			'car_id',
			'part_id',
		];
	}

	/**
	 * Get list of defaults for each field
	 * @return array
	 */
	public static function defaultValues() {
		return [
			'id' => '',
			'car_id' => '',
			'part_id' => '',
		];
	}

	/**
	 * Get the field default value
	 * @param string $field
	 * @return mixed
	 */
	public function fieldDefaultValue($field) {
		$items = self::defaultValues();
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}

	/**
	 * Get the field max length
	 * @param string $field
	 * @return integer
	 */
	public function fieldLength($field) {
		$items = [
			'id' => 11,
			'car_id' => 11,
			'part_id' => 11,
		];
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}

	/**
	 * Get whether the field is required
	 * @param string $field
	 * @return boolean
	 */
	public function fieldIsRequired($field) {
		$items = [
			'id' => false,
			'car_id' => false,
			'part_id' => false,
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
