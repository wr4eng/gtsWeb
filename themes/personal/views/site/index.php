<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php
	Yii::import('ext.EGMap.*');

	$gMap = new EGMap();
	$gMap->width = "100%";
	$gMap->height = "100%";

	$gMap->zoom = 12;
	$mapTypeControlOptions = array(
	  'position'=> EGMapControlPosition::LEFT_BOTTOM,
	  'style' => EGMap::MAPTYPECONTROL_STYLE_HORIZONTAL_BAR
	);
	 
	$gMap->mapTypeControlOptions= $mapTypeControlOptions;
	$gMap->mapTypeId = EGMap::TYPE_HYBRID;	 

	if (isset($devices)) {
		Yii::log("Count: ".count($devices),"notice");
		foreach($devices as $device) {
			$event = $device->getLastGPSEvent();
			if (!isset($event)) continue;
			// Create GMapInfoWindows
			$infoWindow = new EGMapInfoWindow('<div>Joschua Unterwegs</div>');
			$icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl."/images/kids.png");

			$icon->setSize(32, 37);
			$icon->setAnchor(16, 16.5);
			$icon->setOrigin(0, 0);
			 
			// Create marker with label
			$marker = new EGMapMarkerWithLabel($event->latitude, $event->longitude, array('title' => $device->displayName,'icon'=>$icon));
			$gMap->setCenter($event->latitude, $event->longitude);
			 
			$label_options = array(
			  'backgroundColor'=>'white',
			  'opacity'=>'0.75',
			  'width'=>'100px',
			  'color'=>'blue'
			);
			 
			$marker->labelContent= $device->displayName." (".date("d.m.Y, H:i:s", $event->timestamp).")";
			$marker->labelStyle=$label_options;
			$marker->draggable=false;
			$marker->labelClass='labels';
			$marker->raiseOnDrag= false;
			 
			$marker->setLabelAnchor(new EGMapPoint(-20,20));
			 
			$marker->addHtmlInfoWindow($infoWindow);
			$gMap->addMarker($marker);
		}
	}	 

	$gMap->renderMap();
?>