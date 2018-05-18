<?php

class PraticheController extends Controller {


    public $layout = '//layouts/column1';


    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     Imposto l'accesso solo per gli utenti riconosciuti
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users'=>array('@'),
            ),
            array('deny'),
        );
    }

    /**
     * Visualizzazione singola pratica
     *
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * IndexPage con la lista di tutte le pratiche
     *
     */
    public function actionAdmin() {
        $model = new Pratiche('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pratiche']))
            $model->attributes = $_GET['Pratiche'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Sistema che gestisce l'export
     * Sono previste due varianti, pratica e codice fiscale, se le varianti sono vuote o uguale a zero viene estratto tutto il db
     * Se id pratica o codice fiscale hanno un valore allora vengono filtrati i risultati
     */

    public function actionExport($pratica,$cf) {
        Yii::import('ext.ECSVExport');
        $qt = "SELECT 
                  pratiche.id AS `id_generico`, 
                  pratiche.id_pratica AS `id_pratica`,
                  pratiche.data_creazione AS `data_creazione`, 
                  pratiche.stato_pratica AS `stato_pratica`, 
                  pratiche.note AS `note_pratica`, 
                  pratiche.id_cliente AS `id_cliente`,
                  cliente.id AS `id_generico_cliente`, 
                  cliente.nome AS `nome`,
                  cliente.cognome AS `cognome`,
                  cliente.codice_fiscale AS `codice_fiscale`,
                  cliente.note AS `note_cliente`
                  FROM `pratiche`
          INNER JOIN cliente ON pratiche.id_cliente = cliente.id";
        
        if($pratica!='0' OR $cf!='0'){ 
          $qt = $qt.' WHERE';
          if($pratica!='0'){ 
            $qt = $qt.' id_pratica="'.$pratica.'"';
          }
          if($pratica!='0' AND $cf!='0'){ 
            $qt = $qt.' AND codice_fiscale="'.$cf.'"';
          }
          if($pratica=='0' AND $cf!='0'){ 
            $qt = $qt.' codice_fiscale="'.$cf.'"';
          }
          
        }
                
        $cmd = Yii::app()->db->createCommand($qt);
        $csv = new ECSVExport($cmd);
        $content = $csv->toCSV();
        Yii::app()->getRequest()->sendFile('exp.csv', $content, "text/csv", false);
        exit();
    }
    
    /**
     * Sistema che gestisce l'import da FILE CSV
     * Disponibile solo per ADMIN
     */

    public function actionImporta() {
        $model = new Pratiche;
        
        if (isset($_POST['Pratiche'])) {
            if (!empty($_FILES['Pratiche']['tmp_name']['csv_file'])) {
            $handle = fopen($_FILES['Pratiche']['tmp_name']['csv_file'], 'r');

            if ($handle) {
              fgets($handle); 
              while(($line = fgetcsv($handle, 1000, ",")) != FALSE) {                 
                $sql = "insert into pratiche (id,id_pratica, data_creazione, stato_pratica, note, id_cliente) values (:id, :id_pratica, :data_creazione, :stato_pratica, :note, :id_cliente)";
                $parameters = array(":id"=>$line[0],":id_pratica"=>$line[1],":data_creazione"=>$line[2],":stato_pratica"=>$line[3],":note"=>$line[4],":id_cliente"=>$line[5]);
                Yii::app()->db->createCommand($sql)->execute($parameters);
                
                
                
                $sql = "insert ignore into cliente (id,nome,cognome,codice_fiscale,note) values (:id, :nome, :cognome, :codice_fiscale, :note)";
                $parameters = array(":id"=>$line[6],":nome"=>$line[7],":cognome"=>$line[8],":codice_fiscale"=>$line[9],":note"=>$line[10]);
                Yii::app()->db->createCommand($sql)->execute($parameters);
              }        
            }
            fclose($handle);
            $this->redirect(array('Pratiche/admin')); 
            }
        }
      
      $this->render('importa', array('model' => $model));
    }


    public function loadModel($id) {
        $model = Pratiche::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pratiche-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
