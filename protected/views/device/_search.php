<?php
/** @var AweActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

<?php echo $form->textFieldRow($model, 'accountID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'deviceID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'groupID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'equipmentType', array('class' => 'span5', 'maxlength' => 40)); ?>

<?php echo $form->textFieldRow($model, 'vehicleID', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'licensePlate', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'driverID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'fuelCapacity', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'fuelEconomy', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'speedLimitKPH', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'planDistanceKM', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'expirationTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'uniqueID', array('class' => 'span5', 'maxlength' => 40)); ?>

<?php echo $form->textFieldRow($model, 'deviceCode', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'deviceType', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'dcsPropertiesID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'pushpinID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'displayColor', array('class' => 'span5', 'maxlength' => 16)); ?>

<?php echo $form->textFieldRow($model, 'serialNumber', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'simPhoneNumber', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'smsEmail', array('class' => 'span5', 'maxlength' => 64)); ?>

<?php echo $form->textFieldRow($model, 'imeiNumber', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textAreaRow($model,'dataKey',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'ignitionIndex', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'codeVersion', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'featureSet', array('class' => 'span5', 'maxlength' => 64)); ?>

<?php echo $form->textFieldRow($model, 'ipAddressValid', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'lastTotalConnectTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastDuplexConnectTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textAreaRow($model,'pendingPingCommand',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'lastPingTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'totalPingCount', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'maxPingCount', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'expectAck', array('class' => 'span5')); ?>

<?php echo $form->textAreaRow($model,'lastAckCommand',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'lastAckTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'dcsConfigMask', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'supportsDMTP', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'supportedEncodings', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'unitLimitInterval', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'maxAllowedEvents', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'totalProfileMask', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'totalMaxConn', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'totalMaxConnPerMin', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'duplexProfileMask', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'duplexMaxConn', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'duplexMaxConnPerMin', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'ipAddressCurrent', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'remotePortCurrent', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'listenPortCurrent', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastInputState', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastBatteryLevel', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastFuelLevel', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastFuelTotal', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastOilLevel', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastValidLatitude', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastValidLongitude', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastValidHeading', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastGPSTimestamp', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastCellServingInfo', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->textFieldRow($model, 'lastOdometerKM', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'odometerOffsetKM', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastEngineHours', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'engineHoursOffset', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastIgnitionOnTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastIgnitionOffTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'isActive', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'displayName', array('class' => 'span5', 'maxlength' => 40)); ?>

<?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'lastUpdateTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'creationTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'simID', array('class' => 'span5', 'maxlength' => 24)); ?>

<?php echo $form->textFieldRow($model, 'lastTcpSessionID', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'lastEventTimestamp', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastStopTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastStartTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastMalfunctionLamp', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastFaultCode', array('class' => 'span5', 'maxlength' => 96)); ?>

<?php echo $form->textFieldRow($model, 'allowNotify', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastNotifyTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastNotifyCode', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'notifyEmail', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textAreaRow($model,'notifySelector',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'notifyAction', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'notifyDescription', array('class' => 'span5', 'maxlength' => 64)); ?>

<?php echo $form->textAreaRow($model,'notifySubject',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textAreaRow($model,'notifyText',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->textFieldRow($model, 'notifyUseWrapper', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'notifyPriority', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'parkedLatitude', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'parkedLongitude', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'parkedRadius', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'lastDataPushTime', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->textFieldRow($model, 'lastEventCreateMillis', array('class' => 'span5', 'maxlength' => 20)); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'type' => 'primary',
			'label' => Yii::t('AweCrud.app', 'Search'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
