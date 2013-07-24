<?php

/**
 * AweModelCode class file.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @link http://obregon.co/
 * @copyright Copyright &copy; 2012 Ricardo Obregón
 * @license New BSD License
 */
Yii::import('system.gii.generators.model.ModelCode');
Yii::import('ext.AweCrud.helpers.*');

/**
 * AweModelCode is the model for AweCrud model generator.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @package AweCrud.generators.AweModel
 */
class AweModelCode extends ModelCode
{

    /**
     * @var string The (base) model base class name.
     */
    public $baseClass = 'AweActiveRecord';
    /**
     * @var string The path of the base model.
     */
    public $baseModelPath;
    /**
     * @var string The base model class name.
     */
    public $baseModelClass;

    public $booleanTypes = array('tinyint(1)', 'boolean', 'bool');
    public $emailFields = array('email', 'e-mail', 'email_address', 'e-mail_address', 'emailaddress', 'e-mailaddress');
    public $urlFields = array('url', 'link', 'uri', 'homepage', 'webpage', 'website', 'profile_url', 'profile_link');
    public $create_time = array(
        'create_time',
        'createtime',
        'created_at',
        'created_on',
        'createdat',
        'created_time',
        'createdtime'
    );
    public $update_time = array(
        'changed',
        'changed_at',
        'updatetime',
        'modified_at',
        'updated_at',
        'updated_on',
        'modified_on',
        'update_time',
        'timestamp',
        'updatedat'
    );
    public $time_fields;
    public $validRelatedRecordBehaviors = array(
        'ActiveRecordRelation' => 'EActiveRecordRelationBehavior',
    );
    public $relatedRecordBehavior = '';

    public function init()
    {
        $this->time_fields = array_merge($this->create_time, $this->update_time);
        //parent::init();
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            array(
                array('relatedRecordBehavior', 'safe'),
            )
        );
    }

    public function hasActiveBehavior(){

    }

    /**
     * Prepares the code files to be generated.
     * #MethodTracker
     * This method is based on {@link ModelCode::prepare}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Generates the base model.</li>
     * <li>Provides the representing column for the table.</li>
     * <li>Provides the pivot class names for MANY_MANY relations.</li>
     * </ul>
     */
    public function prepare()
    {
        if (($pos = strrpos($this->tableName, '.')) !== false) {
            $schema = substr($this->tableName, 0, $pos);
            $tableName = substr($this->tableName, $pos + 1);
        } else {
            $schema = '';
            $tableName = $this->tableName;
        }
        if ($tableName[strlen($tableName) - 1] === '*') {
            $tables = Yii::app()->db->schema->getTables($schema);
            if ($this->tablePrefix != '') {
                foreach ($tables as $i => $table) {
                    if (strpos($table->name, $this->tablePrefix) !== 0) {
                        unset($tables[$i]);
                    }
                }
            }
        } else {
            $tables = array($this->getTableSchema($this->tableName));
        }

        $this->files = array();
        $templatePath = $this->templatePath;

        $this->relations = $this->generateRelations();

        foreach ($tables as $table) {
            $tableName = $this->removePrefix($table->name);
            $className = $this->generateClassName($table->name);

            $params = array(
                'tableName' => $schema === '' ? $tableName : $schema . '.' . $tableName,
                'modelClass' => $className,
                'columns' => $table->columns,
                'labels' => $this->generateLabelsEx($table, $className),
                'rules' => $this->generateRules($table),
                'relations' => isset($this->relations[$className]) ? $this->relations[$className] : array(),
                'representingColumn' => $this->getRepresentingColumn($table), // The representing column for the table.
                'connectionId' => $this->connectionId,
            );
            // Setup base model information.
            $this->baseModelPath = $this->modelPath . '._base';
            $this->baseModelClass = 'Base' . $className;
            // Generate the model.
            $this->files[] = new CCodeFile(
                Yii::getPathOfAlias($this->modelPath . '.' . $className) . '.php',
                $this->render($templatePath . DIRECTORY_SEPARATOR . 'model.php', $params)
            );
            // Generate the base model.
            $this->files[] = new CCodeFile(
                Yii::getPathOfAlias($this->baseModelPath . '.' . $this->baseModelClass) . '.php',
                $this->render(
                    $templatePath . DIRECTORY_SEPARATOR . '_base' . DIRECTORY_SEPARATOR . 'basemodel.php',
                    $params
                )
            );
        }
    }

    /**
     * Lists the template files.
     * #MethodTracker
     * This method is based on {@link ModelCode::requiredTemplates}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Includes the base model.</li>
     * </ul>
     * @return array A list of required template filenames.
     */
    public function requiredTemplates()
    {
        return array(
            'model.php',
            '_base' . DIRECTORY_SEPARATOR . 'basemodel.php',
        );
    }

    /**
     * Generates the labels for the table fields and relations.
     * By default, the labels for the FK fields and for the relations is null. This
     * will cause them to be represented by the related model label.
     * #MethodTracker
     * This method is based on {@link ModelCode::generateLabels}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Default label for FKs is null.</li>
     * <li>Creates entries for the relations. The default label is null.</li>
     * </ul>
     * @param CDbTableSchema $table The table definition.
     * @param string $className The model class name.
     * @return array The labels.
     * @see GxActiveRecord::label
     * @see GxActiveRecord::getRelationLabel
     */
    public function generateLabelsEx($table, $className)
    {
        $labels = array();
        // For the fields.
        foreach ($table->columns as $column) {
            /*if ($column->isForeignKey) {
                $label = null;
            } else {*/
            $label = ucwords(
                trim(
                    strtolower(
                        str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $column->name))
                    )
                )
            );
            $label = preg_replace('/\s+/', ' ', $label);
            if (strcasecmp(substr($label, -3), ' id') === 0) {
                $label = substr($label, 0, -3);
            }
            if ($label === 'Id') {
                $label = 'ID';
            }
            $label = "Yii::t('app', '{$label}')";
            //}
            $labels[$column->name] = $label;
        }
        // For the relations.
        $relations = $this->getRelationsData($className);
        if (isset($relations)) {
            foreach (array_keys($relations) as $relationName) {
                $labels[$relationName] = null;
            }
        }

        return $labels;
    }

    /**
     * Original {@link ModelCode::generateRules} function but it changes the way it handles the required fields
     * when the field is in the {@link ModelCode::time_fields} array.
     * @param $table
     * @return array
     */
    private function parentGenerateRules($table)
    {
        $rules = array();
        $required = array();
        $integers = array();
        $numerical = array();
        $length = array();
        $safe = array();
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            $r = !$column->allowNull && $column->defaultValue === null;
            if ($r and !in_array($column->name, $this->time_fields)) {
                $required[] = $column->name;
            }
            if ($column->type === 'integer') {
                $integers[] = $column->name;
            } elseif ($column->type === 'double') {
                $numerical[] = $column->name;
            } elseif ($column->type === 'string' && $column->size > 0) {
                $length[$column->size][] = $column->name;
            } elseif (!$column->isPrimaryKey && !$r) {
                $safe[] = $column->name;
            }
        }
        if ($required !== array()) {
            $rules[] = "array('" . implode(', ', $required) . "', 'required')";
        }
        if ($integers !== array()) {
            $rules[] = "array('" . implode(', ', $integers) . "', 'numerical', 'integerOnly'=>true)";
        }
        if ($numerical !== array()) {
            $rules[] = "array('" . implode(', ', $numerical) . "', 'numerical')";
        }
        if ($length !== array()) {
            foreach ($length as $len => $cols) {
                $rules[] = "array('" . implode(', ', $cols) . "', 'length', 'max'=>$len)";
            }
        }
        if ($safe !== array()) {
            $rules[] = "array('" . implode(', ', $safe) . "', 'safe')";
        }

        return $rules;
    }

    /**
     * Generates the rules for table fields.
     * #MethodTracker
     * This method overrides {@link ModelCode::generateRules}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Adds the rule to fill empty attributes with null.</li>
     * </ul>
     * @param CDbTableSchema $table The table definition.
     * @return array The rules for the table.
     */
    public function generateRules($table)
    {
        $rules = array();
        $null = array();
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!(!$column->allowNull && $column->defaultValue === null)) {
                $null[] = $column->name;
            }
        }
        if ($null !== array()) {
            $rules[] = "array('" . implode(
                ', ',
                $null
            ) . "', 'default', 'setOnEmpty' => true, 'value' => null)";
        }

        return array_merge($this->parentGenerateRules($table), $rules);
    }

    /**
     * Selects the representing column of the table.
     * The "representingColumn" method is the responsible for the
     * string representation of the model instance.
     * @param CDbTableSchema $table The table definition.
     * @return string|array The name of the column as a string or the names of the columns as an array.
     * @see AweActiveRecord::representingColumn
     * @see AweActiveRecord::__toString
     */
    protected function getRepresentingColumn($table)
    {
        $columns = $table->columns;
        // If this is not a MANY_MANY pivot table
        if (!$this->isRelationTable($table)) {
            // First we look for a string, not null, not pk, not fk column, not original number on db.
            foreach ($columns as $name => $column) {
                if ($column->type === 'string' && !$column->allowNull && !$column->isPrimaryKey && !$column->isForeignKey && stripos(
                    $column->dbType,
                    'int'
                ) === false
                ) {
                    return $name;
                }
            }
            // Then a string, not null, not fk column, not original number on db.
            foreach ($columns as $name => $column) {
                if ($column->type === 'string' && !$column->allowNull && !$column->isForeignKey && stripos(
                    $column->dbType,
                    'int'
                ) === false
                ) {
                    return $name;
                }
            }
            // Then the first string column, not original number on db.
            foreach ($columns as $name => $column) {
                if ($column->type === 'string' && stripos($column->dbType, 'int') === false) {
                    return $name;
                }
            }
        } // If the appropriate column was not found or if this is a MANY_MANY pivot table.
        // Then the pk column(s).
        $pk = $table->primaryKey;
        if ($pk !== null) {
            if (is_array($pk)) {
                return $pk;
            } else {
                return (string)$pk;
            }
        }
        // Then the first column.
        return reset($columns)->name;
    }

    /**
     * Finds the related class of the specified column.
     * @param string $className The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The related class name. Or null if no matching relation was found.
     */
    public function findRelatedClass($className, $column)
    {
        if (!$column->isForeignKey) {
            return null;
        }

        $relations = $this->getRelationsData($className);

        foreach ($relations as $relation) {
            // Must be BELONGS_TO.
            if (($relation[0] === AweActiveRecord::BELONGS_TO) && ($relation[3] === $column->name)) {
                return $relation[1];
            }
        }
        // None found.
        return null;
    }

    /**
     * Finds the relation data for all the relations of the specified model class.
     * @param string $className The model class name.
     * @return array An array of arrays with the relation data.
     * The array will have one array for each relation.
     * The key is the relation name. There are 5 values:
     * 0: the relation type,
     * 1: the related active record class name,
     * 2: the joining (pivot) table (note: it may come with curly braces) (if the relation is a MANY_MANY, else null),
     * 3: the local FK (if the relation is a BELONGS_TO or a MANY_MANY, else null),
     * 4: the remote FK (if the relation is a HAS_ONE, a HAS_MANY or a MANY_MANY, else null).
     * Or null if the model has no relations.
     */
    public function getRelationsData($className)
    {
        if (!empty($this->relations)) {
            $relations = $this->relations;
        } else {
            $relations = $this->generateRelations();
        }

        if (!isset($relations[$className])) {
            return null;
        }

        $result = array();
        foreach ($relations[$className] as $relationName => $relationData) {
            $result[$relationName] = $this->getRelationData($className, $relationName, $relations);
        }
        return $result;
    }

    /**
     * Finds the relation data of the specified relation name.
     * @param string $className The model class name.
     * @param string $relationName The relation name.
     * @param array $relations An array of relations for the models
     * in the format returned by {@link ModelCode::generateRelations}. Optional.
     * @return array The relation data. The array will have 3 values:
     * 0: the relation type,
     * 1: the related active record class name,
     * 2: the joining (pivot) table (note: it may come with curly braces) (if the relation is a MANY_MANY, else null),
     * 3: the local FK (if the relation is a BELONGS_TO or a MANY_MANY, else null),
     * 4: the remote FK (if the relation is a HAS_ONE, a HAS_MANY or a MANY_MANY, else null).
     * Or null if no matching relation was found.
     */
    public function getRelationData($className, $relationName, $relations = array())
    {
        if (empty($relations)) {
            if (!empty($this->relations)) {
                $relations = $this->relations;
            } else {
                $relations = $this->generateRelations();
            }
        }

        if (isset($relations[$className]) && isset($relations[$className][$relationName])) {
            $relation = $relations[$className][$relationName];
        } else {
            return null;
        }

        $relationData = array();
        if (preg_match("/^array\(([\w:]+?),\s?'(\w+)',\s?'([\w\s\(\),]+?)'\)$/", $relation, $matches_base)) {
            $relationData[1] = $matches_base[2]; // the related active record class name

            switch ($matches_base[1]) {
                case 'self::BELONGS_TO':
                    $relationData[0] = AweActiveRecord::BELONGS_TO; // the relation type
                    $relationData[2] = null;
                    $relationData[3] = $matches_base[3]; // the local FK
                    $relationData[4] = null;
                    break;
                case 'self::HAS_ONE':
                    $relationData[0] = AweActiveRecord::HAS_ONE; // the relation type
                    $relationData[2] = null;
                    $relationData[3] = null;
                    $relationData[4] = $matches_base[3]; // the remote FK
                    break;
                case 'self::HAS_MANY':
                    $relationData[0] = AweActiveRecord::HAS_MANY; // the relation type
                    $relationData[2] = null;
                    $relationData[3] = null;
                    $relationData[4] = $matches_base[3]; // the remote FK
                    break;
                case 'self::MANY_MANY':
                    if (preg_match("/^((?:{{)?\w+(?:}})?)\((\w+),\s?(\w+)\)$/", $matches_base[3], $matches_manymany)) {
                        $relationData[0] = AweActiveRecord::MANY_MANY; // the relation type
                        $relationData[2] = $matches_manymany[1]; // the joining (pivot) table
                        $relationData[3] = $matches_manymany[2]; // the local FK
                        $relationData[4] = $matches_manymany[3]; // the remote FK
                    }
                    break;
            }

            return $relationData;
        } else {
            return null;
        }
    }

    /**
     * Returns the message to be displayed when the newly generated code is saved successfully.
     * #MethodTracker
     * This method overrides {@link CCodeModel::successMessage}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Custom AweCrud success message.</li>
     * </ul>
     * @return string The message to be displayed when the newly generated code is saved successfully.
     */
    public function successMessage()
    {
        return <<<EOM
<p><strong>Sweet!</strong></p>
<ul style="list-style-type: none; padding-left: 0;">
</ul>
<p style="margin: 2px 0; position: relative; text-align: right; top: -15px; color: #668866;">icons by <a href="http://www.famfamfam.com/lab/icons/silk/" style="color: #668866;">famfamfam.com</a></p>
EOM;
    }

    public function getCreatetimeAttribute($columns)
    {
        foreach ($this->create_time as $try) {
            foreach ($columns as $column) {
                if ($try == $column->name) {
                    return sprintf("'%s'", $column->name);
                }
            }
        }
        return 'null';
    }

    public function getUpdatetimeAttribute($columns)
    {
        foreach ($this->update_time as $try) {
            foreach ($columns as $column) {
                if ($try == $column->name) {
                    return sprintf("'%s'", $column->name);
                }
            }
        }
        return 'null';
    }

}