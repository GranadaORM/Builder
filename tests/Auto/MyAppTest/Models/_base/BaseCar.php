<?php

/**
 * This is the base model class for the database table 'car'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 * If any changes are required, override them in the 'MyAppTest\Car' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $name
 * @property integer $manufactor_id
 * @property integer $owner_id
 * @property boolean $enabled
 * @property boolean $stealth
 * @property boolean $is_deleted
 * @property integer $sort_order
 * @property string $created_at
 * @property \Cake\Chronos\Chronos $created_at_chronos
 * @property string $updated_at
 * @property \Cake\Chronos\Chronos $updated_at_chronos
 * @property \MyAppTest\Manufactor $manufactor
 * @property \MyAppTest\Owner $owner
 * @property \MyAppTest\CarPart[] $carParts
 *
 * @method \MyAppTest\Car save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseCar extends \MyAppTest\ORMBaseClass {
    public static $_table = 'car';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryCar
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\Car');
	}

    public function manufactor() {
        return $this->belongs_to('MyAppTest\Manufactor', 'manufactor_id');
    }

    public function owner() {
        return $this->belongs_to('MyAppTest\Owner', 'owner_id');
    }

    public function carParts() {
        return $this->has_many('MyAppTest\CarPart', 'car_id')->defaultFilter()->order_by_expr(\MyAppTest\CarPart::defaultOrder());
    }

    /**
     * Get the field name of the CarPart that links back to this Car
     * @return string
     */
    public function carParts_refVar() {
            return 'car_id';
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
		return 'Car';
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
		'manufactor_id' => 'reference',
		'owner_id' => 'reference',
		'enabled' => 'bool',
		'stealth' => 'bool',
		'is_deleted' => 'bool',
		'sort_order' => 'integer',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
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
		return 'car';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Car';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Builder\Autobuild::pluralize('Car');
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
		return 'sort_order';
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
			'manufactor_id' => 'manufactor_id',
			'owner_id' => 'owner_id',
			'enabled' => 'enabled',
			'stealth' => 'stealth',
			'is_deleted' => 'is_deleted',
			'sort_order' => 'sort_order',
			'created_at' => 'created_at',
			'updated_at' => 'updated_at',
		];
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\Car
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\Car::hasAttribute($key) && $this->$key !== $val) {
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
			'created_at' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			],
			'updated_at' => [
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
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
		return true;
	}

	/**
	 * Get the model names for the lookup
	 *
	 * @param string name of the variable
	 * @return string
	 */
	public static function refModel($varname) {
		if ($varname == 'manufactor_id') {
			return '\MyAppTest\Manufactor';
		}
		if ($varname == 'owner_id') {
			return '\MyAppTest\Owner';
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
			'name' => [
			],
			'manufactor_id' => [
			],
			'owner_id' => [
			],
			'enabled' => [
			],
			'stealth' => [
			],
			'is_deleted' => [
			],
			'sort_order' => [
			],
			'created_at' => [
			],
			'updated_at' => [
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
			'manufactor_id' => 'Manufactor',
			'owner_id' => 'Owner',
			'enabled' => 'Enabled',
			'stealth' => 'Stealth',
			'is_deleted' => 'Is Deleted',
			'sort_order' => 'Sort Order',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
			'manufactor_id' => '',
			'owner_id' => '',
			'enabled' => '',
			'stealth' => '',
			'is_deleted' => '',
			'sort_order' => '',
			'created_at' => '',
			'updated_at' => '',
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
			'manufactor_id',
			'owner_id',
			'enabled',
			'stealth',
			'is_deleted',
		];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public function formFields() {
		return [
			'name',
			'manufactor_id',
			'owner_id',
			'enabled',
			'stealth',
			'is_deleted',
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
			'manufactor_id' => '',
			'owner_id' => '',
			'enabled' => '1',
			'stealth' => '0',
			'is_deleted' => '1',
			'sort_order' => '',
			'created_at' => '',
			'updated_at' => '',
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
			'manufactor_id' => 11,
			'owner_id' => 11,
			'enabled' => 1,
			'stealth' => 1,
			'is_deleted' => 1,
			'sort_order' => 11,
			'created_at' => 0,
			'updated_at' => 0,
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
			'manufactor_id' => false,
			'owner_id' => false,
			'enabled' => false,
			'stealth' => false,
			'is_deleted' => false,
			'sort_order' => false,
			'created_at' => false,
			'updated_at' => false,
		];
		if (!array_key_exists($field, $items)) {
			return false;
		}
		return $items[$field];
	}
}
