<?php
/* @var $this OptionController */
/* @var $model Option */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'option-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row" style="display: none">
		<?php echo $form->labelEx($model,'api_id'); ?>
		<?php echo $form->textField($model,'api_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'api_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_passthrough'); ?>
		<?php echo $form->checkbox($model,'is_passthrough'); ?>
		<?php echo $form->error($model,'is_passthrough'); ?>
	</div>
        
        <div id="passthrough">
            <div class="row">
                    <?php echo $form->labelEx($model,'url_passthrough'); ?>
                    <?php echo $form->textField($model,'url_passthrough',array('style'=>'width:100%')); ?>
                    <?php echo $form->error($model,'url_passthrough'); ?>
            </div>
        </div>
        
        <div class="row">
                <?php echo $form->labelEx($model,'delay'); ?>
                <?php echo $form->textField($model,'delay'); ?>
                <?php echo $form->error($model,'delay'); ?>
        </div>
        
        <div id="not_passthrough">

            <div class="row">
                <?php echo $form->labelEx($model,'custom_header'); ?>
                <?php echo $form->checkbox($model,'custom_header'); ?>
                <?php echo $form->error($model,'custom_header'); ?>
            </div>

            <div id="custom_header">

                <div class="row">
                        <?php echo $form->labelEx($model,'response_header'); ?>
                        <?php echo $form->textArea($model,'response_header',array('rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->error($model,'response_header'); ?>
                </div>

            </div>
            
            <div id="not_custom_header">

                <div class="row">
                        <?php echo $form->labelEx($model,'http_code'); ?>
                        <?php echo $form->textField($model,'http_code'); ?>
                        <?php echo $form->error($model,'http_code'); ?>
                </div>

                <div class="row">
                        <?php echo $form->labelEx($model,'is_json'); ?>
                        <?php echo $form->checkbox($model,'is_json'); ?>
                        <?php echo $form->error($model,'is_json'); ?>
                </div>

            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'reponse_data'); ?>
                    <?php echo $form->textArea($model,'reponse_data',array('rows'=>6, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'reponse_data'); ?>
            </div>
        </div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'order'); ?>
		<?php echo $form->textField($model,'order'); ?>
		<?php echo $form->error($model,'order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    
    Yii::app()->getClientScript()->registerScript(
            'toggle_passthrough_view',
            '
                function toggle_passthrough_view(){
                    if($("#Option_is_passthrough").is(":checked")){
                        $("#passthrough").show();
                        $("#not_passthrough").hide();
                    }
                    else{
                        $("#passthrough").hide();
                        $("#not_passthrough").show();
                    }
                }
                
                $("#Option_is_passthrough").bind("change",toggle_passthrough_view);
                
                toggle_passthrough_view();
            ',
            CClientScript::POS_END
    );
    
    Yii::app()->getClientScript()->registerScript(
            'toggle_custome_header_view',
            '
                function toggle_custome_header_view(){
                    if($("#Option_custom_header").is(":checked")){
                        $("#custom_header").show();
                        $("#not_custom_header").hide();
                    }
                    else{
                        $("#custom_header").hide();
                        $("#not_custom_header").show();
                    }
                }
                
                $("#Option_custom_header").bind("change",toggle_custome_header_view);
                
                toggle_custome_header_view();
            ',
            CClientScript::POS_END
    );
?>