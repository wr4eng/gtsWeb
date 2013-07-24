<h1>Ihr Tracker hat noch keine Daten gesendet !</h1>
<h2>Bitte überprüfen Sie folgende Punkte</h2>
<ul>
	<li>Ist der Tracker aufgeladen ?</li>
	<li>Ist der Tracker eingeschalten ?</li>
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/mt90_1.jpg"/>
	<p>Der LED Indikator sollte je nach Betriebszustand eine der folgenden Sequenzen zeigen</p>
	<ul>
		<li><b>0,5 sek. ein, 0,5 sek. aus</b>: Initialisierung, schwache Batterie</li>
		<li><b>1 sek. ein, 1 sek. aus</b>: Verbunden, wartet auf GPS Signal</li>
		<li><b>1 sek. ein, 3 sek. aus</b>: Verbunden, mit GPS Signal</li>
	</ul>
</ul>
