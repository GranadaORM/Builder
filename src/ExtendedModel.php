<?php

namespace Granada\Builder;

/**
 * This model should be used to extend the auto-generated models
 *
 * @method array find_pairs(string|null $key, string|null $value) Gets data in array form, as pairs of data for each row in the results. The key and value are the database column to use as the array keys and values
 * @method integer count(string $column) Get the count of the column
 * @method string max(string $column) Will return the max value of the chosen column.
 * @method string min(string $column) Will return the min value of the chosen column.
 * @method string avg(string $column) Will return the average value of the chosen column.
 * @method string sum(string $column) Will return the sum of the values of the chosen column.
 * @method boolean delete_many() Delete all matching records
 * @method boolean fakeDelete() Soft delete by setting the is_deleted flag
 * @method string fieldType(string $field_name) What type of field is this attribute
 * @method string refModel(string $column) The relevant model the field is linked to with foreign key
 * @method string getNamespace() The name of the model namespace
 * @method string getModelname() The relative name of the model
 * @method boolean isNestedSet() Is this model a nested set?
 * @static boolean hasAttribute(string $field) Does this model have this attribute
 * @static mixed model() The starting point for all queries
 *
 */
abstract class ExtendedModel extends \Granada\Model {

    public function beforeSave() {
    }

    public function beforeSaveNew() {
    }

    public function afterSave() {
    }

    public function afterSaveNew() {
    }

    public function beforeDelete() {
    }

    public function afterDelete() {
    }

    /**
     * The timezone for datetime fields stored in the database
     * @var string
     */
    private static $_database_timezone = 'Etc/UTC';

    /**
     * Set the timezone used for datetime fields in the database
     * @param string $timezone e.g. 'Etc/UTC'
     * @return void
     */
    public static function setDatabaseTimezone($timezone) {
        self::$_database_timezone = $timezone;
    }

    public function __get($property) {
        // Auto-decode json and serialized variables if using the _decoded suffix
        if (!$this->hasAttribute($property) && substr($property, -8) == '_decoded') {
            $propertybase = substr($property, 0, -8);
            $fieldType = $this->fieldType($propertybase);
            if ($fieldType == 'json') {
                return json_decode($this->$propertybase, true);
            }
            if ($fieldType == 'serialize') {
                return unserialize($this->$propertybase);
            }
        }
        // Auto-get Chronos variable type
        if (substr($property, -8) == '_chronos') {
            $propertybase = substr($property, 0, -8);
            $datetype = $this->datetype($propertybase);
            if ($datetype) {
                $class = get_class($this);
                if ($datetype['type'] == 'date') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase);
                } else if ($datetype['timezone_mode'] == 'user') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, $class::currentTimezone());
                } else if ($datetype['timezone_mode'] == 'site') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, $class::siteTimezone());
                } else {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, self::$_database_timezone);
                }
            }
            return \Cake\Chronos\Chronos::parse($this->$propertybase);
        }
        $datetype = $this->datetype($property);
        if ($datetype) {
            $rawval = parent::__get($property);
            if (is_null($rawval)) {
                return null;
            }
            $class = get_class($this);
            if ($datetype['type'] == 'time') {
                $date = \Cake\Chronos\Chronos::parse($rawval);
            } else {
                $date = \Cake\Chronos\Chronos::parse($rawval, self::$_database_timezone);
            }
            if ($datetype['type'] == 'date') {
                // No timezone adjustment for date
            } elseif ($datetype['type'] == 'dob') {
                // No timezone adjustment for date of birth
            } elseif ($datetype['timezone_mode'] == 'user') {
                // Timezone adjustment to logged in user
                $date = $date->setTimezone($class::currentTimezone());
            } elseif ($datetype['timezone_mode'] == 'site') {
                // Timezone adjustment to site default
                $date = $date->setTimezone($class::siteTimezone());
            }
            if ($datetype['type'] == 'date') {
                return $date->toDateString();
            } elseif ($datetype['type'] == 'dob') {
                return $date->toDateString();
            } elseif ($datetype['type'] == 'datetime') {
                return $date->toDateTimeString();
            } elseif ($datetype['type'] == 'time') {
                return $date->toTimeString();
            }
        }
        $value = parent::__get($property);
        if (is_null($value)) {
            return null;
        }
        // Clean data to correct types for json output etc
        switch ($this->fieldType($property)) {
            case 'bool':
            case 'boolean':
                return $value ? true : false;
            case 'reference':
            case 'integer':
                return intval($value);
            default:
                return $value;
        }
    }

    public function __set($property, $value) {
        $datetype = $this->datetype($property);
        $fieldtype = $this->fieldType($property);
        if ($datetype) {
            $class = get_class($this);
            if (is_a($value, '\Cake\Chronos\Chronos')) {
                $date = $value;
            } else if (!$value) {
                return parent::__set($property, null);
            } else {
                if (($value == 'CURRENT_TIMESTAMP') || ($value == 'current_timestamp()')) {
                    $date = \Cake\Chronos\Chronos::now();
                } else {
                    if ($datetype['type'] == 'time') {
                        $value = '2019-01-01 ' . $value;
                    }
                    if ($datetype['type'] == 'dob') {
                        if (strpos($value, '/') === FALSE) {
                            $date = \Cake\Chronos\Chronos::parse($value, 'Etc/UTC');
                        } else {
                            $date = \Cake\Chronos\Chronos::createFromFormat('d/m/Y', $value, 'Etc/UTC');
                        }
                    } else {
                        if ($datetype['timezone_mode'] == 'user') {
                            $date = \Cake\Chronos\Chronos::parse($value, $class::currentTimezone());
                        } else if ($datetype['timezone_mode'] == 'site') {
                            $date = \Cake\Chronos\Chronos::parse($value, $class::siteTimezone());
                        } else {
                            $date = \Cake\Chronos\Chronos::parse($value, self::$_database_timezone);
                        }
                    }
                }
            }
            if ($datetype['type'] == 'date') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'dob') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'datetime') {
                $date = $date->setTimezone(self::$_database_timezone);
                $value = $date->toDateTimeString();
            } elseif ($datetype['type'] == 'time') {
                $date = $date->setTimezone('Etc/UTC');
                $value = $date->toTimeString();
            }
        }
        // Handle empty value for references
        if (!$value && $fieldtype == 'reference') {
            $value = null;
        }
        // Handle storing data json encoded
        if ($fieldtype == 'json') {
            $value = json_encode($value);
        }
        // Handle storing data serialized
        if ($fieldtype == 'serialize') {
            $value = serialize($value);
        }
        return parent::__set($property, $value);
    }

    /**
     * Create a new item, prefilled with data.
     * This function fills with default values as well, and uses
     * the magic __set() function to handle datatypes that are not
     * database native.
     * @param array $data
     * @return self
     */
    public static function create($data = []) {
        $model = parent::create();
		if (!is_array($data)) {
			$data = array();
		}
		foreach ($model->defaultValues() as $field => $defaultValue) {
			if ($field == 'created_at') {
				continue;
			}
			if ($defaultValue === '') {
				continue;
			}
			if (!array_key_exists($field, $data)) {
                $model->$field = $defaultValue;
			}
		}
		foreach ($data as $key => $val) {
			if (!$model->hasAttribute($key)) {
                continue;
			}
            $model->$key = $val;
		}
        return $model;
    }

    public function datefields() {
        return array();
    }

    private function datetype($property) {
        $datefields = $this->datefields();
        if (array_key_exists($property, $datefields)) {
            return $datefields[$property];
        }
        return false;
    }

    /**
     * Check if a date/time field needs timezone adjustment for use in queries
     *
     * @param string $property
     * @param \Cake\Chronos\Chronos $value
     * @return string
     */
    public static function adjustTimezoneForWhere($property, $value) {
        $class = get_called_class();
        $datetype = (new $class)->datetype($property);
        if ($datetype) {
            if ($datetype['type'] == 'date') {
                $timezone = $value->timezone; // No change for date
            } else if ($datetype['timezone_comparison_mode'] == 'user') {
                // If you get an error below, ensure you create this function in your base class that extends ExtendedModel
                // It returns the time zone for the logged in user
                $timezone = $class::currentTimezone();
            } else if ($datetype['timezone_comparison_mode'] == 'site') {
                // If you get an error below, ensure you create this function in your base class that extends ExtendedModel
                // It returns the time zone for the website
                $timezone = $class::siteTimezone();
            } else if ($datetype['timezone_mode'] == 'none') {
                $timezone = $value->timezone; // No timezone, time is time of day regardless of the time zone checking against
            } else {
                $timezone = self::$_database_timezone;
            }

            $value = $value->setTimezone($timezone)->format($datetype['format']);
        }

        return $value;
    }

    public static function filter_find_pairs_representation($query, $limit = 1000) {
        $modelname = get_called_class();

        $query->select('id');
        foreach ($modelname::representationColumns() as $columnName) {
            $query->select($columnName);
        }
        $query->order_by_expr($modelname::defaultOrder());
        if ($limit) {
            $query->limit($limit);
        }

        $items = $query->find_many();

        $list = array();
        foreach ($items as $item) {
            $list[$item->id] = $item->representation();
        }
        natcasesort($list);
        return $list;
    }

    /**
     * Add query filter for every query for this model
     *
     * @var \Granada\Orm\Wrapper $query
     * @return \Granada\Orm\Wrapper
     */
    public static function filter_defaultFilter($query) {
        $class = get_called_class();
        if ($class::hasAttribute('is_deleted')) {
            $query = $query->where_is_deleted(0);
        }
        if ($class::isNestedSet()) {
            $query = $query->where_lft_gt(1);
        }
        if ($class::hasAttribute('enabled')) {
            $query = $query->where_enabled(1);
        }
        if ($class::hasAttribute('stealth')) {
            $query = $query->where_stealth(0);
        }
        return $query;
    }

    /**
     * Save the model, apply before and after save functions
     *
     * @param bool $ignore If the id already exists on insert, do an update instead
     * @return $this
     * @throws \PDOException
     */
    public function save($ignore = false) {
        $isnew = $this->is_new();
        // Check sort order
        if ($this->hasAttribute('sort_order')) {
            if (!$this->sort_order) {
                $this->sort_order = $this->model()->max('sort_order') + 1;
            }
        }

        $doTimestamps = $this->hasAttribute('updated_at');
        if ($doTimestamps) {
            $this->updated_at = \Cake\Chronos\Chronos::now();
        }
        if ($isnew) {
            if ($doTimestamps) {
                $this->created_at = \Cake\Chronos\Chronos::now();
            }
            $this->beforeSaveNew();
        }
        $this->beforeSaveNestedSet();
        $this->beforeSave();
        parent::save($ignore);
        $this->reload(); // Update all references and changed ids take effect
        $this->afterSaveNestedSet();
        $this->afterSave();
        if ($isnew) {
            $this->afterSaveNew();
        }
        return $this;
    }

    /**
     * Delete the record from the database, executing before and after functions
     * @return bool Success
     * @throws \PDOException
     */
    public function delete($for_real = false) {
        $this->beforeDeleteNestedSet();
        $this->beforeDelete();
        if ($this->fakeDelete() && !$for_real) {
            $this->is_deleted = true;
            $success = $this->save() ? true : false;
        } else {
            $success = parent::delete();
        }
        $this->afterDeleteNestedSet();
        $this->afterDelete();
        return $success;
    }

    /**
     * Load the item again from the database, to refresh the data in case of changes
     * @return void
     */
    public function reload() {
        $new_version = $this->model()->find_one($this->id);
        if ($new_version) {
            $this->orm->hydrate($new_version->as_array());
            $this->relationships = array();
        }
    }

    /**
     * Alias of reload
     *
     * @return void
     */
    public function refresh() {
        $this->reload();
    }

    /**
     * Starting point for rendering this item as a form
     * @return \Granada\Form\Form
     */
    public function getForm($class) {
        return new \Granada\Form\Form($class, $this);
    }

    /**
     * Validate the form field depending on the values of the form
     * @param string $field The field name that just changed and needs validation
     * @param array $form_data POST data of the form to give context about the value
     * @return string|true If not true, an error message to display to the user
     */
    public function validate($field, $form_data) {
        if (!array_key_exists($field, $form_data)) {
            // Likely for a form that is omitting this field
            return true;
        }

        $fieldType = $this->fieldType($field);

        // Check if the field is required
        if ($this->fieldIsRequired($field)) {
            if ($form_data[$field] === '') {
                return 'This cannot be left empty';
            }
            if (is_null($form_data[$field])) {
                return 'This cannot be left empty';
            }
        }

        // Check if the field is too long
        $maxlength = $this->fieldLength($field);
        if ($maxlength > 0) {
            if (!is_string($form_data[$field])) {
                return 'Invalid';
            }
            if (strlen($form_data[$field]) > $maxlength) {
                return 'String too long. Max ' . $maxlength . ' characters';
            }
        }

        // Check if the field is a date
        if ($fieldType == 'date' || $fieldType == 'datetime' || $fieldType == 'dob' || $fieldType == 'time') {
            if ($form_data[$field]) {
                // Test if we can set it as there are different parsing methods
                try {
                    $this->$field = $form_data[$field];
                } catch (\Exception $e) {
                    return 'Date is not quite right';
                }
            }
        }

        // Check if the field is numeric
        if ($fieldType == 'integer' || $fieldType == 'float') {
            if (!is_numeric($form_data[$field])) {
                return 'This must be a number';
            }
        }

        // Check reference exists
        if ($fieldType == 'reference') {
            if (is_numeric($form_data[$field])) {
                $refmodel = $this->refModel($field);
                $count = $refmodel::model()->where('id', $form_data[$field])->count();
                if (!$count) {
                    return 'Could not find this item';
                }
            }
        }

        // Passed all the tests
        return true;
    }

    /**
     * Nested Set functions
     * To enable, create four integer fields in the table:
     * root
     * level
     * lft
     * rgt
     */
    /**
     * Get the top level parent to add new elements to.
     * Override to add extra parameters
     *
     * @return self
     */
    public function findTopLevelParent() {
        $modelname = get_class($this);
        $filter = $modelname::where('level', 1)->where_not_equal('root', -1)->order_by_asc('id');
        // Search through potential references to other models, if defined

        $relations = $modelname::topLevelIdentifierFields();
        foreach ($relations as $relation) {
            if ($this->$relation) {
                $filter = $filter->where($relation, $this->$relation);
            }
        }
        $parent = $filter->find_one();
        return $parent;
    }

    /**
     * List of fields that are required to match to identify the parent for this group
     * e.g. for links to another item. ArticleComments link to Articles
     *
     * @return string[]
     */
    public function topLevelIdentifierFields() {
        return array();
    }

    /**
     * Called just before the model is saved.
     * OVerride to have model-specific code.
     */
    public function beforeSaveNestedSet() {
        if (!$this->isNestedSet()) {
            return;
        }
        if ($this->is_new() && $this->lft == 0) {
            // Add it to a new root
            $this->lft = 1;
            $this->rgt = 2;
            $this->level = 1;
            $this->root = -1;

            $parent = $this->findTopLevelParent();
            if (!$parent) {
                $parent = self::create(array(
                    'name' => 'ROOT',
                    'lft' => 1,
                    'rgt' => 2,
                    'level' => 1,
                    'root' => -2,
                ));
                foreach ($this->copyFieldsForRoot() as $field) {
                    $parent->$field = $this->$field;
                }
                $parent->save();
            }
            // We add this item to the parent root in afterSave
        }
        // Ensure the submodel identifier of this nested set does not change from the root parent
        if ($this->root > 0) {
            $thisrootparent = $this->model()->where('id', $this->root)->find_one();
            // Force identifier field to be the same as root
            foreach ($this->copyFieldsForRoot() as $fieldname) {
                $this->$fieldname = $thisrootparent->$fieldname;
            }
        }
    }

    /**
     * List of fields we need to copy for nested set root elements
     *
     * @return string[]
     */
    public function copyFieldsForRoot() {
        return array();
    }

    /**
     * Called just after the model is saved.
     * OVerride to have model-specific code.
     */
    public function afterSaveNestedSet() {
        if (!$this->isNestedSet()) {
            return;
        }
        if ($this->root == -1) {
            // New roots have to have the root set to the id
            $parent = $this->findTopLevelParent();
            if (!$parent) {
                throw new \Exception('Could not find top level parent');
            }
            $parent->append($this);
        } else if ($this->root == -2) {
            $this->root = $this->id;
            $this->save();
        }
    }

    public function beforeDeleteNestedSet() {
        if (!$this->isNestedSet()) {
            return;
        }
        // Also delete all children
        \Granada\ORM::raw_execute('DELETE FROM ' . $this->tableName() . ' WHERE root=:root AND lft>:lft AND rgt<:rgt', array(
            ':root' => $this->root,
            ':lft' => $this->lft,
            ':rgt' => $this->rgt,
        ));
        \Granada\ORM::clear_cache();
    }

    public function afterDeleteNestedSet() {
        if (!$this->isNestedSet()) {
            return;
        }
        // Repair the hole
        $holesize = ($this->rgt - $this->lft) + 1;
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET lft=lft-' . $holesize . ' WHERE root=:root AND lft>:lft', array(
            ':root' => $this->root,
            ':lft' => $this->lft,
        ));
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET rgt=rgt-' . $holesize . ' WHERE root=:root AND rgt>:rgt', array(
            ':root' => $this->root,
            ':rgt' => $this->lft,
        ));
        \Granada\ORM::clear_cache();
    }

    public function num_descendants() {
        $descendants = ($this->rgt - $this->lft - 1) / 2;

        return $descendants;
    }

    /**
     * Get query parameters to get all descendants
     *
     * Use as $descendants = $item->descendants()->find_many();
     *
     * @param integer $depth
     * @return self
     */
    public function descendants($depth = NULL) {
        if ($depth) {
            return $this->model()->where('root', $this->root)
                ->where_gt('lft', $this->lft)
                ->where_lt('rgt', $this->rgt)
                ->where_lte('level', $this->level + $depth)
                ->order_by_asc('lft');
        }

        return $this->model()->where('root', $this->root)
            ->where_gt('lft', $this->lft)
            ->where_lt('rgt', $this->rgt)
            ->order_by_asc('lft');
    }

    /**
     * Add queries to get the immediate childres on the current item
     *
     * Use as
     *
     * $children = $item->children()->find_many();
     *
     * @return self
     */
    public function children() {
        return $this->descendants(1);
    }

    /**
     * Add queries to get the ancestors for the current node
     *
     * Use as
     *
     * $ancestors = $item->ancestors()->find_many();
     *
     * @param integer $depth the number of levels of ancestors to return
     * @return {{modelname}}
     */
    public function ancestors($depth = null) {
        if ($depth) {
            return $this->model()->where('root', $this->root)
                ->where_lt('lft', $this->lft)
                ->where_gt('rgt', $this->rgt)
                ->where_gte('level', $this->level - $depth)
                ->order_by_desc('lft');
        }

        return $this->model()->where('root', $this->root)
            ->where_lt('lft', $this->lft)
            ->where_gt('rgt', $this->rgt)
            ->order_by_desc('lft');
    }

    /**
     * Add query to get all root nodes
     *
     * Use as
     *
     * $roots = {{modelname}}::roots()->find_many();
     *
     * @return {{modelname}}
     */
    public function roots() {
        return $this->model()->where('root', $this->root)
            ->where('lft', 1);
    }

    /**
     * Add query to get the parent of the current node
     *
     * Use as
     *
     * $parent = $item->getParent()->find_one();
     *
     * @return {{modelname}}
     */
    public function getParent() {
        return $this->ancestors(1);
    }

    /**
     * Add query to get the previous sibling of the current node
     *
     * Use as
     *
     * $previous = $item->previous()->find_one();
     *
     * @return {{modelname}}
     */
    public function previous() {
        return $this->model()->where('root', $this->root)
            ->where('rgt', $this->lft - 1);
    }

    /**
     * Add query to get the next sibling of the current node
     *
     * Use as
     *
     * $next = $item->next()->find_one();
     *
     * @return {{modelname}}
     */
    public function next() {
        return $this->model()->where('root', $this->root)
            ->where('lft', $this->rgt + 1);
    }

    /**
     * Prepends item to existing node as first child.
     *
     * @param {{modelname}} $item the item to insert.
     * @return boolean whether the prepending succeeds.
     */
    public function prepend($item) {
        return $item->moveFirst($this);
    }

    /**
     * Appends item to existing node as last child.
     *
     * @param {{modelname}} $item the item to insert.
     * @return boolean whether the appending succeeds.
     */
    public function append($item) {
        return $item->moveLast($this);
    }

    /**
     * Appends item to existing node as the previous sibling
     *
     * @param {{modelname}} $item the item to insert.
     * @return boolean whether the appending succeeds.
     */
    public function insertBefore($item) {
        $item->moveBefore($this);
    }

    /**
     * Appends item to existing node as the next sibling
     *
     * @param {{modelname}} $item the item to insert.
     * @return boolean whether the appending succeeds.
     */
    public function insertAfter($item) {
        return $item->moveAfter($this);
    }

    /**
     * Moves the current node to the previous sibling of the item
     *
     * @param {{modelname}} $item the item to move before
     * @return boolean whether the move succeeds.
     */
    public function moveBefore($item) {
        if ($item->root == $item->id) {
            // Special case - root element
            $this->lft = 1;
            $this->rgt = 2;
            $this->level = 1;
            $this->root = $this->id;
            $this->save();
            return;
        }
        $this->moveTo($item->lft, $item->level, $item->root);
    }

    /**
     * Moves the current node to the next sibling of the item
     *
     * @param {{modelname}} $item the item to move after
     * @return boolean whether the move succeeds.
     */
    public function moveAfter($item) {
        if ($item->root == $item->id) {
            // Special case - root element
            $this->lft = 1;
            $this->rgt = 2;
            $this->level = 1;
            $this->root = $this->id;
            $this->save();
            return;
        }
        $this->moveTo($item->rgt + 1, $item->level, $item->root);
    }

    /**
     * Moves the current node to the first child of the item
     *
     * @param {{modelname}} $item the item to move before
     * @return boolean whether the appending succeeds.
     */
    public function moveFirst($item) {
        $this->moveTo($item->lft + 1, $item->level + 1, $item->root);
        $item->reload();
    }

    /**
     * Moves the current node to the last child of the item
     *
     * @param {{modelname}} $item the item to move before
     * @return boolean whether the appending succeeds.
     */
    public function moveLast($item) {
        $this->moveTo($item->rgt, $item->level + 1, $item->root);
        $item->reload();
    }

    public function moveTo($newpos, $newlevel, $newroot) {
        $this->reload();

        $width = ($this->rgt - $this->lft) + 1;
        $distance = $newpos - $this->lft;
        $tmppos = $this->lft;
        $levelchange = $newlevel - $this->level;

        // backwards movement must account for new space, but not when moving between roots
        if ($this->root == $newroot) {
            if ($distance < 0) {
                $distance -= $width;
                $tmppos += $width;
            }
        }

        // Make room to fit the tree where we want to put it
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET lft=lft+' . $width . ' WHERE root=:root AND lft>=:lft', array(
            ':root' => $newroot,
            ':lft' => $newpos,
        ));
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET rgt=rgt+' . $width . ' WHERE root=:root AND rgt>=:rgt', array(
            ':root' => $newroot,
            ':rgt' => $newpos,
        ));

        // Move the tree
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET level=level+:level, lft=lft+' . $distance . ', rgt=rgt+' . $distance . ', root=:newroot WHERE root=:root AND lft>=:lft AND rgt<:rgt', array(
            ':root' => $this->root,
            ':newroot' => $newroot,
            ':lft' => $tmppos,
            ':rgt' => $tmppos + $width,
            ':level' => $levelchange,
        ));

        // Repair the hole in the original tree
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET lft=lft-' . $width . ' WHERE root=:root AND lft>:lft', array(
            ':root' => $this->root,
            ':lft' => $this->rgt,
        ));
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET rgt=rgt-' . $width . ' WHERE root=:root AND rgt>:rgt', array(
            ':root' => $this->root,
            ':rgt' => $this->rgt,
        ));

        \Granada\ORM::clear_cache();
        $this->reload();
    }

    /**
     * Remove the current node and its children from the current tree and make another tree with this node as the root
     *
     * @return boolean whether the appending succeeds.
     */
    public function makeRoot() {
        // Change root of all descendants
        // Change lft and rgt by the offset
        $offset = $this->lft - 1;
        $leveloffset = $this->level - 1;
        $oldroot = $this->root;
        $oldlft = $this->lft;

        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET level=level-' . $leveloffset . ', lft=lft-' . $offset . ', rgt=rgt-' . $offset . ', root=:id WHERE root=:root AND lft>=:lft AND rgt<=:rgt', array(
            ':root' => $this->root,
            ':id' => $this->id,
            ':lft' => $this->lft,
            ':rgt' => $this->rgt,
        ));

        $this->reload();

        // Repair the hole in the original tree
        $holesize = ($this->rgt - $this->lft) + 1;
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET lft=lft-' . $holesize . ' WHERE root=:root AND lft>:lft', array(
            ':root' => $oldroot,
            ':lft' => $oldlft,
        ));
        \Granada\ORM::raw_execute('UPDATE ' . $this->tableName() . ' SET rgt=rgt-' . $holesize . ' WHERE root=:root AND rgt>:rgt', array(
            ':root' => $oldroot,
            ':rgt' => $oldlft,
        ));

        \Granada\ORM::clear_cache();
    }

    /**
     * Is the current node a descendant of the named item
     * @return boolean
     */
    public function isDescendantOf($item) {
        if ($this->root != $item->root) {
            // Not of the same root
            return false;
        }
        if ($this->lft <= $item->lft) {
            // Item is me or before me
            return false;
        }
        if ($this->rgt >= $item->rgt) {
            // Item is me or after me
            return false;
        }
        return true;
    }

    /**
     * Is the current node a leaf node
     * @return boolean
     */
    public function isLeaf() {
        return ($this->rgt == ($this->lft + 1));
    }

    /**
     * Is the current node a root node
     * @return boolean
     */
    public function isRoot() {
        return ($this->lft == 1);
    }
}
