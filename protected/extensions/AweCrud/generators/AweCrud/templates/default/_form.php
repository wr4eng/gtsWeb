<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
/** @var AweCrudCode $this */
?>
<div class="form">
    <?php echo "<?php /** @var {$this->modelClass} \$model */\n" ?>
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'id' => '<?php echo $this->class2id($this->modelClass) ?>-form',
    'enableAjaxValidation' => <?php echo $this->validation == 1 || $this->validation == 3 ? 'true' : 'false' ?>,
    'enableClientValidation'=> <?php echo $this->validation == 2 || $this->validation == 3 ? 'true' : 'false' ?>,
    )); ?>

    <p class="note">
        <?php echo "<?php echo Yii::t('AweCrud.app', 'Fields with') ?>" ?> <span class="required">*</span>
        <?php echo "<?php echo Yii::t('AweCrud.app', 'are required') ?>." ?>
    </p>

    <?php echo "<?php echo \$form->errorSummary(\$model) ?>\n" ?>

    <?php
    foreach ($this->tableSchema->columns as $column): ?>
        <?php
        if ($column->autoIncrement || in_array($column->name, array_merge($this->create_time, $this->update_time))) {
            continue;
        }
        //skip many to many relations, they are rendered below, this allows handling of nm relationships
        foreach ($this->getRelations() as $relation) {
            if ($relation[2] == $column->name && $relation[0] == 'CManyManyRelation') {
                continue 2;
            }
        }
        ?>
        <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . " ?>\n"; ?>
        <?php endforeach; ?>
    <?php
    foreach ($this->getRelations() as $relatedModelClass => $relation) {
        if ($relation[0] == 'CManyManyRelation') {
            echo "<div class=\"row nm_row\">\n";
            echo $this->getNMField($relation, $relatedModelClass, $this->modelClass);
            echo "</div>\n\n";
        }
    }

    ?>
    <div class="form-actions">
        <?php echo "" ?>
        <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
		)); ?>\n" ?>
        <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> Yii::t('AweCrud.app', 'Cancel'),
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>\n" ?>
    </div>

    <?php echo "<?php \$this->endWidget(); ?>\n" ?>
</div>