<?php

/**
 * AweModelGenerator class file.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @link http://awecrud.obregon.co/
 * @copyright Copyright &copy; 2012 Ricardo Obregón
 * @license http://awecrud.obregon.org/license/ New BSD License
 */

Yii::import('system.gii.generators.model.ModelGenerator');

/**
 * AweModelGenerator is the controller for AweCrud model generator.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @package AweCrud.generators.AweModel
 */
class AweModelGenerator extends ModelGenerator
{
    public $codeModel = 'ext.AweCrud.generators.AweModel.AweModelCode';

}