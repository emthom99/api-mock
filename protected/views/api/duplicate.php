<?php
/* @var $this ApiController */
/* @var $model Api */

$this->breadcrumbs=array(
	'Apis'=>array('admin'),
	'Duplicate',
);

$this->menu=array(
	array('label'=>'Manage Api', 'url'=>array('admin')),
);
?>

<h1>Duplicate Api <?=$srcModel->name?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>