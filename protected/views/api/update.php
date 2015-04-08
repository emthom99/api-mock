<?php
/* @var $this ApiController */
/* @var $model Api */

$this->breadcrumbs=array(
	'Apis'=>array('admin'),
	$model->name.' Update',
);

$this->menu=array(
	array('label'=>'Create Api', 'url'=>array('create')),
	array('label'=>'Manage Api', 'url'=>array('admin')),
    array('label'=>'Create Option', 'url'=>array('option/create','api_id'=>$model->id)),
    array('label'=>'Duplicate', 'url'=>array('api/duplicate','id'=>$model->id)),
);
?>

<h1>Update Api <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>