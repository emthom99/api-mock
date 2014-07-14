<?php
/* @var $this OptionController */
/* @var $data Option */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('api_id')); ?>:</b>
	<?php echo CHtml::encode($data->api_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delay')); ?>:</b>
	<?php echo CHtml::encode($data->delay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('http_code')); ?>:</b>
	<?php echo CHtml::encode($data->http_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_json')); ?>:</b>
	<?php echo CHtml::encode($data->is_json); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reponse_data')); ?>:</b>
	<?php echo CHtml::encode($data->reponse_data); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('order')); ?>:</b>
	<?php echo CHtml::encode($data->order); ?>
	<br />

	*/ ?>

</div>