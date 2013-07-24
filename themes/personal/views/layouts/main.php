<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>


<div class="container content-area" id="page">
	<div id="header"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/header.jpg"/></div>
	<?php 
		$devicesMenu = null;
		if (!Yii::app()->user->isGuest) {
			$devices = Yii::app()->user->userModel->devices;
			if ((isset($devices)) && (count($devices)>1)) {
				$devicesMenu = array(
		            'class'=>'bootstrap.widgets.TbMenu',
		            'label'=>'Geräte',
		            'items'=>array(
		            ),
		        );
				foreach(Yii::app()->user->userModel->devices as $device) {
		            $deviceItem = array(
		            	'label'=>$device->displayName, 
		            	'url'=>array('/device/device', "deviceIdent"=>$device->ident),
		            );
					$devicesMenu['items'][] = $deviceItem;
				}
			}
			$this->widget('bootstrap.widgets.TbNavbar',array(
		        'fixed'=>'',
		        'fluid'=>false,
			    'items'=>array(
			        array(
			            'class'=>'bootstrap.widgets.TbMenu',
			            'items'=>array(
			            	$devicesMenu,
			                array('label'=>'Übersicht', 'url'=>array('/site/index')),
			                array('label'=>'Verwaltung', 'url'=>array('/device')),
			                array('label'=>'Kontakt', 'url'=>array('/site/contact')),
			                array('label'=>'Impressum', 'url'=>array('/site/page', 'view'=>'impressum')),
			                array('label'=>'Anmelden', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			                array('label'=>'Abmelden ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			            ),
			        ),
			    ),
			)); 
		} else {
			$this->widget('bootstrap.widgets.TbNavbar',array(
		        'fixed'=>'',
		        'fluid'=>false,
			    'items'=>array(
			        array(
			            'class'=>'bootstrap.widgets.TbMenu',
			            'items'=>array(
			                array('label'=>'Kontakt', 'url'=>array('/site/contact')),
			                array('label'=>'Impressum', 'url'=>array('/site/page', 'view'=>'impressum')),
			                array('label'=>'Anmelden', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			                array('label'=>'Abmelden ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			            ),
			        ),
			    ),
			)); 
		}
	?>

	<?php echo $content; ?>

	<div class="clear"></div>


</div><!-- page -->
</body>
</html>
