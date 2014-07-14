<?php
/* @var $this OptionController */
/* @var $model Option */

$this->breadcrumbs=array(
	'Api'=>array('api/update','id'=>$model->api_id),
	'Update',
);
?>

<h1>Update Option <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>