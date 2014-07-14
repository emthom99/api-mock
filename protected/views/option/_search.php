<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'api_id'); ?>
		<?php echo $form->textField($model,'api_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delay'); ?>
		<?php echo $form->textField($model,'delay'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'http_code'); ?>
		<?php echo $form->textField($model,'http_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_json'); ?>
		<?php echo $form->textField($model,'is_json'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reponse_data'); ?>
		<?php echo $form->textArea($model,'reponse_data',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order'); ?>
		<?php echo $form->textField($model,'order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->