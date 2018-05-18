<?php
/* @var $this PraticheController */
/* @var $model Pratiche */

$this->breadcrumbs=array(
	'Pratiche'=>array('admin'),
	'Importa CSV',
);

$check_superuser = Yii::app()->user->getId();
if($check_superuser!='admin') { 
  $this->redirect(array('Pratiche/admin'));
}
?>

<h1>Importa CSV Pratiche</h1>
<p>Il file CSV dovr&agrave; contenere tutti i dati delle pratiche, incluso pratica & lista utenti</p>

<?php
$form=$this->beginWidget('CActiveForm', array(
        'id'=>'csv_file',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); 
?>

<div>
		<?php echo $form->fileField($model,'csv_file'); ?>
		<?php echo $form->error($model, 'csv_file'); ?>
</div>
	<hr>
		<?php  echo CHtml::submitButton('Upload CSV',array("class"=>"")); ?>
		<?php echo $form->errorSummary($model); ?>

<?php $this->endWidget(); ?>