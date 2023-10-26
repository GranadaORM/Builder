<?php

namespace Granada\Builder;

class TableStructure {
	public $humanName;
	public $representation;
	public $defaultorder;
	public $tablename;
	public $namespace;
	public $modelname;
	public $fields;
	public $hasMany;
	public $belongsTo;
	public $deleteForReal;
	public $nestedSet;
	public $controllerToExtend;
	public $modelToExtend;
	public $chronosModel;
	public $custom_baseModel_template;
	public $extra_model_templates;
	public $trackChangeTime;
	public $structure;

	public function __construct($data) {
		foreach ($data as $field => $content) {
			$this->$field = $content;
		}
	}
}

class FieldStructure {
	public $name;
	public $arvarname;
	public $displayname;
	public $helptext;
	public $type;
	public $ignorexss;
	public $doctype;
	public $remove_prefix;
	public $unique;
	public $belongsToModel;
	public $belongsToModelURL;
	public $options;
	public $length;
	public $required;
	public $hidden_in_forms;
	public $default_value;
	public $timezone_mode;
	public $timezone_comparison_mode;
	public $comment_flags;

	public function __construct($data) {
		foreach ($data as $field => $content) {
			$this->$field = $content;
		}
	}
}

class BelongsToStructure {
	public $varname;
	public $namespace;
	public $modelname;
	public $arvarname;

	public function __construct($data) {
		foreach ($data as $field => $content) {
			$this->$field = $content;
		}
	}
}

class HasManyStructure {
	public $varname;
	public $namespace;
	public $modelname;
	public $arvarname;
	public $defaultorder;

	public function __construct($data) {
		foreach ($data as $field => $content) {
			$this->$field = $content;
		}
	}
}

class Autobuild {

	public static function start() {
		return new self;
	}

	private $_use_namespaces = false;
	private $_singularize = false;
	private $_namespace_prefixes = [];
	private $_default_namespace = 'Auto';
	private $_models_output_dir = '';
	private $_models_output_dir_map = [];
	private $_model_to_extend = '';
	private $_granada_connection_name = '';
	private $_base_model_extra_template = '';
	private $_chronos_model = '';
	private $_custom_base_model_template = '';
	private $_controller_model_to_extend = '';
	private $_controller_template = '';
	private $_extra_model_templates = [];
	private $_extra_generic_templates = [];

	public function setUseNamespaces($val) {
		$this->_use_namespaces = $val;
		return $this;
	}

	public function setDefaultNamespace($val) {
		$this->_default_namespace = $val;
		return $this;
	}

	public function setNamespacePrefixes($val) {
		$this->_namespace_prefixes = $val;
		return $this;
	}

	public function setOutputDirs($val, $map) {
		$this->_models_output_dir = $val;
		$this->_models_output_dir_map = $map;
		return $this;
	}

	public function setModelToExtend($val) {
		$this->_model_to_extend = $val;
		return $this;
	}

	public function setGranadaConnectionName($val) {
		$this->_granada_connection_name = $val;
		return $this;
	}

	public function setBaseModelExtratemplate($val) {
		$this->_base_model_extra_template = $val;
		return $this;
	}

	public function setChronosModel($val) {
		$this->_chronos_model = $val;
		return $this;
	}

	public function setCustomBaseModelTemplate($val) {
		$this->_custom_base_model_template = $val;
		return $this;
	}

	public function setControllerModelToExtend($val) {
		$this->_controller_model_to_extend = $val;
		return $this;
	}

	public function setControllerTemplate($val) {
		$this->_controller_template = $val;
		return $this;
	}

	public function setExtraModelTemplates($val) {
		$this->_extra_model_templates = $val;
		return $this;
	}

	public function setExtraGenericTemplates($val) {
		$this->_extra_generic_templates = $val;
		return $this;
	}

	public function useNamespace($tablename) {
		$tablename_split = preg_split("/_/", $tablename, 2);
		if ($this->_use_namespaces || in_array($tablename_split[0], $this->_namespace_prefixes)) {
			return true;
		}
		return false;
	}

	public function getNamespace($tablename) {
		if ($this->useNamespace($tablename)) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}
		}

		$tablename_split = preg_split("/_/", $tablename, 2);
		if ($this->useNamespace($tablename)) {
			$namespace = ucfirst($tablename_split[0]);
		} else {
			$namespace = $this->_default_namespace;
		}
		return $namespace;
	}

	public function getModelName($tablename) {
		if ($this->useNamespace($tablename)) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}

			$tablename_split = preg_split("/_/", $tablename, 2);
			$modelname = ucfirst($this->to_camel_case($tablename_split[1]));
		} else {
			$modelname = ucfirst($this->to_camel_case($tablename));
		}
		if ($this->_singularize) {
			$modelname = $this->singularize($modelname);
		}
		// Ensure no numeric-starting models
		if (is_numeric(substr($modelname, 0, 1))) {
			$modelname = 'A' . $modelname;
		}
		return $modelname;
	}

	public function getHumanName($tablename) {
		if ($this->useNamespace($tablename)) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}

			$tablename_split = preg_split("/_/", $tablename, 2);
			$humanName = ucwords(str_replace('_', ' ', $tablename_split[1]));
		} else {
			$humanName = ucwords(str_replace('_', ' ', $tablename));
		}
		if ($this->_singularize) {
			$humanName = $this->singularize($humanName);
		}
		return $humanName;
	}

	/**
	 * Translates a string with underscores into camel case (e.g. first_name -> firstName)
	 * @param string $str String in underscore format
	 * @return string
	 */
	public function to_camel_case($str) {
		return \Doctrine\Inflector\InflectorFactory::create()->build()->camelize($str);
	}

	/**
	 * Converts a word to its plural form.
	 * @param string $name the word to be pluralized
	 * @param integer $count Optional - if set to 1 will not pluralize
	 * @return string the pluralized word
	 */
	public function pluralize($name, $count = 0) {
		if ($count == 1) {
			return $name;
		}
		return \Doctrine\Inflector\InflectorFactory::create()->build()->pluralize($name);
	}

	/**
	 * Converts a word to its singular form
	 * @param mixed $name
	 * @return string
	 */
	public function singularize($name) {
		return \Doctrine\Inflector\InflectorFactory::create()->build()->singularize($name);
	}

	public function getTables() {

		$tables = array();
		$result = \Granada\ORM::for_table('post')->raw_query('SHOW TABLES')->find_array();

		foreach ($result as $table) {
			$tables[] = array_pop($table);
		}

		return $tables;
	}

	public function getCurDB() {
		$dbname = \Granada\ORM::for_table('ost')->raw_query('SELECT DATABASE() as dbname')->find_one();

		return $dbname['dbname'];
	}

	public function getBelongsTo($tablename) {
		$tablefields = \Granada\ORM::for_table('ost')->raw_query('
			SELECT
				table_name as table_name,
				column_name as column_name,
				referenced_table_name as referenced_table_name,
				referenced_column_name as referenced_column_name
			FROM
				information_schema.key_column_usage
			WHERE
				referenced_table_name is not null
			AND
				constraint_schema="' . $this->getCurDB() . '"
			AND
				table_name="' . $tablename . '"')->find_array();

		$belongsTo = [];
		foreach ($tablefields as $tablefield) {
			$namespace = $this->getNamespace($tablefield['referenced_table_name']);
			$modelname = $this->getModelName($tablefield['referenced_table_name']);
			$varname = $tablefield['column_name'];
			if (substr($varname, -3) == '_id') {
				$arvarname = substr($varname, 0, -3);
			} else {
				$arvarname = $varname;
			}

			$belongsTo[] = new BelongsToStructure([
				'varname' => $varname,
				'namespace' => $namespace,
				'modelname' => $modelname,
				'arvarname' => $arvarname,
			]);
		}

		return $belongsTo;
	}

	public function getHasMany($tablename) {
		$tablefields = \Granada\ORM::for_table('ost')->raw_query('
			SELECT
				table_name as table_name,
				column_name as column_name,
				referenced_table_name as referenced_table_name,
				referenced_column_name as referenced_column_name
			FROM
				information_schema.key_column_usage
			WHERE
				constraint_schema="' . $this->getCurDB() . '"
			AND
				referenced_table_name="' . $tablename . '"')->find_array();

		$hasMany = array();
		$arvars = array();
		foreach ($tablefields as $tablefield) {
			$namespace = $this->getNamespace($tablefield['table_name']);
			$modelname = $this->getModelName($tablefield['table_name']);
			$arvarname = lcfirst($this->pluralize($modelname));
			$varname = $tablefield['column_name'];
			if (!array_key_exists($arvarname, $arvars)) {
				$arvars[$arvarname] = 0;
			}

			$foreigntablefields = \Granada\ORM::for_table('ost')->raw_query('SHOW FULL COLUMNS FROM `' . $tablefield['table_name'] . '`')->find_array();
			$defaultorder = '';
			foreach ($foreigntablefields as $foreigntablefield) {
				if ($foreigntablefield['Field'] == 'sort_order') {
					$defaultorder = 'sort_order';
				}
			}
			$hasMany[] = new HasManyStructure([
				'varname' => $varname,
				'namespace' => $namespace,
				'modelname' => $modelname,
				'arvarname' => $arvarname . ($arvars[$arvarname] ? $arvars[$arvarname] : ''),
				'defaultorder' => $defaultorder,
			]);
			$arvars[$arvarname]++;
		}

		return $hasMany;
	}

	/**
	 * Get the table structure from the database
	 *
	 * @param string $tablename
	 * @return TableStructure Structure of the table
	 */
	public function getStructure($tablename, $namespace, $modelname, $humanName) {
		$tablefields = \Granada\ORM::for_table('ost')->raw_query('SHOW FULL COLUMNS FROM `' . $tablename . '`')->find_array();

		// Build model files for table

		$representation = '';
		$defaultorder = '';

		$structure = array();
		$fieldnames = array();
		$deleteForReal = true;
		$trackChangeTime = false;
		foreach ($tablefields as $tablefield) {
			$trimmed = trim($tablefield['Type']);
			if (strpos($trimmed, ')') === FALSE) {
				$first = $trimmed;
				$length = 0;
			} else {
				list($first, $length) = explode('(', trim(substr($trimmed, 0, strpos($trimmed, ')')), ')'));
				$length = intval($length);
			}

			$comment = $tablefield['Comment'];
			// Get all the flags from the comment
			$commentwords = explode(' ', trim($comment));
			$helptext = '';
			$commentflags = '';
			$cflags = array();
			foreach ($commentwords as $commentword) {
				if (substr($commentword, 0, 1) == '_') {
					$commentflags .= ' ' . $commentword;
					$cflags[$commentword] = true;
				} else {
					$helptext .= ' ' . $commentword;
				}
			}
			$required = ($tablefield['Null'] == 'NO') ? 'true' : 'false';

			$tablefieldname = $tablefield['Field'];
			$displayname = ucwords(str_replace('_', ' ', $tablefieldname));
			if ($tablefieldname == 'id') {
				$required = 'false';
			}

			$hasMany = $this->getHasMany($tablename);
			$belongsTo = $this->getBelongsTo($tablename);

			$ref_fields = array();
			foreach ($belongsTo as $btitem) {
				$ref_fields[] = $btitem->varname;
			}

			if (!$representation) {
				if ($tablefield['Null'] == 'NO') {
					if ($tablefield['Key'] != 'PRI') {
						if (!array_key_exists('_imageupload', $cflags)) {
							if (!array_key_exists('_fileupload', $cflags)) {
								if (!in_array($tablefieldname, $ref_fields)) {
									$representation = $tablefieldname;
								}
							}
						}
					}
				}
			}
			if ($tablefieldname == 'sort_order') {
				$defaultorder = 'sort_order';
			}
			$belongsToModel = '';
			$belongsToModelURL = '';

			$options = array();
			$unique = false;
			$doctype = 'string';
			$tftype = '';
			if ($tablefieldname == 'url') {
				$unique = true;
			}
			if ($tablefield['Key'] == 'UNI') {
				$unique = true;
			}
			if (array_key_exists('_noxss', $cflags)) {
				$ignorexss = true;
			} else {
				$ignorexss = false;
			}
			if (array_key_exists('_remove_prefix', $cflags)) {
				$remove_prefix = true;
			} else {
				$remove_prefix = false;
			}
			if ($tablefieldname == 'is_deleted') {
				$deleteForReal = false;
			}
			if (array_key_exists('_currency', $cflags)) {
				$tftype = 'currency';
				$doctype = 'string';
			} else if (array_key_exists('_percent', $cflags)) {
				$tftype = 'percent';
				$doctype = 'string';
			} else if ($tablefieldname == 'email') {
				$tftype = 'email';
				$doctype = 'string';
			} else if (array_key_exists('_email', $cflags)) {
				$tftype = 'email';
				$doctype = 'string';
			} else if (array_key_exists('_json', $cflags)) {
				$tftype = 'json';
				$doctype = 'string';
				$ignorexss = true;
			} else if (array_key_exists('_serialize', $cflags)) {
				$tftype = 'serialize';
				$doctype = 'string';
				$ignorexss = true;
			} else if (array_key_exists('_phone', $cflags)) {
				$tftype = 'phone';
				$doctype = 'string';
			} else if (array_key_exists('_telephone', $cflags)) {
				$tftype = 'phone';
				$doctype = 'string';
			} else if (array_key_exists('_dob', $cflags)) {
				$tftype = 'dob';
				$doctype = 'date';
			} else if ($first == 'timestamp') {
				$tftype = 'datetime';
				$doctype = 'string';
			} else if ($first == 'datetime') {
				$tftype = 'datetime';
				$doctype = 'string';
			} else if ($first == 'time') {
				$tftype = 'time';
				$doctype = 'string';
			} else if ($first == 'date') {
				$tftype = 'date';
				$doctype = 'string';
			} else if ($first == 'float') {
				$tftype = 'float';
				$doctype = 'float';
			} else if ($first == 'decimal') {
				$tftype = 'float';
				$doctype = 'float';
			} else if (($first == 'int') || ($first == 'mediumint') || ($first == 'mediumint unsigned') || ($first == 'tinyint')) {
				if ($length == '1') {
					if (isset($tablefield['Default']) || ($tablefield['Null'] == 'NO')) {
						$tftype = 'bool';
						$doctype = 'boolean';
						$required = 'false';
					} else {
						$tftype = 'booltristate';
						$doctype = 'boolean';
					}
				} else {
					$tftype = 'integer';
					$doctype = 'integer';
					foreach ($belongsTo as $belongsToItem) {
						if ($belongsToItem->varname == $tablefieldname) {
							$tftype = 'reference';
							$belongsToModel = '\\' . $belongsToItem->namespace . '\\' . $belongsToItem->modelname;
							$belongsToModelURL = lcfirst($belongsToItem->namespace) . '/' . lcfirst($belongsToItem->modelname);
							if (substr($tablefieldname, -3) == '_id') {
								$displayname = ucwords(str_replace('_', ' ', substr($tablefieldname, 0, -3)));
							} else {
								$displayname = ucwords(str_replace('_', ' ', $tablefieldname));
							}
						}
					}
				}
			} else if ($first == 'enum') {
				$tftype = 'enum'; //todo rest of options
				$doctype = 'string';
				$options_string = trim(substr($tablefield['Type'], 4), '()');
				$options = explode(',', $options_string);
				foreach ($options as $key => $data) {
					$options[$key] = trim($data, "'");
					if (strlen($options[$key]) == 0) {
						unset($options[$key]);
					}
				}
			} else if ($first == 'varchar') {
				if ($length <= 255) {
					$tftype = 'string';
					$doctype = 'string';
				} else if ($length <= 2048) {
					$tftype = 'text';
					$doctype = 'string';
				}
			} else if (($first == 'text') || ($first == 'mediumtext')) {
				if (array_key_exists('_csssource', $cflags)) {
					$tftype = 'css';
				} else if (array_key_exists('_jssource', $cflags)) {
					$tftype = 'js';
					$ignorexss = true;
				} else if (array_key_exists('_jsonld', $cflags)) {
					$tftype = 'jsonld';
				} else if (array_key_exists('_htmlsource', $cflags)) {
					$tftype = 'html';
				} else if (array_key_exists('_image', $cflags)) {
					$tftype = 'image';
					$ignorexss = true;
				} else {
					$tftype = 'richtext';
				}
				$doctype = 'string';
			}
			$hidden_in_forms = false;
			if ($tablefieldname == 'id') {
				$hidden_in_forms = true;
			}
			if ($tablefieldname == 'sort_order') {
				$hidden_in_forms = true;
			}
			if ($tablefieldname == 'created_at') {
				$hidden_in_forms = true;
			}
			if ($tablefieldname == 'updated_at') {
				$hidden_in_forms = true;
				$trackChangeTime = true;
			}
			if (array_key_exists('_hidden', $cflags)) {
				$hidden_in_forms = true;
			}

			if (array_key_exists('_timezone_none', $cflags)) {
				$timezone_mode = 'none';
			} else if (array_key_exists('_timezone_sitewide', $cflags)) {
				$timezone_mode = 'site';
			} else {
				$timezone_mode = 'user';
			}

			if (array_key_exists('_timezone_compare_user', $cflags)) {
				$timezone_comparison_mode = 'user';
			} else if (array_key_exists('_timezone_compare_sitewide', $cflags)) {
				$timezone_comparison_mode = 'site';
			} else {
				$timezone_comparison_mode = 'none';
			}

			if ($tftype == 'time') {
				// Force no timezone for time
				$timezone_mode = 'none';
				$timezone_comparison_mode = 'none';
			}
			if ($remove_prefix) {
				$displayname = substr($displayname, strpos($displayname, ' ') + 1);
			}
			$structure[$tablefieldname] = new FieldStructure([
				'name' => $tablefieldname,
				'arvarname' => substr($tablefieldname, 0, -3),
				'displayname' => $displayname,
				'helptext' => trim($helptext),
				'type' => $tftype,
				'ignorexss' => $ignorexss,
				'doctype' => $doctype,
				'remove_prefix' => $remove_prefix,
				'unique' => $unique,
				'belongsToModel' => $belongsToModel,
				'belongsToModelURL' => $belongsToModelURL,
				'options' => $options,
				'length' => $length,
				'required' => $required,
				'hidden_in_forms' => $hidden_in_forms,
				'default_value' => $tablefield['Default'],
				'timezone_mode' => $timezone_mode,
				'timezone_comparison_mode' => $timezone_comparison_mode,
				'comment_flags' => array_keys($cflags),
			]);
			$fieldnames[] = $tablefieldname;
		}

		if ((in_array('root', $fieldnames)) && (in_array('level', $fieldnames)) && (in_array('lft', $fieldnames)) && (in_array('rgt', $fieldnames))) {
			$nestedSet = true;
			$structure['root']->hidden_in_forms = true;
			$structure['level']->hidden_in_forms = true;
			$structure['lft']->hidden_in_forms = true;
			$structure['rgt']->hidden_in_forms = true;
		} else {
			$nestedSet = false;
		}

		// Do some checks

		$model_vars = array();
		foreach ($structure as $var) {
			$model_vars[$var->name] = 'structure';
		}

		foreach ($hasMany as $var) {
			$vname = $var->arvarname;
			if (array_key_exists($vname, $model_vars)) {
				echo '\\' . $namespace . '\\' . $modelname . '::$' . $vname . ' already exists as a ' . $model_vars[$vname] . PHP_EOL;
			}
			$model_vars[$vname] = 'hasMany';
		}

		foreach ($belongsTo as $var) {
			$vname = $var->arvarname;
			if (array_key_exists($vname, $model_vars)) {
				echo '\\' . $namespace . '\\' . $modelname . '::$' . $vname . ' already exists as a ' . $model_vars[$vname] . PHP_EOL;
			}
			$model_vars[$vname] = 'belongsTo';
		}

		if (!$representation) {
			$representation = 'id';
		}
		return new TableStructure([
			'humanName' => $humanName,
			'humanNames' => $this->pluralize($humanName),
			'representation' => $representation,
			'defaultorder' => $defaultorder ? $defaultorder : $representation,
			'tablename' => $tablename,
			'namespace' => $namespace,
			'modelname' => $modelname,
			'fields' => $tablefields,
			'structure' => $structure,
			'hasMany' => $hasMany,
			'belongsTo' => $belongsTo,
			'deleteForReal' => $deleteForReal,
			'trackChangeTime' => $trackChangeTime,
			'nestedSet' => $nestedSet,
		]);
	}

	/**
	 * Create the model files
	 * @param TableStructure $tabledata Information about the table
	 */
	public function createModels($tabledata) {
		static $classmap = NULL;
		if (is_null($classmap)) {
			$classmap = array();
		}
		if (!$tabledata->modelname) {
			return false;
		}
		$model_base_path = $this->_models_output_dir;

		// Use custom output dir from map
		if (array_key_exists($tabledata->namespace, $this->_models_output_dir_map)) {
			$model_base_path = $this->_models_output_dir_map[$tabledata->namespace];
		}

		$modelpath = $model_base_path . '/' . $tabledata->namespace . '/Models';
		$controllerpath = $model_base_path . '/' . $tabledata->namespace . '/Controllers';

		if (!file_exists($controllerpath)) {
			mkdir($controllerpath, 0755, true);
			// Only create the Models subfolder if we are creating a new Module, to support existing Modules with no Models subfolder
			if (!file_exists($modelpath)) {
				mkdir($modelpath, 0755, true);
			}
		}
		if (!file_exists($modelpath)) {
			$modelpath = dirname($modelpath);
		}

		// initialize Latte environment
		$latte = new \Latte\Engine;
		$latte->setTempDirectory(sys_get_temp_dir());
		$templatedir = dirname(__DIR__) . '/autotemplates/';

		$tabledata->custom_baseModel_template = $this->_base_model_extra_template;

		$filesToRender = array_merge($tabledata->extra_model_templates, [
			[
				'model' => true,
				'output' => '_base/Base{modelname}.php',
				'template' => $templatedir . 'baseModelTemplate.latte',
				'overwrite' => true,
			],
			[
				'model' => true,
				'output' => '_base/Query{modelname}.php',
				'template' => $templatedir . 'queryModelTemplate.latte',
				'overwrite' => true,
			],
			[
				'model' => true,
				'output' => '{modelname}.php',
				'template' => $templatedir . 'modelTemplate.latte',
				'overwrite' => false,
			],
			[
				'controller' => true,
				'output' => '{modelname}Controller.php',
				'template' => $this->_controller_template,
				'overwrite' => false,
			],
		]);

		foreach ($filesToRender as $fileToRender) {
			$outputFile = '';
			if ($fileToRender['model'] ?? false) {
				$outputFile = $modelpath;
			}
			if ($fileToRender['controller'] ?? false) {
				$outputFile = $controllerpath;
			}
			$outputFile .= '/' . str_replace([
				'{namespace}',
				'{modelname}',
			], [
				$tabledata->namespace,
				$tabledata->modelname,
			], $fileToRender['output']);
			if (!$fileToRender['overwrite']) {
				if (file_exists($outputFile)) {
					continue;
				}
			}

			$basepath = dirname($outputFile);
			if (!file_exists($basepath)) {
				mkdir($basepath, 0755, true);
			}

			$tmpoutputfile = tempnam(sys_get_temp_dir(), 'b');
			file_put_contents($tmpoutputfile, $latte->renderToString($fileToRender['template'], $tabledata));
			if (!file_exists($outputFile) || md5_file($tmpoutputfile) != md5_file($outputFile)) {
				rename($tmpoutputfile, $outputFile);
			} else {
				unlink($tmpoutputfile);
			}
		}
	}

	/**
	 * Entrypoint
	 */
	public function doBuild() {

		$tables = $this->getTables();

		$structures = [];
		foreach ($tables as $table) {
			$namespace = $this->getNamespace($table);
			$modelname = $this->getModelName($table);
			$humanName = $this->getHumanName($table);

			$tabledata = $this->getStructure($table, $namespace, $modelname, $humanName);
			$tabledata->controllerToExtend = $this->_controller_model_to_extend;
			$tabledata->modelToExtend = $this->_model_to_extend;
			$tabledata->chronosModel = $this->_chronos_model;
			$tabledata->granadaConnectionName = $this->_granada_connection_name;
			$tabledata->custom_baseModel_template = $this->_custom_base_model_template;
			$tabledata->extra_model_templates = $this->_extra_model_templates;
			if (array_key_exists('sort_order', $tabledata->structure)) {
				// Check and renumber sort_order columns if found to have zeros
				$curmax = \Granada\ORM::for_table($table)->max('sort_order');
				$zero_sort_orders = \Granada\ORM::for_table($table)->where('sort_order', 0)->find_many();
				foreach ($zero_sort_orders as $zero_sort_order) {
					$curmax++;
					$zero_sort_order->sort_order = $curmax;
					$zero_sort_order->save();
				}
			}
			$structures[] = (object)[
				'namespace' => $namespace,
				'modelname' => $modelname,
				'humanName' => $humanName,
				'tabledata' => $tabledata,
			];
		}
		foreach ($structures as $structure) {
			$this->createModels($structure->tabledata);
		}
		$latte = new \Latte\Engine;
		$latte->setTempDirectory(sys_get_temp_dir());
		foreach ($this->_extra_generic_templates as $generic_template) {
			$tmpoutputfile = tempnam(sys_get_temp_dir(), 'b');
			file_put_contents($tmpoutputfile, $latte->renderToString($generic_template['template'], ['structures' => $structures]));
			if (!file_exists($generic_template['output']) || md5_file($tmpoutputfile) != md5_file($generic_template['output'])) {
				rename($tmpoutputfile, $generic_template['output']);
			} else {
				unlink($tmpoutputfile);
			}
		}
	}
}
