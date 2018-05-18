<?php
/* @var $this PraticheController */
/* @var $model Pratiche */    

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pratiche-grid').yiiGridView('update', {   
		data: $(this).serialize()  
	});  
  
    var Pratiche_id_pratica = $('#Pratiche_id_pratica').val();
    var Pratiche_codice_fiscale = $('#Pratiche_codice_fiscale').val();
    if(Pratiche_id_pratica==''){ var Pratiche_id_pratica = 0; }
    if(Pratiche_codice_fiscale==''){ var Pratiche_codice_fiscale = 0; }
    var new_extract_link = '".Yii::app()->baseUrl."/Pratiche/Export?pratica='+Pratiche_id_pratica+'&cf='+Pratiche_codice_fiscale;
    $('.export_link').attr('href', new_extract_link);
  
	return false;
});      
");
?>

<h1>Gestione pratiche</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->          

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pratiche-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'id_pratica',
		'stato_pratica',
		array(
			'class'=>'CButtonColumn',
      'buttons'=>array(
      'update' => array(
         'visible'=>'false',
       ),
       'delete' => array(
         'visible'=>'false',
       ),
       ),
		),
    
    
	),
));      

echo CHtml::link('Esporta Pratiche',array('Pratiche/Export','pratica'=>'0','cf'=>'0'),array('class'=>'export_link'));?>
<p style="font-size:11px;color:#666;">Nota: Usando il sistema di ricerca e filtrando i risultati, l'export sar&agrave; unicamente per i risultati filtrati</p>






