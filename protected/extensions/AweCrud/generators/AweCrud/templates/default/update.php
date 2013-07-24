<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */

/** @var AweCrudCode $this  */
?>
<?php
echo "<?php /** @var {$this->modelClass} \$model */\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	\$model->label(2) => array('index'),
	Yii::t('app', \$model->{$nameColumn}) => array('view', 'id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('AweCrud.app', 'Update'),
);\n";
?>

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List').' '.<?php echo $this->modelClass ?>::label(2), 'icon' => 'list', 'url' => array('index')),
	// array('label' => Yii::t('AweCrud.app', 'Create').' <?php echo $this->modelClass ?>', 'icon' => 'plus', 'url' => array('create')),
	//array('label' => Yii::t('AweCrud.app', 'View'), 'icon' => 'eye-open', 'url'=>array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'list-alt', 'url' => array('admin')),
    array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
);
?>

<fieldset>
    <legend><?php echo "<?php echo Yii::t('AweCrud.app', 'Update') ?> {$this->modelClass} <?php echo CHtml::encode(\$model) ?>" ?></legend>
<?php echo "<?php echo \$this->renderPartial('_form',array('model' => \$model)); ?>"; ?>
</fieldset>