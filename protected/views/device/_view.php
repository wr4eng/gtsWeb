<?php /** @var Device $data */ 
    $device = $data;
?>
<div class="view" style="float:left;width:300px;height:500px;overflow:hidden;padding-right:20px;">
    <h2><?php 
        $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $device,
            'attribute' => 'displayName',
            'url'       => $this->createUrl('device/updateDevice'), 
            'placement' => 'right',
        ));
    ?></h2>
    <?php
        if ($device->getLastGPSEvent()) {
    ?>
        <p>Letzte gemeldete Position</p>
        <ul>
            <li><b>Zeitpunkt: </b><?php echo date(Yii::app()->params["datetimeFormat"], $device->getLastGPSEvent()->timestamp); ?></li>
            <li><b>Latitude: </b><?php echo $device->getLastGPSEvent()->latitude; ?></li>
            <li><b>Longitude: </b><?php echo $device->getLastGPSEvent()->longitude; ?></li>
            <li><b>Adresse: </b><?php echo $device->getLastGPSEvent()->address; ?></li>
        </ul>
        <?php
            Yii::import('ext.EGMap.*');

            $gMap = new EGMap();
            $gMap->width = "300";
            $gMap->height = "300";
            $gMap->setCenter(48,14);

            $gMap->zoom = 6;
            $mapTypeControlOptions = array(
              'position'=> EGMapControlPosition::LEFT_BOTTOM,
              'style' => EGMap::MAPTYPECONTROL_STYLE_HORIZONTAL_BAR
            );
             
            $gMap->mapTypeControlOptions= $mapTypeControlOptions;
            $gMap->mapTypeId = EGMap::TYPE_HYBRID;   

            if (isset($device) && $device->getLastGPSEvent()) {
                $event = $device->getLastGPSEvent();
                // Create GMapInfoWindows
                $infoWindow = new EGMapInfoWindow('<div></div>');
                $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl."/images/kids.png");

                $icon->setSize(32, 37);
                $icon->setAnchor(16, 16.5);
                $icon->setOrigin(0, 0);
                 
                // Create marker with label
                $marker = new EGMapMarkerWithLabel($event->latitude, $event->longitude, array('title' => $device->displayName,'icon'=>$icon));
                $gMap->setCenter($event->latitude, $event->longitude);
                $gMap->zoom = 20;

                $label_options = array(
                  'backgroundColor'=>'white',
                  'opacity'=>'0.75',
                  'width'=>'100px',
                  'color'=>'blue'
                );
                 
                $marker->labelContent= $device->displayName." (".date(Yii::app()->params["datetimeFormat"], $event->timestamp).")";
                $marker->labelStyle=$label_options;
                $marker->draggable=false;
                $marker->labelClass='labels';
                $marker->raiseOnDrag= false;
                 
                $marker->setLabelAnchor(new EGMapPoint(-20,20));
                 
                $marker->addHtmlInfoWindow($infoWindow);
                $gMap->addMarker($marker);
            }    

            $gMap->renderMap();
        ?>
        <?php echo CHtml::link('Gehe zur Großansicht...' ,array('/site/device', "id"=>$device->ident)); ?>
    <?php } else { ?>
        <p>Es liegen keine Daten vor</p>
    <?php } ?>
</div>