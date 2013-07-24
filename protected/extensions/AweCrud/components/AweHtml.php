<?php

/**
 * AweHtml class file.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @link http://awecrud.obregon.co/
 * @copyright Copyright &copy; 2012 Ricardo Obregón
 * @license http://awecrud.obregon.org/license/ New BSD License
 */

/**
 * AweHtml extends CHtml and provides additional features.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @package AweCrud.components
 */
class AweHtml extends CHtml
{

    /**
     * Renders a checkbox list for a model attribute.
     * #MethodTracker
     * This method is based on {@link CHtml::activeCheckBoxList}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>Added support to HAS_MANY and MANY_MANY relations.</li>
     * </ul>
     * Note: Since Yii 1.1.7, $htmlOptions has an option named 'uncheckValue'.
     * If you set it to different values than the default value (''), you will
     * need to change the generated code accordingly or use
     * AweController::getRelatedData with the appropriate 'uncheckValue'.
     * If you set it to null, you will have to handle it manually.
     * @see CHtml::activeCheckBoxList
     * @param CModel $model The data model.
     * @param string $attribute The attribute.
     * @param array $data Value-label pairs used to generate the check box list.
     * @param array $htmlOptions Addtional HTML options.
     * @return string The generated check box list.
     */
    public static function activeCheckBoxList($model, $attribute, $data, $htmlOptions = array())
    {
        self::resolveNameID($model, $attribute, $htmlOptions);
        $selection = self::selectData(
            self::resolveValue($model, $attribute)
        ); // #Change: Added support to HAS_MANY and MANY_MANY relations.
        if ($model->hasErrors($attribute)) {
            self::addErrorCss($htmlOptions);
        }
        $name = $htmlOptions['name'];
        unset($htmlOptions['name']);

        if (array_key_exists('uncheckValue', $htmlOptions)) {
            $uncheck = $htmlOptions['uncheckValue'];
            unset($htmlOptions['uncheckValue']);
        } else {
            $uncheck = '';
        }

        $hiddenOptions = isset($htmlOptions['id']) ? array('id' => self::ID_PREFIX . $htmlOptions['id']) : array('id' => false);
        $hidden = $uncheck !== null ? self::hiddenField($name, $uncheck, $hiddenOptions) : '';

        return $hidden . self::checkBoxList($name, $selection, $data, $htmlOptions);
    }

    /**
     * Generates the select data suitable for list-based HTML elements.
     * The select data has the attribute or related data as returned
     * by {@link CHtml::resolveValue}.
     * If the select data comes from a MANY_MANY or a HAS_MANY related
     * attribute (is a model or an array of models), it is transformed
     * to a string or an array of strings with the selected primary keys.
     * @param mixed $value The value of the attribute as returned by
     * {@link CHtml::resolveValue}.
     * @return mixed The select data.
     */
    public static function selectData($value)
    {
        // If $value is a model or an array of models, turn it into
        // a string or an array of strings with the pk values.
        if ((is_object($value) && is_subclass_of($value, 'AweActiveRecord')) ||
            (is_array($value) && !empty($value) && is_object($value[0]) && is_subclass_of(
                $value[0],
                'AweActiveRecord'
            ))
        ) {
            return self::getPrimaryKey($value, true);
        } else {
            return $value;
        }
    }

    /**
     * Evaluates the value of the specified attribute for the given model.
     * #MethodTracker
     * This method improves {@link CHtml::value}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>This method supports {@link AweActiveRecord::representingColumn} and {@link AweActiveRecord::toString}.</li>
     * </ul>
     * @see CHtml::value
     * @param mixed $model The model. This can be either an object or an array.
     * @param string $attribute The attribute name (use dot to concatenate multiple attributes).
     * Optional. If not specified, the {@link AweActiveRecord::__toString} method will be used.
     * In this case, the fist parameter ($model) can not be an array, it must be an instance of AweActiveRecord.
     * @param mixed $defaultValue The default value to return when the attribute does not exist.
     * @return mixed The attribute value.
     * @uses AweActiveRecord::representingColumn
     */
    public static function valueEx($model, $attribute = null, $defaultValue = null)
    {
        if ($attribute === null) {
            if (is_object($model) && is_subclass_of($model, 'AweActiveRecord')) {
                return $model->__toString();
            } else {
                return $defaultValue;
            }
        } else {
            return parent::value($model, $attribute, $defaultValue);
        }
    }

    /**
     * Encodes special characters into HTML entities.
     * #MethodTracker
     * This method improves {@link CHtml::encode}, from version 1.1.7 (r3135). Changes:
     * <ul>
     * <li>This method supports encoding strings in arrays and selective encoding of keys and/or values.</li>
     * </ul>
     * @see CHtml::encode
     * @param string|array $data Data to be encoded.
     * @param boolean $encodeKeys Whether to encode array keys.
     * @param boolean $encodeValues Whether to encode array values.
     * @param boolean $recursive Whether to encode data in nested arrays.
     * @return string|array The encoded data.
     * @throws InvalidArgumentException If the argument "data" type is not string or array.
     */
    public static function encodeEx($data, $encodeKeys = false, $encodeValues = false, $recursive = true)
    {
        if (is_array($data)) {
            $encodedArray = array();
            foreach ($data as $key => $value) {
                $encodedKey = ($encodeKeys && is_string($key)) ? parent::encode($key) : $key;
                if (is_array($value)) {
                    if ($recursive) {
                        $encodedValue = self::encodeEx($value, $encodeKeys, $encodeValues, $recursive);
                    } else {
                        $encodedValue = $value;
                    }
                } else {
                    $encodedValue = ($encodeValues && is_string($value)) ? parent::encode($value) : $value;
                }
                $encodedArray[$encodedKey] = $encodedValue;
            }
            return $encodedArray;
        } else {
            if (is_string($data)) {
                return parent::encode($data);
            } else {
                throw new InvalidArgumentException(Yii::t(
                    'AweCrud.messages',
                    'The argument "data" must be of type string or array.'
                ));
            }
        }
    }

    public static function formatUrl($url, $inNewTab = false) {
        $value = $url;
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0)
            $url = 'http://' . $url;
        $htmlOptions = array();
        if ($inNewTab)
            $htmlOptions['target'] = '_blank';
        return CHtml::link(CHtml::encode($value), $url, $htmlOptions);
    }

    /**
     * Extracts and returns only the primary keys values from each model.
     * @param AweActiveRecord|array $model A model or an array of models.
     * @param boolean $forceString Whether pk values on composite pk tables
     * should be compressed into a string. The values on the string will by
     * separated by {@link pkSeparator}.
     * @return string|array The pk value as a string (for single pk tables) or
     * array (for composite pk tables) if one model was specified or
     * an array of strings or arrays if multiple models were specified.
     * @uses pkSeparator
     */
    public static function getPrimaryKey($model, $forceString = false)
    {
        if ($model === null) {
            return null;
        }
        if (!is_array($model)) {
            $pk = $model->getPrimaryKey();
            if ($forceString && is_array($pk)) {
                $pk = implode($model->pkSeparator, $pk);
            }
            return $pk;
        } else {
            $pks = array();
            foreach ($model as $model_item) {
                $pks[] = self::getPrimaryKey($model_item, $forceString);
            }
            return $pks;
        }
    }

}