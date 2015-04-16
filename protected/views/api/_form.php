<?php
/* @var $this ApiController */
/* @var $model Api */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'api-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'readonly'=>$model->name==Yii::app()->params["default_api_name"])); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255,'readonly'=>$model->name==Yii::app()->params["default_api_name"])); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row" style="display: none">
		<?php echo $form->labelEx($model,'current_option'); ?>
		<?php echo $form->textField($model,'current_option',array('size'=>20,'maxlength'=>20,'id'=>'current_option')); ?>
		<?php echo $form->error($model,'current_option'); ?>
	</div>
        
<?php
    if(!$model->isNewRecord){
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'api-option-grid',
            'selectionChanged'=>'function (id){
                thisTable=$("#"+id)
                selectedIds=thisTable.yiiGridView("getSelection");
                if(selectedIds.length==0){
                    lastSelect=$("#current_option").val();
                    $.each(thisTable.find(".keys span"),function(index, value){
                        if($(value).text()==lastSelect){
                            $(thisTable.yiiGridView("getRow",index)[0]).trigger("click");
                        }
                    });
                }
                else{
                    $("#current_option").val(selectedIds[0]);
                }
            }',
            'dataProvider'=>new CArrayDataProvider($model->options,array(
                    'id'=>'option',
                    'sort'=>array(
                        'defaultOrder'=>array(
                            'order'=>  CSort::SORT_ASC,
                            'id'=>  CSort::SORT_ASC
                        ),
                    ),
                    'pagination'=>array(
                        'pageSize'=>20,
                    ),
                )
            ),
            //'filter'=>  Option::model(),
            'columns'=>array(
                    array(
                        'class'=>'CCheckBoxColumn',
                        'header'=>'S',
                        'checked'=>'$data->id=="'.$model->current_option.'"',
                        'id'=>'selecting-option',
                    ),
                    array(
                        'class'=>'CLinkColumn',
                        'header'=>'name',
                        'labelExpression'=>'$data->name',
                        'urlExpression'=>'Yii::app()->createUrl("option/update",array("id"=>$data->id))',
                    ),
                
                    array(
                        'class'=>'CDataColumn',
                        'header'=>'pass',
                        'type'=>'raw',
                        'value'=>'CHtml::checkBox("",$data->is_passthrough==1,array("disabled"=>"disabled"))'
                    ),
                    'delay',
                    'http_code',
                    'is_json',
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=> array(
                            'delete'=> array(
                                'url'=>'Yii::app()->createUrl("option/delete", array("id"=>$data->id))'
                            )
                        )
                    ),
            ),
        )); 

        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'api-history-grid',
            'dataProvider'=>new CArrayDataProvider($model->histories,array(
                    'id'=>'history',
                    'sort'=>array(
                        'attributes'=>array('create_time'),
                        'defaultOrder'=>array('create_time'=>CSort::SORT_DESC),
                    ),
                    'pagination'=>array(
                        'pageSize'=>20,
                    ),
                )
            ),
            //'filter'=>  History::model(),
            'columns'=>array(
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name,Yii::app()->createUrl("history/update",array("id"=>$data->id)))'
                    ),
                    'ip',
                    'method',
                    'create_time'
            ),
     )); 
    }
    ?>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php 
    Yii::app()->getClientScript()->registerScript(
        'update-current-option',
        '
            $("#api-form").submit(function(){
                $("#current_option").val($("#api-option-grid").yiiGridView("getChecked", "selecting-option"));
            });
        ',
        CClientScript::POS_END
        ); 
?>
</div><!-- form -->