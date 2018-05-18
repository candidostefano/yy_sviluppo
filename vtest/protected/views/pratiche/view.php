<?php
/* @var $this PraticheController */
/* @var $model Pratiche */

$this->breadcrumbs=array(
	'Pratiche'=>array('admin'),
	$model->id,
);
?>

<h1>Dettaglio pratica ID:<?php echo $model->id_pratica; ?></h1>

<?php         
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
    'data_creazione',
		'id_pratica',
		'stato_pratica',
    'cliente.nome',
    'cliente.cognome',
	),  
)); 

echo CHtml::link('Torna alla lista Pratiche',array('Pratiche/admin'));
?>
