<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
/** @var AweCrudCode $this */
?>
<?php
echo "<?php /** @var {$this->modelClass} \$model */\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs = array(
	'$label',
);\n";
?>

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create') . ' <?php echo $this->modelClass ?>', 'icon' => 'plus', 'url' => array('create')),
    array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'list-alt', 'url' => array('admin')),
);
?>

<fieldset>
    <legend>
        <?php echo "<?php echo Yii::t('AweCrud.app', 'List') ?>" ?> <?php echo "<?php echo {$this->modelClass}::label(2) ?>" ?>
    </legend>

<?php echo "<?php" ?> $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
</fieldset>