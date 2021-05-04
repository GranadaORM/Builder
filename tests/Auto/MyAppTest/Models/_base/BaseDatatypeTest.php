<?php

/**
 * This is the base model class for the database table 'datatype_test'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 * If any changes are required, override them in the 'MyAppTest\DatatypeTest' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $data_json
 * @property array $data_json_decoded
 * @property string $data_serialize
 * @property array $data_serialize_decoded
 * @property string $data_string
 *
 * @method \MyAppTest\DatatypeTest save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseDatatypeTest extends \MyAppTest\ORMBaseClass {
    public static $_table = 'datatype_test';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryDatatypeTest
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\DatatypeTest');
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
		return 'DatatypeTest';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = [
		'id' => 'integer',
		'data_json' => 'json',
		'data_serialize' => 'serialize',
		'data_string' => 'string',
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
		return 'datatype_test';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Datatype Test';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Datatype Test');
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
			'data_json' => 'data_json',
			'data_serialize' => 'data_serialize',
			'data_string' => 'data_string',
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\DatatypeTest
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\DatatypeTest::hasAttribute($key) && $this->$key !== $val) {
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
			'data_json' => [
				'_json',
			],
			'data_serialize' => [
				'_serialize',
			],
			'data_string' => [
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
			'data_json' => 'Data Json',
			'data_serialize' => 'Data Serialize',
			'data_string' => 'Data String',
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
			'data_json' => '',
			'data_serialize' => '',
			'data_string' => '',
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
			'data_string',
		];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public function formFields() {
		return [
			'data_json',
			'data_serialize',
			'data_string',
		];
	}

	/**
	 * Get list of defaults for each field
	 * @return array
	 */
	public static function defaultValues() {
		return [
			'id' => '',
			'data_json' => '',
			'data_serialize' => '',
			'data_string' => 'Default String',
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
			'data_json' => 0,
			'data_serialize' => 0,
			'data_string' => 190,
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
			'data_json' => false,
			'data_serialize' => false,
			'data_string' => false,
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
