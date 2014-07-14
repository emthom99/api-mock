<?php
/* @var $this HistoryController */
/* @var $model History */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'api_id'); ?>
		<?php echo CHtml::textField('api_id',$model->api->name,array('disabled'=>'true')); ?>
		<?php echo $form->error($model,'api_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'disabled'=>'true')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>60,'maxlength'=>255,'disabled'=>'true')); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'method'); ?>
		<?php echo $form->textField($model,'method',array('size'=>60,'maxlength'=>255,'disabled'=>'true')); ?>
		<?php echo $form->error($model,'method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resquest'); ?>
		<?php echo $form->textArea($model,'resquest',array('rows'=>30, 'cols'=>100,'disabled'=>'true')); ?>
		<?php echo $form->error($model,'resquest'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'response'); ?>
		<?php echo $form->textArea($model,'response',array('rows'=>6, 'cols'=>100,'disabled'=>'true')); ?>
		<?php echo $form->error($model,'response'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->