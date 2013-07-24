<?php
/**
 * AweCrudCode class file.
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @copyright Copyright &copy; 2012 - Ricardo Obregón
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');
Yii::import('ext.AweCrud.helpers.*');

class AweCrudCode extends CrudCode
{
    /** @var string The type of authentication */
    public $authtype = 'auth_none';

    /** @var string Default action to load in the controller */
    public $defaultAction = 'none';

    /** @var int Specifies if ajax validation is enabled. 0 represents false, 1 represents true. */
    public $validation = 1;

    /** @var string The controller base class name */
    public $baseControllerClass = 'AweController';

    public $layout = '//layouts/column2';

    public $dateTypes = array('datetime', 'date', 'time', 'timestamp');
    public $booleanTypes = array('tinyint(1)', 'boolean', 'bool', 'bit');
    public $emailFields = array('email', 'e-mail', 'email_address', 'e-mail_address', 'emailaddress', 'e-mailaddress');
    public $imageFields = array(
        'image',
        'picture',
        'photo',
        'pic',
        'profile_pic',
        'profile_picture',
        'avatar',
        'profilepic',
        'profilepicture'
    );
    public $urlFields = array('url', 'link', 'uri', 'homepage', 'webpage', 'website', 'profile_url', 'profile_link');
    public $passwordFields = array('password', 'passwd', 'psswrd', 'pass', 'passcode');
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

    public $validRelatedRecordBehaviors = array(
        'ActiveRecordRelation' => 'EActiveRecordRelationBehavior',
    );

    public function getUseRelatedRecordBehavior()
    {
        return array_intersect_key(
            $this->validRelatedRecordBehaviors,
            CActiveRecord::model($this->modelClass)->behaviors()
        );
    }

    /**
     * Adds the new model attributes (class properties) to the rules.
     * #MethodTracker
     * This method overrides {@link CrudCode::rules}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Adds the rules for the new attributes in the code generation form: authtype; validation.</li>
     * </ul>
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            array(
                array('defaultAction, authtype, validation', 'required'),
            )
        );
    }

    /**
     * Sets the labels for the new model attributes (class properties).
     * #MethodTracker
     * This method overrides {@link CrudCode::attributeLabels}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Adds the labels for the new attributes in the code generation form: authtype; validation.</li>
     * </ul>
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'defaultAction' => 'Default Action',
                'authtype' => 'Authentication type',
                'validation' => 'Enable ajax validation',
            )
        );
    }

    /*public function generateActiveRow($modelClass, $column)
    {
        if ($column->type === 'boolean') {
            return "\$form->checkBoxRow(\$model,'{$column->name}')";
        } else {
            if (stripos($column->dbType, 'text') !== false) {
                return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'passwordFieldRow';
                } else {
                    $inputField = 'textFieldRow';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5'))";
                } else {
                    return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5', 'maxlength' => $column->size))";
                }
            }
        }
    }*/

    /**
     * Generates and returns the view source code line
     * to create the appropriate active input field based on
     * the model attribute field type on the database.
     * #MethodTracker
     * This method is based on {@link CrudCode::generateActiveField}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>All styling is removed.</li>
     * </ul>
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the active field.
     */
    public function generateActiveField($modelClass, $column)
    {
        if ($column->isForeignKey) {
            $relation = $this->findRelation($modelClass, $column);
            $relatedModelClass = $relation[3];

            $foreignPk = CActiveRecord::model($relatedModelClass)->getTableSchema()->primaryKey;

            $prompt = '';
            if ($column->allowNull && $column->defaultValue == null) {
                $prompt = ", array('prompt' => Yii::t('AweApp', 'None'))";
            }

            if ($this->getUseRelatedRecordBehavior()) {
                //requires EActiveRecordRelationBehavior
                return "\$form->dropDownListRow(\$model, '{$relation[0]}', CHtml::listData({$relatedModelClass}::model()->findAll(), '{$foreignPk}', {$relatedModelClass}::representingColumn()){$prompt})";
            }

            return "\$form->dropDownListRow(\$model, '{$column->name}', CHtml::listData({$relatedModelClass}::model()->findAll(), '{$foreignPk}', {$relatedModelClass}::representingColumn()){$prompt})";
        }

        if (strtoupper($column->dbType) == 'TINYINT(1)'
            || strtoupper($column->dbType) == 'BIT'
            || strtoupper($column->dbType) == 'BOOL'
            || strtoupper($column->dbType) == 'BOOLEAN'
        ) {
            return "\$form->checkBoxRow(\$model, '{$column->name}')";
        } else {
            if (strtoupper($column->dbType) == 'DATE') {
                return "\$form->datepickerRow(\$model, '{$column->name}', array('prepend'=>'<i class=\"icon-calendar\"></i>'))";
            } else {
                if (stripos($column->dbType, 'text') !== false) { // Start of CrudCode::generateActiveField code.
                    return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
                } else {
                    $passwordI18n = Yii::t('AweCrud.app', 'password');
                    $passwordI18n = (isset($passwordI18n) && $passwordI18n !== '') ? '|' . $passwordI18n : '';
                    $pattern = '/^(password|pass|passwd|passcode' . $passwordI18n . ')$/i';
                    if (preg_match($pattern, $column->name)) {
                        $inputField = 'passwordFieldRow';
                    } else {
                        $inputField = 'textFieldRow';
                    }

                    if ($column->type !== 'string' || $column->size === null) {
                        return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5'))";
                    } else {
                        return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5', 'maxlength' => $column->size))";
                    }
                }
            }
        } // End of CrudCode::generateActiveField code.
    }

    /**
     * Finds the relation of the specified column.
     * Note: There's a similar method in the class AweActiveRecord.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return array The relation. The array will have 3 values:
     * 0: the relation name,
     * 1: the relation type (will always be AweActiveRecord::BELONGS_TO),
     * 2: the foreign key (will always be the specified column),
     * 3: the related active record class name.
     * Or null if no matching relation was found.
     */
    public function findRelation($modelClass, $column)
    {
        if (!$column->isForeignKey) {
            return null;
        }
        $relations = AweActiveRecord::model($modelClass)->relations();
        // Find the relation for this attribute.
        foreach ($relations as $relationName => $relation) {
            // For attributes on this model, relation must be BELONGS_TO.
            if ($relation[0] == AweActiveRecord::BELONGS_TO && $relation[2] == $column->name) {
                return array(
                    $relationName, // the relation name
                    $relation[0], // the relation type
                    $relation[2], // the foreign key
                    $relation[1] // the related active record class name
                );
            }
        }
        // None found.
        return null;
    }

    /**
     * @return array
     */
    public function getRelations()
    {
        return CActiveRecord::model($this->modelClass)->relations();
    }

    /**
     * Used by getIdentificationColumn as callback for array_map
     * @param string $column
     * @return string
     */
    private static function getName($column)
    {
        return $column->name;
    }

    public static function getIdentificationColumnFromTableSchema($tableSchema)
    {
        $possibleIdentifiers = array('name', 'title', 'slug');

        $columns_name = array_map(__CLASS__.'::getName', $tableSchema->columns);
        foreach ($possibleIdentifiers as $possibleIdentifier) {
            if (in_array($possibleIdentifier, $columns_name)) {
                return $possibleIdentifier;
            }
        }

        foreach ($columns_name as $column_name) {
            if (preg_match('/.*name.*/', $column_name, $matches)) {
                return $column_name;
            }
        }

        foreach ($tableSchema->columns as $column) {
            if (!$column->isForeignKey
                && !$column->isPrimaryKey
                && $column->type != 'INT'
                && $column->type != 'INTEGER'
                && $column->type != 'BOOLEAN'
            ) {
                return $column->name;
            }
        }

        if (is_array($pk = $tableSchema->primaryKey)) {
            $pk = $pk[0];
        }
        //every table must have a PK
        return $pk;
    }

    /**
     * Generates and returns the view source code line
     * to create the CGridView column definition.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the column definition.
     */
    public function generateGridViewColumn($modelClass, $column)
    {
        if ($column->isForeignKey) {
            $columnName = $column->name;
            $relations = $this->getRelations();
            $relatedModel = null;
            $relatedModelName = null;
            foreach ($relations as $relationName => $relation) {
                if ($relation[2] == $columnName) {
                    $relatedModel = CActiveRecord::model($relation[1]);
                    $relatedColumnName = $relationName;
                    /*. '->' . AweCrudCode::getIdentificationColumnFromTableSchema($relatedModel->tableSchema)*/
                    $relatedModelName = $relation[1];
                }
            }

            $filter = '';
            if ($relatedModel) {
                $foreign_pk = $relatedModel->getTableSchema()->primaryKey;
                $filter = "CHtml::listData({$relatedModelName}::model()->findAll(), '{$foreign_pk}', {$relatedModelName}::representingColumn())";
            }

            return "array(
                    'name' => '{$column->name}',
                    'value' => 'isset(\$data->{$relatedColumnName}) ? \$data->{$relatedColumnName} : null',
                    'filter' => $filter,
                )";

        }


        /*if ($column->isForeignKey) {// FK.
            // Find the related model for this column.
            $relation = $this->findRelation($modelClass, $column);
            $relationName = $relation[0];
            $relatedModelClass = $relation[3];
            return "array(
				'name'=>'{$column->name}',
				'value'=>'AweHtml::valueEx(\$data->{$relationName})',
				'filter'=>AweHtml::listDataEx({$relatedModelClass}::model()->findAllAttributes(null, true)),
				)";
        }*/

        // Boolean or bit.
        if (strtoupper($column->dbType) == 'TINYINT(1)'
            || strtoupper($column->dbType) == 'BIT'
            || strtoupper($column->dbType) == 'BOOL'
            || strtoupper($column->dbType) == 'BOOLEAN'
        ) {
            return "array(
					'name' => '{$column->name}',
					'value' => '(\$data->{$column->name} === 0) ? Yii::t(\\'AweCrud.app\\', \\'No\\') : Yii::t(\\'AweCrud.app\\', \\'Yes\\')',
					'filter' => array('0' => Yii::t('AweCrud.app', 'No'), '1' => Yii::t('AweCrud.app', 'Yes')),
					)";
        } else // Common column.
        {
            return "'{$column->name}'";
        }

    }

    /**
     * Generates N:M Fields
     * @param array $relation
     * @param string $relatedModelClass
     * @param string $modelClass
     * @return string
     */
    public function getNMField($relation, $relatedModelClass, $modelClass)
    {
        $foreign_pk = CActiveRecord::model($relation[1])->getTableSchema()->primaryKey;
        $foreign_identificationColumn = self::getIdentificationColumnFromTableSchema(
            CActiveRecord::model($relation[1])->getTableSchema()
        );
        $friendlyName = ucfirst($relatedModelClass);
        $str = "<label for=\"$relatedModelClass\"><?php echo Yii::t('app', '$friendlyName'); ?></label>\n";
        $str .= "<?php echo CHtml::checkBoxList('{$modelClass}[{$relatedModelClass}]', array_map('AweHtml::getPrimaryKey', \$model->{$relatedModelClass}),
CHtml::listData({$relation[1]}::model()->findAll(), '{$foreign_pk}', '{$foreign_identificationColumn}'),
array('attributeitem' => '{$foreign_pk}', 'checkAll' => 'Select All')) ?>";
        return $str;
    }

    private function getDetailViewAttribute(CDbColumnSchema $column)
    {

        if (in_array(strtolower($column->name), $this->imageFields)) {
            return "array(
                'name'=>'{$column->name}',
                'type'=>'image'
            )";
        }

        if (in_array(strtolower($column->name), $this->emailFields)) {
            return "array(
                'name'=>'{$column->name}',
                'type'=>'email'
            )";
        }

        if (in_array(strtolower($column->name), $this->urlFields)) {
            return "array(
                'name'=>'{$column->name}',
                'type'=>'url'
            )";
        }

        $type_conversion = array(
            'longtext' => 'ntext',
            'time' => 'time',
            'bit' => 'boolean',
            'boolean' => 'boolean',
            'bool' => 'boolean',
            'tinyint(1)' => 'boolean',
        );

        if (array_key_exists(strtolower($column->dbType), $type_conversion)) {
            return "array(
                'name'=>'{$column->name}',
                'type'=>'" . $type_conversion[strtolower($column->dbType)] . "'
            )";
        }

        return "'{$column->name}'";
    }


    /**
     * Generates and returns the view source code line
     * to create the appropriate attribute configuration for a CDetailView.
     * @param string $modelClass The model class name.
     * @param CDbColumnSchema $column The column.
     * @return string The source code line for the attribute.
     */
    public function generateDetailViewAttribute($modelClass, $column)
    {
        if ($column->isForeignKey) {
            $str = "array(\n";
            $str .= "\t\t\t'name'=>'{$column->name}',\n";
            foreach ($this->relations as $key => $relation) {
                if ((($relation[0] == "CHasOneRelation") || ($relation[0] == "CBelongsToRelation")) && $relation[2] == $column->name) {
                    $relatedModel = CActiveRecord::model($relation[1]);
                    $controller = $this->resolveController($relation);
                    $value = "(\$model->{$key} !== null) ? ";
                    $value .= "CHtml::link(\$model->{$key}, array('{$controller}/view', '{$relatedModel->tableSchema->primaryKey}' => \$model->{$key}->{$relatedModel->tableSchema->primaryKey})).' '";
                    //$value .= ".CHtml::link(Yii::t('app','Update'), array('{$controller}/update','{$relatedModel->tableSchema->primaryKey}'=>\$model->{$key}->{$relatedModel->tableSchema->primaryKey}), array('class'=>'edit'))";
                    $value .= " : null";

                    $str .= "\t\t\t'value'=>{$value},\n";
                    $str .= "\t\t\t'type'=>'html',\n";
                    break;
                }
            }
            $str .= "\t\t)";
        } else {
            $str = $this->getDetailViewAttribute($column);
        }
        return $str;
    }

    public function resolveController($relation)
    {
        $model = new $relation[1];
        $reflection = new ReflectionClass($model);
        $module = preg_match("/\/modules\/([a-zA-Z0-9]+)\//", $reflection->getFileName(), $matches);
        $modulePrefix = (isset($matches[$module])) ? "/" . $matches[$module] . "/" : "/";
        $controller = $modulePrefix . strtolower(substr($relation[1], 0, 1)) . substr($relation[1], 1);
        return $controller;
    }

}
