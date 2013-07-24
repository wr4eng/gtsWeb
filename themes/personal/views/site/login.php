<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Anmelden';
?>

<div class="container">
	<div class="span5">
		<h1>Anmelden</h1>

		<p>Bitte melden Sie sich mit Ihren Benutzerdaten an</p>

		<div class="form">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'login-form',
		    'type'=>'horizontal',
    		'htmlOptions'=>array('class'=>'well'),		    
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

			<?php echo $form->textFieldRow($model,'username'); ?>

			<?php echo $form->passwordFieldRow($model,'password',array(
		        'hint'=>'Wenn Sie Ihre Daten vergessen haben...',
		    )); ?>

			<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		            'buttonType'=>'submit',
		            'type'=>'primary',
		            'label'=>'Anmelden',
		        )); ?>
			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
	</div>
	<div class="span2"></div>
	<div class="span5">
		<h1>Registrieren</h1>

		<p>Hier können Sie Ihren neu erworbenen Personal Tracker registrieren</p>

		<div class="form">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'registration-form',
		    'type'=>'horizontal',
    		'htmlOptions'=>array('class'=>'well'),		    
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

			<?php echo $form->textFieldRow($registerModel,'username'); ?>

			<?php echo $form->passwordFieldRow($registerModel,'password',array()); ?>

			<?php echo $form->passwordFieldRow($registerModel,'repeat_password',array()); ?>

			<?php echo $form->textFieldRow($registerModel,'imei', array('hint'=>'Die IMEI Nummer ist eine 15 stellige numerische Zeichenfolge, und kann auf der Rückseite der Verpackung gefunden werden.')); ?>

			<?php echo $form->textFieldRow($registerModel,'firstName'); ?>
			<?php echo $form->textFieldRow($registerModel,'lastName'); ?>
			<?php echo $form->textFieldRow($registerModel,'phoneNumber'); ?>
			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		            'buttonType'=>'submit',
		            'type'=>'primary',
		            'label'=>'Tracker registrieren',
		        )); ?>
			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->

	</div>
</div>