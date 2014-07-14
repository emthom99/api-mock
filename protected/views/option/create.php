<?php
/* @var $this OptionController */
/* @var $model Option */

$this->breadcrumbs=array(
	'Api'=>array('api/update','id'=>$model->api_id),
	'Create',
);

?>

<h1>Create Option</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>