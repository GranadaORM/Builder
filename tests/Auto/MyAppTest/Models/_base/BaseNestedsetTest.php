<?php

/**
 * This is the base model class for the database table 'nestedset_test'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 * If any changes are required, override them in the 'MyAppTest\NestedsetTest' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $name
 * @property integer $root
 * @property integer $level
 * @property integer $lft
 * @property integer $rgt
 *
 * @method \MyAppTest\NestedsetTest save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseNestedsetTest extends \MyAppTest\ORMBaseClass {
    public static $_table = 'nestedset_test';

	/**
	 * Quick starting point for all queries
	 * @return \MyAppTest\QueryNestedsetTest
	 */
	public static function q() {
		return self::model();
	}

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryNestedsetTest
	 */
	public static function model() {
		return \Granada\Granada::factory(\MyAppTest\NestedsetTest::class);
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
		return 'NestedsetTest';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = [
		'id' => 'integer',
		'name' => 'string',
		'root' => 'integer',
		'level' => 'integer',
		'lft' => 'integer',
		'rgt' => 'integer',
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
		return 'nestedset_test';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Nestedset Test';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Nestedset Test');
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
		return true;
	}

	/**
	 * The column used as the main identifier for the model
	 * @return string
	 */
	public static function defaultOrder() {
		return 'root,lft';
	}

	/**
	 * The column used as the main identifier for the model
	 */
	public static function primaryColumn() {
		return 'name';
	}

	/**
	 * The value of the main identifier for the model
	 */
	public function representation() {
		return $this->name;
	}

    /**
     * The columns used as part of the representation method
     */
    public static function representationColumns() {
            return ['name'];
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
			'name' => 'name',
			'root' => 'root',
			'level' => 'level',
			'lft' => 'lft',
			'rgt' => 'rgt',
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\NestedsetTest
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\NestedsetTest::hasAttribute($key) && $this->$key !== $val) {
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
			'name' => [
			],
			'root' => [
			],
			'level' => [
			],
			'lft' => [
			],
			'rgt' => [
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
			'name' => 'Name',
			'root' => 'Root',
			'level' => 'Level',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
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
			'name' => '',
			'root' => '',
			'level' => '',
			'lft' => '',
			'rgt' => '',
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
			'name',
		];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public function formFields() {
		return [
			'name',
		];
	}

	/**
	 * Get list of defaults for each field
	 * @return array
	 */
	public static function defaultValues() {
		return [
			'id' => '',
			'name' => '',
			'root' => '',
			'level' => '',
			'lft' => '',
			'rgt' => '',
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
			'name' => 190,
			'root' => 11,
			'level' => 11,
			'lft' => 11,
			'rgt' => 11,
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
			'name' => true,
			'root' => true,
			'level' => true,
			'lft' => true,
			'rgt' => true,
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
