<?php

/**
 * This is the base model class for the database table 'owner'
 *
 * Do not modify this file, it is overwritten via the db2model script
 * If any changes are required, override them in the 'MyAppTest\Owner' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $name
 * @property \MyAppTest\Car[] $cars
 *
 * @method \MyAppTest\Owner save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseOwner extends \MyAppTest\ORMBaseClass {
    public static $_table = 'owner';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryOwner
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\Owner');
	}

    public function cars() {
        return $this->has_many('MyAppTest\Car', 'owner_id')->defaultFilter()->order_by_expr(\MyAppTest\Car::defaultOrder());
    }

    /**
     * Get the field name of the Car that links back to this Owner
     * @return string
     */
    public function cars_refVar() {
            return 'owner_id';
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
		return 'Owner';
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
		return 'owner';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Owner';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Owner');
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
		return 'name';
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
			'sort_order',
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
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\Owner
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\Owner::hasAttribute($key) && $this->{$key} !== $val) {
				$this->{$key} = $val;
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
		];
		if (!array_key_exists($field, $tags)) {
			return [];
		}
		return $tags[$field];
	}

	/**
	 * Get the human name of the field.
	 * @param string $field the field name
	 * @return string The field human name
	 */
	public function fieldHumanName($field) {
		$items = [
			'id' => 'Id',
			'name' => 'Name',
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
	 * Get the field default value
	 * @param string $field
	 * @return integer
	 */
	public function fieldDefaultValue($field) {
		$items = [
			'id' => '',
			'name' => '',
		];
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
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
