<?php

/**
 * This is the model class for table "pratiche".
 *
 * The followings are the available columns in table 'pratiche':
 * @property integer $id
 * @property string $id_pratica
 * @property string $data_creazione
 * @property string $stato_pratica
 * @property string $note
 * @property integer $id_cliente
 */
class Pratiche extends CActiveRecord
{
  public $codice_fiscale;
	public function tableName()
	{
		return 'pratiche';
	}


	public function rules()
	{

		return array(
			array('id_pratica, data_creazione, stato_pratica, note, id_cliente', 'required'),
			array('id_cliente', 'numerical', 'integerOnly'=>true),
			array('id_pratica', 'length', 'max'=>10),
			array('stato_pratica', 'length', 'max'=>5),
			array('id, id_pratica, data_creazione, stato_pratica, note, id_cliente, codice_fiscale, csv_file', 'safe', 'on'=>'search'),
      
      array('csv_file',
	       'file', 'types' => 'csv',
	       'maxSize'=>5242880,
	       'allowEmpty' => true,
	       'wrongType'=>'Only csv allowed.',
	       'tooLarge'=>'File troppo grande, il limite è di 5mb'),
      
		);
	}  
  

	/**
	 * @Imposto la relazione tra le tabelle Pratiche e Clienti
	 */
	public function relations()
	{
		return array(
      'cliente'=>array( self::BELONGS_TO, 'cliente', 'id_cliente' )
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_pratica' => 'Id Pratica',
			'data_creazione' => 'Data Creazione',
			'stato_pratica' => 'Stato Pratica',
			'note' => 'Note',
			'id_cliente' => 'Id Cliente',             
		);
	}
 	
   /**
	 * @SISTEMA DI RICERCA filtrato solo per ID PRATICA o CODICE FISCALE
	 */
  
	public function search()
	{
		$criteria=new CDbCriteria;    
    $criteria->compare('id_pratica',$this->id_pratica,true);
    $criteria->with = array('cliente');
    $criteria->compare('codice_fiscale', $this->codice_fiscale, true ); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,  
		));
	}   

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
