<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
/** @var AweCrudCode $this */
?>
<?php echo "<?php".PHP_EOL ?>
/** @var AweActiveForm $form */
<?php echo "\$form = \$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl(\$this->route),
	'method' => 'get',
)); ?>\n"
; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
    $field = $this->generateInputField($this->modelClass, $column);
    if (strpos($field, 'password') !== false) {
        continue;
    }
    ?>
<?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>

<?php endforeach; ?>
<div class="form-actions">
    <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'type' => 'primary',
			'label' => Yii::t('AweCrud.app', 'Search'),
		)); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>