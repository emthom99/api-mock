<?php
/* @var $this HistoryController */
/* @var $model History */

$this->breadcrumbs=array(
	'Api'=>array('api/update','id'=>$model->api_id),
	'Update',
);

?>

<h1>Update History <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>