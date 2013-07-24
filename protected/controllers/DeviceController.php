<?php

class DeviceController extends AweController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = '//layouts/column1';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Device;

        $this->performAjaxValidation($model, 'device-form');

		if(isset($_POST['Device']))
		{
			$model->attributes = $_POST['Device'];
			if($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

	public function actionSetAlarmZone()
	{
		// First - clear existing alarm zone
		
		echo json_encode(array("message" => "yeah"));
		return;
	}

	public function actionUpdateDevice()
	{
	    $es = new EditableSaver('Device');
	    $es->update();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($deviceIdent)
	{
		$model = $this->loadModel($deviceIdent);

        $this->performAjaxValidation($model, 'device-form');

		if(isset($_POST['Device']))
		{
			$model->attributes = $_POST['Device'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionDevice($deviceIdent)
	{
		if (Yii::app()->user->isGuest)
			$this->redirect("/site/login");
		$device = Device::model()->loadByIdent($deviceIdent);
		if (!isset($device))
			$this->redirect("/site/index");
		if ((isset($device)) && !$device->getLastGPSEvent())
			$this->redirect(array("/site/page", "view"=>"deviceSetup"));
		$this->render('device', array(
			"device"=>$device
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect("/site/login");
		$dataProvider = new CActiveDataProvider("Device");
		$dataProvider->data = Yii::app()->user->userModel->devices;
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $modelClass=__CLASS__)
	{
		$model = Device::model()->loadByIdent($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model, $form=null)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'device-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
