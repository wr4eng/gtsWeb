<fieldset>
    <legend>Tracker verwalten</legend>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id' => 'device-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => null,
    'columns' => array(
        'displayName',
        'imeiNumber',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array(
                'view'=>array(
                    'url'=>'Yii::app()->createUrl("site/device", array("deviceIdent"=>$data->ident))',
                ),
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("device/update", array("deviceIdent"=>$data->ident))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("device/delete", array("deviceIdent"=>$data->ident))',
                ),
            )
		),
	),
)); ?>
</fieldset>