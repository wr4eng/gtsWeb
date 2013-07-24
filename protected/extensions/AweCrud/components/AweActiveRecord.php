<?php

/**
 * AweActiveRecord class file.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @link http://awecrud.obregon.co/
 * @copyright Copyright &copy; 2012 Ricardo Obregón
 * @license http://awecrud.obregon.org/license/ New BSD License
 */

/**
 * AweActiveRecord is the base class for the generated AR (base) models.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @package AweCrud.components
 */
abstract class AweActiveRecord extends CActiveRecord
{

    /**
     * @var string The separator (delimiter) used to separate the primary keys values in a
     * string representation of the pks of a composite pk record. Usually a character.
     */
    public $pkSeparator = '-';
    /**
     * @var string The separator (delimiter) used to separate the {@link representingColumn}
     * values when there are multiple representing columns while building the
     * string representation of the record in {@link __toString}.
     */
    public $repColumnsSeparator = '-';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * The active record label.
     * The active record label is the user friendly name displayed in the views.
     * Each active record class should override this method and explicitly specify the label.
     * See the documentation when overriding: http://www.yiiframework.com/doc/guide/1.1/en/topics.i18n#plural-forms-format
     * @param integer $n The number value. This is used to support plurals. Defaults to 1 (means singular).
     * Notice that this number doesn't necessarily corresponds to the number (count) of items.
     * @return string The label.
     * @throws CException If the method wasn't overriden.
     * @see getRelationLabel
     */
    public static function label($n = 1)
    {
        throw new CException(Yii::t('AweCrud.messages', 'This method should be overriden by the Active Record class.'));
    }

    /**
     * Returns the text label for the specified active record relation, attribute or class property.
     * The labels are the user friendly names displayed in the views.
     * If defined in the model, the label for its attribute, property or relation is returned.
     * If not defined in the model (in {@link CModel::attributeLabels}),
     * the label is generated using the related active record class label (via {@link AweActiveRecord::label}) (for FK attributes and relations)
     * or using {@link CModel::generateAttributeLabel} (for other attributes and class properties).
     * @param string $relationName The relation, attribute or class property name.
     * This method supports chained relations in the form of "post.author.name".
     * @param integer $n The number value. This is used to support plurals.
     * In the default implementation, when this argument is null, if the relation is BELONGS_TO or HAS_ONE, the singular form is returned.
     * If the relation is HAS_MANY or MANY_MANY, the plural form is returned.
     * If this argument is null and the relation is not one of the types listed above, the singular form is returned.
     * For most languages, 1 means singular and all other values mean plural.
     * Defaults to null.
     * Note: It is not supported when returning labels for attributes or class properties.
     * @param boolean $useRelationLabel Whether to use the relation label for the FK attribute.
     * When true, if the specified attribute name is a FK, the corresponding related AR label will be used.
     * Defaults to true.
     * Note: this will only work when there is no label defined in {@link CModel::attributeLabels} for this attribute.
     * @return string The label.
     * @throws InvalidArgumentException If an attribute name is found and is not the last item in the relationName parameter.
     * @uses label
     */
    public function getRelationLabel($relationName, $n = null, $useRelationLabel = true)
    {
        // Exploding the chained relation names.
        $relNames = explode('.', $relationName);

        // Everything starts with this object.
        $relClassName = get_class($this);

        // The item index.
        $relIndex = 0;

        // Get the count of relation names;
        $countRelNames = count($relNames);

        // Walk through the chained relations.
        foreach ($relNames as $relName) {
            // Increments the item index.
            $relIndex++;

            // Get the related static class.
            $relStaticClass = self::model($relClassName);

            // If is is the last name and the label is explicitly defined, return it.
            if ($relIndex === $countRelNames) {
                $labels = $relStaticClass->attributeLabels();
                if (isset($labels[$relName])) {
                    return $labels[$relName];
                }
            }

            // Get the relations for the current class.
            $relations = $relStaticClass->relations();

            // Check if there is (not) a relation with the current name.
            if (!isset($relations[$relName])) {
                // There is no relation with the current name. It is an attribute or a property.
                // It must be the last name.
                if ($relIndex === $countRelNames) {
                    // Check if it is an attribute.
                    $attributeNames = $relStaticClass->attributeNames();
                    $isAttribute = in_array($relName, $attributeNames);
                    // If it is an attribute and the attribute is a FK and $useRelationLabel is true, return the related AR label.
                    if ($isAttribute && $useRelationLabel && (($relData = self::findRelation(
                        $relStaticClass,
                        $relName
                    )) !== null)
                    ) {
                        // This will always be a BELONGS_TO, then singular.
                        return self::model($relData[3])->label(1);
                    } else {
                        // There's no label for this attribute or property, generate one.
                        return $relStaticClass->generateAttributeLabel($relName);
                    }
                } else {
                    // It is not the last item.
                    throw new InvalidArgumentException(Yii::t(
                        'AweCrud.messages',
                        'The attribute "{attribute}" should be the last name.',
                        array('{attribute}' => $relName)
                    ));
                }
            }

            // Change the current class name: walk to the next relation.
            $relClassName = $relations[$relName][1];
        }

        // Automatically apply the correct number if requested.
        if ($n === null) {
            // Get the type of the last relation from the last but one class.
            $relType = $relations[end($relNames)][0];

            switch ($relType) {
                case self::HAS_MANY:
                case self::MANY_MANY:
                    $n = 2;
                    break;
                case self::BELONGS_TO:
                case self::HAS_ONE:
                default :
                    $n = 1;
            }
        }

        // Get and return the label from the related AR.
        return self::model($relClassName)->label($n);
    }

    /**
     * Returns the text label for the specified attribute.
     * Also supported: relations and chained relations in the form of "post.author.name".
     * This method just calls {@link getRelationLabel}.
     * @param string $attribute The attribute name.
     * @return string The attribute label.
     * @see CActiveRecord::getAttributeLabel
     * @see getRelationLabel
     */
    public function getAttributeLabel($attribute)
    {
        return $this->getRelationLabel($attribute);
    }

    /**
     * The specified column(s) is(are) the responsible for the
     * string representation of the model instance.
     * The column is used in the {@link __toString} default implementation.
     * Every model must specify the attributes used to build their
     * string representation by overriding this method.
     * This method must be overriden in each model class
     * that extends this class.
     * @return string|array The name of the representing column for the table (string) or
     * the names of the representing columns (array).
     * @see __toString
     */
    public static function representingColumn()
    {
        return null;
    }

    /**
     * Returns a string representation of the model instance, based on
     * {@link representingColumn}.
     * When you override this method, all model attributes used to build
     * the string representation of the model must be specified in
     * {@link representingColumn}.
     * @return string The string representation for the model instance.
     * @throws CException If {@link representingColumn} is not defined.
     * @uses representingColumn
     * @uses repColumnsSeparator
     */
    public function __toString()
    {
        $representingColumn = $this->representingColumn();

        if (empty($representingColumn)) {
            throw new CException(Yii::t(
                'AweCrud.messages',
                'The representing column for the active record "{model}" is not set.',
                array(
                    '{model}' => get_class($this),
                )
            ));
        }

        if (is_array($representingColumn)) {
            $repValues = array();
            foreach ($representingColumn as $repColumn_item) {
                $repValues[] = ((($repColumn_item_value = $this->$repColumn_item) === null) ? '' : (string)$repColumn_item_value);
            }
            return implode($this->repColumnsSeparator, $repValues);
        } else {
            return ((($repColumn_value = $this->$representingColumn) === null) ? '' : (string)$repColumn_value);
        }
    }

    /**
     * Fills the provided array of PK values with the composite PK column names.
     * Warning: the order of the values in the array must match the order of
     * the columns in the composite PK.
     * The returned array has the format required by {@link CActiveRecord::findByPk}
     * for composite keys.
     * The method supports single PK also.
     * @param mixed $pk The PK value or array of PK values.
     * @return array The array of PK values, indexed by column name.
     * @see CActiveRecord::findByPk
     * @throws InvalidArgumentException If the count of values doesn't match the
     * count of columns in the composite PK.
     */
    public function fillPkColumnNames($pk)
    {
        // Get the table PK column names.
        $columnNames = $this->getTableSchema()->primaryKey;

        // Check if the count of values and columns match.
        $columnCount = count($columnNames);
        if (count($pk) !== $columnCount) {
            throw new InvalidArgumentException(Yii::t(
                'AweCrud.messages',
                'The count of values in the argument "pk" ({countPk}) does not match the count of columns in the composite PK ({countColumns}).'
            ), array(
                '{countPk}' => count($pk),
                '{countColumns}' => $columnCount,
            ));
        }

        // Build the array indexed by the column names.
        if ($columnCount === 1) {
            if (is_array($pk)) {
                $pk = $pk[0];
            }
            return array($columnNames => $pk);
        } else {
            $result = array();
            for ($columnIndex = 0; $columnIndex < $columnCount; $columnIndex++) {
                $result[$columnNames[$columnIndex]] = $pk[$columnIndex];
            }
            return $result;
        }
    }

    /**
     * Finds the relation of the specified column.
     * @param string|AweActiveRecord $modelClass The model class name or a model instance.
     * @param string|CDbColumnSchema $column The column.
     * @return array The relation. The array will have 3 values:
     * 0: the relation name,
     * 1: the relation type (will always be AweActiveRecord::BELONGS_TO),
     * 2: the foreign key (will always be the specified column),
     * 3: the related active record class name.
     * Or null if no matching relation was found.
     */
    public static function findRelation($modelClass, $column)
    {
        if (is_string($modelClass)) {
            $staticModelClass = self::model($modelClass);
        } else {
            $staticModelClass = self::model(get_class($modelClass));
        }

        if (is_string($column)) {
            $column = $staticModelClass->getTableSchema()->getColumn($column);
        }

        if (!$column->isForeignKey) {
            return null;
        }

        $relations = $staticModelClass->relations();
        // Find the relation for this attribute.
        foreach ($relations as $relationName => $relation) {
            // For attributes on this model, relation must be BELONGS_TO.
            if (($relation[0] === AweActiveRecord::BELONGS_TO) && ($relation[2] === $column->name)) {
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

}