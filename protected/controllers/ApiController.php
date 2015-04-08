<?php

class ApiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','duplicate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','updateCurrentOption'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Api;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Api']))
		{
			$model->attributes=$_POST['Api'];
                        if($model->current_option=='') $model->current_option=null;
                        $model->url=($model->url!=""&&$model->url[0]=="/")?substr($model->url,1):$model->url;
                        
			if($model->save()){
                            //create normal case
                            $option=new Option;
                            $option->api_id=$model->id;
                            $option->name='normal';
                            $option->reponse_data='normal';
                            $option->save();
                            $model->current_option=$option->id;
                            $model->save();
                            
                            //create timeout case
                            $option=new Option;
                            $option->api_id=$model->id;
                            $option->name='timeout';
                            $option->reponse_data='timeout';
                            $option->delay=60;
                            $option->save();
                            
                            //create error(404) case
                            $option=new Option;
                            $option->api_id=$model->id;
                            $option->name='erro(404)';
                            $option->reponse_data='erro(404)';
                            $option->http_code=404;
                            $option->save();
                            
                            $this->redirect(array('update','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Api']))
		{
			$model->attributes=$_POST['Api'];
                        if($model->current_option=='') $model->current_option=null;
                        $model->url=($model->url!=""&&$model->url[0]=="/")?substr($model->url,1):$model->url;
                        
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionUpdateCurrentOption($id,$optionId){
            if(isset($_GET['ajax'])){
                $model=$this->loadModel($id);
                $model->current_option=$optionId;
                $model->save();
            }
        }
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionDuplicate($id){
		$model=new Api;
		$srcModel=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Api']))
		{
			$model->attributes=$_POST['Api'];
            $model->current_option=null;
            $model->url=ltrim($model->url," \t\r\n\0\x0b/");
			if($model->save()){

                //create option
                foreach ($srcModel->options as $srcOption) {
                	$option = new Option;
                	$option->attributes=$srcOption->attributes;
                	$option->api_id=$model->id;
                	$option->id=null;
                	if($option->save()&&$srcModel->current_option==$srcOption->id){
                		$model->current_option=$option->id;
                		$model->save();
                	}
                }
                
                $this->redirect(array('update','id'=>$model->id));
             }
		}

		$this->render('duplicate',array(
			'model'=>$model,
			'srcModel'=>$srcModel,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Api');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Api('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Api']))
			$model->attributes=$_GET['Api'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Api the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Api::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Api $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='api-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
