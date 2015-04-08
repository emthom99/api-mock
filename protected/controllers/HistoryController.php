<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!function_exists('http_response_code'))
{
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }       
        return $code;
    }
}
class HistoryController extends Controller
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
				'actions'=>array('index','create','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteAll'),
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

        public static function  getRemotePage($req_url, $req_method, $req_params, $req_user_agent, $req_cookies, $req_referer, 
        	&$res_status, &$res_cookies, &$res_content, &$res_header) {
            // create a new cURL resource
            $ch = curl_init();

            // set URL and other appropriate options
            /* curl_setopt($ch, CURLOPT_CRLF, true); */
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_URL, $req_url);
            if ($req_method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $req_params);
            }
            
            curl_setopt($ch, CURLOPT_USERAGENT, $req_user_agent);
            curl_setopt($ch, CURLOPT_COOKIE, $req_cookies);
            if ($req_referer <> '')
                curl_setopt($ch, CURLOPT_REFERER, $req_referer);

            // grab URL and pass it to the browser
            $response=curl_exec($ch);
            list( $res_header, $res_content ) = preg_split( '/([\r\n][\r\n])\\1/', $response, 2 );
            if(strpos($res_header," 100 Continue")!==false){
                list( $res_header, $res_content ) = preg_split( '/([\r\n][\r\n])\\1/', $res_content, 2 );
            }
            $res_status = curl_getinfo($ch);
            preg_match_all('/^Set-Cookie: (.*?);/m', $res_header, $cookies);
            $res_cookies = count($cookies) > 0 ? implode('; ', $cookies[1]) : '';
            $res_cookies = implode('; ', $cookies[1]);
            // close cURL resource, and free up system resources
            curl_close($ch);

            /*if($res_status['http_code']==301){
                preg_match('#Location: (.*)#', $header, $matches);
                if(isset($matches[1])){
                    self::getRemotePage($matches[1], $req_method, $req_params, $req_user_agent, $req_cookies, $req_referer, $res_status, $res_cookies, $res_content);
                }
            }*/
        }
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($duccui_url)
	{
		$request="";
                $model=new History;
                
                $model->url=$duccui_url;
                $model->create_time=new CDbExpression('NOW()');
                $model->ip=$_SERVER['REMOTE_ADDR'];
                
                $model->method=$_SERVER['REQUEST_METHOD'];
                
                //GET
                $tmpGET=$_GET;
                unset($tmpGET['duccui_r']);
                unset($tmpGET['duccui_url']);
                if(count($tmpGET)) $request.="\r\n\r\n============GET Params===========================================\r\nGET Params ".var_export($tmpGET,true);
                
                //POST
                if(count($_POST)) $request.="\r\n\r\n===============POST Params========================================\r\nPOST Params ".var_export($_POST,true);
                
                //COOKIES
                if(count($_COOKIE)) $request.="\r\n\r\n=============COOKIES Params==========================================\r\nCOOKIES Params ".var_export($_COOKIE,true);
                
                $files=array();
                if(count($_FILES)>0){
                    foreach ($_FILES as $kfile=>$file) {
                        $path_parts =pathinfo($file['name']);
                        $newName=$path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
                        move_uploaded_file($file['tmp_name'],Yii::app()->basePath.'/../data/'.$newName);
                        $files[$kfile]=array('filename'=>$file['name'],'servername'=>$newName);
                    }
                    
                    $request.="\r\n\r\n=============FILE Params==========================================\r\n";
                    $request.="FILE Params ".var_export($files,true);
                }
                $request.="\r\n\r\n=======================================================\r\n\r\n";
        		$request.="REQUEST HEADER INFO ".var_export(getallheaders(),true);

                $request.="\r\n\r\n=======================================================\r\n\r\n";
        		$request.="SERVER INFO ".var_export($_SERVER,true);
                $model->resquest=$request;
                
                $api=Api::model()->findByAttributes(array('url'=>$duccui_url));
                if($api==null)
                    $api=Api::model()->findByAttributes(array('name'=>Yii::app()->params['default_api_name']));
                
                $model->api_id=$api->id;
                
                if(($option=$api->currentOption)!==null){
                    if($option->delay>0)
                        sleep ($option->delay);
                    
                    $model->name=$option->name;
                    if($option->is_passthrough==1){
                        $url_passthrough=$option->url_passthrough;
                        $req_params=array();
                        if($model->method=='GET'){
                            $url_passthrough=$url_passthrough.'?'.http_build_query($tmpGET);
                        }
                        else{
                            $req_params=$_POST;
                            foreach ($files as $kfile=>$file) {
                                $req_params[$kfile]='@'.realpath(Yii::app()->basePath.'/../data/'.$file['servername']);
                            }
                        }

                        self::getRemotePage($url_passthrough, $model->method, $req_params, 
                                $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_COOKIE'], '', 
                                $res_status, $res_cookies, $res_content, $res_header);
                    }
                    else{
                        if ($option->custom_header) {
                        	$res_header=$option->response_header;
                        }
                        else{
                        	$res_header='HTTP/1.1 '.$option->http_code;
                        	$res_header.=$option->is_json?"\nContent-type: application/json":"\nContent-type: text/html";
                        }
                        $res_content=$option->reponse_data;
                    }
                    
                    $aHeader=explode("\n", preg_replace('/(Set-Cookie: .*?);.*/', '$1', $res_header));
                    foreach ($aHeader as $headerItem) {
                    	if(strpos($headerItem, "Transfer-Encoding: chunked")!==false)
                    		continue;
                    	header($headerItem,false);
                    }
                    $model->response="\r\n\r\n=============RESPONSE HEADER==========================================\r\n".$res_header;
                    $model->response.="\r\n\r\n=============RESPONSE CONTENT==========================================\r\n".$res_content;
                    echo $res_content;
                }
                else {
                    echo '';
                }
                $model->save();
                return;
	}

        public function actionDeleteAll(){
            History::model()->deleteAll();
            $this->redirect(array('admin'));
            
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

		if(isset($_POST['History']))
		{
			$model->attributes=$_POST['History'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('History');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new History('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['History']))
			$model->attributes=$_GET['History'];

                $model->dbCriteria->order='create_time desc, id desc';
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return History the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=History::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param History $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='history-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
