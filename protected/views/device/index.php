<fieldset>
    <legend>Tracker Übersicht</legend>
	<?php $this->widget('bootstrap.widgets.TbListView',array(
		'dataProvider' => $dataProvider,
		'summaryText' => '',
		'itemView' => '_view',
	)); ?>
</fieldset>