<?php

/**
 * This is the base model class for the database table 'timezone_test'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 * If any changes are required, override them in the 'MyAppTest\TimezoneTest' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $datetime1
 * @property \Cake\Chronos\Chronos $datetime1_chronos
 * @property string $datetime2
 * @property \Cake\Chronos\Chronos $datetime2_chronos
 * @property string $datetime3
 * @property \Cake\Chronos\Chronos $datetime3_chronos
 * @property string $datetime4
 * @property \Cake\Chronos\Chronos $datetime4_chronos
 * @property string $datetime5
 * @property \Cake\Chronos\Chronos $datetime5_chronos
 * @property string $date1
 * @property \Cake\Chronos\Chronos $date1_chronos
 * @property string $time1
 * @property \Cake\Chronos\Chronos $time1_chronos
 *
 * @method \MyAppTest\TimezoneTest save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseTimezoneTest extends \MyAppTest\ORMBaseClass {
    public static $_table = 'timezone_test';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryTimezoneTest
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\TimezoneTest');
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
		return 'TimezoneTest';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = [
		'id' => 'integer',
		'datetime1' => 'datetime',
		'datetime2' => 'datetime',
		'datetime3' => 'datetime',
		'datetime4' => 'datetime',
		'datetime5' => 'datetime',
		'date1' => 'date',
		'time1' => 'time',
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
		return 'timezone_test';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Timezone Test';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Timezone Test');
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
			'datetime1' => 'datetime1',
			'datetime2' => 'datetime2',
			'datetime3' => 'datetime3',
			'datetime4' => 'datetime4',
			'datetime5' => 'datetime5',
			'date1' => 'date1',
			'time1' => 'time1',
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\TimezoneTest
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\TimezoneTest::hasAttribute($key) && $this->$key !== $val) {
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
			'datetime1' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			],
			'datetime2' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'none',
				'timezone_comparison_mode' => 'none',
			],
			'datetime3' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'site',
				'timezone_comparison_mode' => 'none',
			],
			'datetime4' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'user',
			],
			'datetime5' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'site',
			],
			'date1' => [
				'type' => 'date',
				'format' => 'Y-m-d',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			],
			'time1' => [
				'type' => 'time',
				'format' => 'H:i:s',
				'timezone_mode' => 'none',
				'timezone_comparison_mode' => 'none',
			],
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
			'datetime1' => [
			],
			'datetime2' => [
				'_timezone_none',
			],
			'datetime3' => [
				'_timezone_sitewide',
			],
			'datetime4' => [
				'_timezone_compare_user',
			],
			'datetime5' => [
				'_timezone_compare_sitewide',
			],
			'date1' => [
			],
			'time1' => [
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
			'datetime1' => 'Datetime1',
			'datetime2' => 'Datetime2',
			'datetime3' => 'Datetime3',
			'datetime4' => 'Datetime4',
			'datetime5' => 'Datetime5',
			'date1' => 'Date1',
			'time1' => 'Time1',
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
			'datetime1' => '',
			'datetime2' => '',
			'datetime3' => '',
			'datetime4' => '',
			'datetime5' => '',
			'date1' => '',
			'time1' => '',
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
			'datetime1',
			'datetime2',
			'datetime3',
			'datetime4',
			'datetime5',
			'date1',
		];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public function formFields() {
		return [
			'datetime1',
			'datetime2',
			'datetime3',
			'datetime4',
			'datetime5',
			'date1',
			'time1',
		];
	}

	/**
	 * Get list of defaults for each field
	 * @return array
	 */
	public static function defaultValues() {
		return [
			'id' => '',
			'datetime1' => '',
			'datetime2' => '',
			'datetime3' => '',
			'datetime4' => '',
			'datetime5' => '',
			'date1' => '',
			'time1' => '',
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
			'datetime1' => 0,
			'datetime2' => 0,
			'datetime3' => 0,
			'datetime4' => 0,
			'datetime5' => 0,
			'date1' => 0,
			'time1' => 0,
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
			'datetime1' => false,
			'datetime2' => false,
			'datetime3' => false,
			'datetime4' => false,
			'datetime5' => false,
			'date1' => false,
			'time1' => false,
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
