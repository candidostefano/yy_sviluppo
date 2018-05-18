<?php
/* @var $this PraticheController */
/* @var $model Pratiche */
/* @var $form CActiveForm */
?>

  <div class="wide form">

  <?php $form=$this->beginWidget('CActiveForm', array(
  	'action'=>Yii::app()->createUrl($this->route),
  	'method'=>'get',
  )); ?>


  <div class="row">
		<?php echo $form->label($model,'id_pratica'); ?>
		<?php echo $form->textField($model,'id_pratica',array('size'=>10,'maxlength'=>10)); ?>
	</div> 
  
  <div class="row">
		<?php echo $form->label($model,'codice_fiscale'); ?>
		<?php echo $form->textField($model,'codice_fiscale',array('size'=>10,'maxlength'=>10)); ?>
	</div>  
  
	<div class="row buttons">
		<?php echo CHtml::submitButton('Ricerca'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->