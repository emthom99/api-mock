<?php
/* @var $this HistoryController */
/* @var $model History */

$this->breadcrumbs=array(
	'Manage',
);

$this->menu=array(
	array('label'=>'Delete All History', 'url'=>array('deleteAll')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#history-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Histories</h1>

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
	'id'=>'history-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'class'=>'CLinkColumn',
                    'header'=>'id',
                    'labelExpression'=>'$data->id',
                    'urlExpression'=>'Yii::app()->createUrl("history/update",array("id"=>$data->id))',
                ),
                array(
                    'class'=>'CLinkColumn',
                    'header'=>'Api',
                    'labelExpression'=>'$data->api->name."<br>".($data->url==""?"empty":"[".$data->url."]")',
                    'urlExpression'=>'Yii::app()->createUrl("api/update",array("id"=>$data->api_id))',
                ),
                'name',
		'ip',
		'method',
		'create_time',
		/*
		'response',
		*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{delete}',
		),
	),
)); 
Yii::app()->getClientScript()->registerCss('resize-apiname-col','#history-grid_c0 {width:30px}');
?>
