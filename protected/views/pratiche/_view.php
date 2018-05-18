<?php
/* @var $this PraticheController */
/* @var $data Pratiche */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pratica')); ?>:</b>
	<?php echo CHtml::encode($data->id_pratica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_creazione')); ?>:</b>
	<?php echo CHtml::encode($data->data_creazione); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stato_pratica')); ?>:</b>
	<?php echo CHtml::encode($data->stato_pratica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente); ?>
	<br />


</div>