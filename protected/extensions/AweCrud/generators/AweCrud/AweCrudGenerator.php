<?php
/**
 * AweCrudGenerator class file.
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @copyright Copyright &copy; 2012 - Ricardo Obregón
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudGenerator');

class AweCrudGenerator extends CrudGenerator
{
    public $codeModel = 'ext.AweCrud.generators.AweCrud.AweCrudCode';

    /**
     * Returns the model names in an array.
     * Only non abstract and subclasses of AweActiveRecord models are returned.
     * The array is used to build the autocomplete field.
     * @return array The names of the models
     */
    protected function getModels()
    {
        $models = array();
        $files = scandir(Yii::getPathOfAlias('application.models'));
        foreach ($files as $file) {
            if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
                $fileClassName = substr($file, 0, strpos($file, '.'));
                if (class_exists($fileClassName) && is_subclass_of($fileClassName, 'AweActiveRecord')) {
                    $fileClass = new ReflectionClass($fileClassName);
                    if (!$fileClass->isAbstract()) {
                        $models[] = $fileClassName;
                    }
                }
            }
        }
        return $models;
    }

    /**
     * @return array
     */
    protected function getLayouts()
    {
        $layouts = array();
        $files = scandir(Yii::getPathOfAlias('application.views.layouts'));
        foreach ($files as $file) {
            if ($file[0] !== '.') {
                if (CFileHelper::getExtension($file) === 'php') {
                    $layoutName = substr($file, 0, strpos($file, '.'));
                } else {
                    $layoutName = $file;
                }
                $layoutName = '//layouts/' . $layoutName;
                $layouts[$layoutName] = $layoutName;
            }
        }
        return $layouts;
    }
}