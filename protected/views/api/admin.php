<?php
/* @var $this ApiController */
/* @var $model Api */

$this->breadcrumbs=array(
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Api', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#api-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Apis</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'api-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'afterAjaxUpdate'=>'function(){
            update_current_option();
        }',
	'columns'=>array(
                array(
                    'class'=>'CLinkColumn',
                    'header'=>'id',
                    'labelExpression'=>'$data->id',
                    'urlExpression'=>'Yii::app()->createUrl("api/update",array("id"=>$data->id))',
                ),
		'name',
                array(
                    'class'=>'CLinkColumn',
                    'header'=>'url',
                    'labelExpression'=>'$data->url',
                    'urlExpression'=>'"http://".$_SERVER["HTTP_HOST"]."/".(($data->url!="") &&($data->url[0]=="/")?substr($data->url,1):$data->url)',
                ),
                array(
                    'class'=>'CDataColumn',
                    'header'=>'current_option',
                    'type'=>'raw',
                    'value'=>'$data->currentOption!=null?CHtml::dropDownList("current_option", $data->currentOption,  CHtml::listData($data->options, "id", "name"), array("style"=>"width:100%")):""'
                ),
		array(
                    'class'=>'CButtonColumn',
                    'template'=>'{duplicate} {delete}',
                    'buttons'=> array(
                        'delete'=>array(
                            'visible'=>'$data->name!=Yii::app()->params["default_api_name"]?true:false'
                        ),
                        'duplicate'=>array(
                            'label'=>'duplicate',
                            'imageUrl'=>Yii::app()->request->baseUrl."/images/copy.png",
                            'url'=>'Yii::app()->createUrl("api/duplicate",array("id"=>$data->id))',
                        ),
                    )
		),
	),
)); 

/*Yii::app()->getClientScript()->registerScript(
    'undelete-default-api',
    'function disableDefaultDeleteButton(){
        $("#api-grid tr").each(function(index){
           apiName=$("td",this).eq(1).text();
           if(apiName=="'.Yii::app()->params['default_api_name'].'")
               $(".delete",this).attr("style","display:none");
        });
     }
     //disableDefaultDeleteButton();
    ',
    CClientScript::POS_END
);*/

Yii::app()->getClientScript()->registerScript(
    'update-current-option',
    '
        function update_current_option(){
            $("[name=\"current_option\"]").bind("focus",function(){
                $row=$(this).parents("tr");
                $row.siblings().removeClass("selected");
                $row.addClass("selected");
            });

            $("[name=\"current_option\"]").bind("change",function(){
                $.ajax({
                    type: "GET",
                    url: "'.Yii::app()->createUrl('api/updateCurrentOption').'",
                    data: {
                            id: $(this).parents("tr").find("td a")[0].text,
                            optionId: $(this).val(),
                            ajax: true
                          }  
                });
            });
        }
        update_current_option();
    ',
    CClientScript::POS_END
);   
?>
    
