<?php

namespace app\controllers;

use Yii;
use app\models\Policial;
use app\models\PolicialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

/**
 * PolicialController implements the CRUD actions for Policial model.
 */
class PolicialController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'email', 'ficha', 'escala', 'foto'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Policial models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PolicialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Policial model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $query2 = \app\models\PolicialUnidade::find()->where(['idpolicial' => $id]);
        $provider = new ActiveDataProvider([
            'query' => $query2,
        ]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'provider' => $provider,
        ]);
    }

    /**
     * Creates a new Policial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Policial();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->flag = \yii\web\UploadedFile::getInstance($model, 'flag');
            if ($model->upload()) {
                return $this->redirect(['view', 'id' => $model->idpolicial]);
            } else {
                return $this->redirect(['update', 'model' => $model]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Policial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Policial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        try {
            $this->findModel($id)->delete();
        } catch (Exception $e) {
            
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Policial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Policial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Policial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFoto($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->flag = \yii\web\UploadedFile::getInstance($model, 'flag');
            if ($model->upload()) {
                return $this->redirect(['view', 'id' => $model->idpolicial]);
            } else {
                return $this->redirect(['foto', 'model' => $model]);
            }
        } else {
            return $this->render('foto', [
                        'model' => $model,
            ]);
        }
    }

    public function actionEmail($id) {
        $model = $this->findModel($id);
        $destino = $model->email;

        $content1 = $this->renderPartial('ficha', [
            'model' => $this->findModel($id),
            'provider1' => $this->provider1($id),
            'provider2' => $this->provider2($id),
            'provider3' => $this->provider3($id),
            'provider4' => $this->provider4($id),
            'provider5' => $this->provider5($id),
            'provider6' => $this->provider6($id),
            'expedientes' => $this->providerExpedienteTotal($id),
            'cumpridos' => $this->providerExpedienteCumprido($id),
            'justificados' => $this->providerExpedienteJustificado($id),
            'ocorrencias' => $this->providerOcorrencias($id),
        ]);

        $pdf1 = new \kartik\mpdf\Pdf([
            'destination' => \kartik\mpdf\Pdf::DEST_FILE,
            'content' => $content1,
        ]);
        $pdf1->filename = Yii::getAlias('@webroot/ficha/' . $id . '.pdf');
        $pdf1->render();

        Yii::$app->mailer->compose('ficha', [
                    'model' => $this->findModel($id),
                    'provider1' => $this->provider1($id),
                    'provider2' => $this->provider2($id),
                    'provider3' => $this->provider3($id),
                    'provider4' => $this->provider4($id),
                    'provider5' => $this->provider5($id),
                    'provider6' => $this->provider6($id),
                    'expedientes' => $this->providerExpedienteTotal($id),
                    'cumpridos' => $this->providerExpedienteCumprido($id),
                    'justificados' => $this->providerExpedienteJustificado($id),
                    'ocorrencias' => $this->providerOcorrencias($id),
                ])
                ->setFrom('roberto@kairiroberto.com')
                ->attach(Yii::getAlias('@webroot/ficha/' . $id . '.pdf'))
                ->setTo($destino)
                ->setSubject('Detalhe do policial')
                ->send();

        $content2 = $this->renderPartial('escala', [
            'model' => $this->findModel($id),
            'provider1' => $this->provider1Escala($id),
        ]);

        $pdf2 = new \kartik\mpdf\Pdf([
            'destination' => \kartik\mpdf\Pdf::DEST_FILE,
            'content' => $content2,
        ]);
        $pdf2->filename = Yii::getAlias('@webroot/escala/' . $id . '.pdf');
        $pdf2->render();

        Yii::$app->mailer->compose('escala', [
                    'model' => $this->findModel($id),
                    'provider1' => $this->provider1Escala($id),
                ])
                ->setFrom('roberto@kairiroberto.com')
                ->attach(Yii::getAlias('@webroot/escala/' . $id . '.pdf'))
                ->setTo($destino)
                ->setSubject('Detalhe do policial')
                ->send();


        return $this->redirect(['view', 'id' => $model->idpolicial]);
    }

    public function actionFicha($id) {
        return $this->render('ficha', [
                    'model' => $this->findModel($id),
                    'provider1' => $this->provider1($id),
                    'provider2' => $this->provider2($id),
                    'provider3' => $this->provider3($id),
                    'provider4' => $this->provider4($id),
                    'provider5' => $this->provider5($id),
                    'provider6' => $this->provider6($id),
                    'expedientes' => $this->providerExpedienteTotal($id),
                    'cumpridos' => $this->providerExpedienteCumprido($id),
                    'justificados' => $this->providerExpedienteJustificado($id),
                    'ocorrencias' => $this->providerOcorrencias($id),
        ]);
    }

    public function actionEscala($id) {
        return $this->render('escala', [
                    'model' => $this->findModel($id),
                    'provider1' => $this->provider1Escala($id),
        ]);
    }

    private function providerExpedienteTotal($id) {
        $sql = 'SELECT COUNT(*) AS Expedientes
                FROM policial, diaria, policial_diaria
                WHERE policial_diaria.idpolicial = policial.idpolicial 
                AND policial_diaria.iddiaria = diaria.iddiaria 
                AND policial_diaria.idpolicial = :id'
        ;
        $count = Yii::$app->db->createCommand($sql, [':id' => $id])->queryScalar();
        $provider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':id' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $count;
    }

    private function providerExpedienteCumprido($id) {
        $sql = 'SELECT COUNT(*) AS Cumpridos
                FROM policial, diaria, policial_diaria
                WHERE policial_diaria.idpolicial = policial.idpolicial 
                AND policial_diaria.iddiaria = diaria.iddiaria 
                AND policial_diaria.idpolicial = :id AND executada = 1'
        ;
        $count = Yii::$app->db->createCommand($sql, [':id' => $id])->queryScalar();
        $provider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':id' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $count;
    }

    private function providerExpedienteJustificado($id) {
        $sql = 'SELECT COUNT(*) AS Justificados
                FROM policial, diaria, policial_diaria
                WHERE policial_diaria.idpolicial = policial.idpolicial 
                AND policial_diaria.iddiaria = diaria.iddiaria 
                AND policial_diaria.idpolicial = :id AND justificada = 1'
        ;
        $count = Yii::$app->db->createCommand($sql, [':id' => $id])->queryScalar();
        $provider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':id' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $count;
    }
    
    private function providerOcorrencias($id) {
        $sql = 'SELECT COUNT(*) AS Ocorrencias
                FROM policial, bo_policial
                WHERE policial.idpolicial = bo_policial.idpolicial 
                AND bo_policial.idpolicial = :id'
        ;
        $count = Yii::$app->db->createCommand($sql, [':id' => $id])->queryScalar();
        $provider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':id' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $count;
    }

    private function provider1Escala($id) {
        $query1 = new \yii\db\Query();
        $query1->select('*')
                ->from('policial_diaria')
                ->where(['policial_diaria.idpolicial' => $id])
                ->innerJoin('policial', 'policial.idpolicial = policial_diaria.idpolicial')
                ->innerJoin('diaria', 'diaria.iddiaria = policial_diaria.iddiaria')
                ->andWhere('diaria.data_ini >= NOW()');
        $provider1 = new ActiveDataProvider([
            'query' => $query1,
        ]);
        return $provider1;
    }

    private function provider1($id) {
        /* SELECT policial.nome, artigo, count(artigo)
          FROM bo, bo_crime, bo_policial, crime, policial
          WHERE crime.idcrime = bo_crime.idcrime
          AND policial.idpolicial = bo_policial.idpolicial
          AND bo.idbo = bo_crime.idbo
          AND bo.idbo = bo_policial.idbo
          AND policial.idpolicial = 1
          GROUP BY artigo, policial.nome */

        $query1 = new \yii\db\Query();
        $query1->select('policial.nome AS nome, crime.nome AS crime, count(crime.artigo) AS atendimento')
                ->from('bo')
                ->where(['policial.idpolicial' => $id])
                ->innerJoin('bo_crime', 'bo.idbo = bo_crime.idbo')
                ->innerJoin('crime', 'crime.idcrime = bo_crime.idcrime')
                ->innerJoin('bo_policial', 'bo.idbo = bo_policial.idbo')
                ->innerJoin('policial', 'policial.idpolicial = bo_policial.idpolicial')
                ->groupBy('crime.artigo, policial.nome')
                ->orderBy('atendimento DESC');
        $provider1 = new ActiveDataProvider([
            'query' => $query1,
        ]);
        return $provider1;
    }

    private function provider2($id) {
        $query2 = \app\models\PolicialUnidade::find()->where(['idpolicial' => $id]);
        $provider2 = new ActiveDataProvider([
            'query' => $query2,
        ]);
        return $provider2;
    }

    private function provider3($id) {
        $query3 = \app\models\PolicialCargo::find()->where(['idpolicial' => $id]);
        $provider3 = new ActiveDataProvider([
            'query' => $query3,
        ]);
        return $provider3;
    }

    private function provider4($id) {
        $query4 = \app\models\PolicialCurso::find()->where(['idpolicial' => $id]);
        $provider4 = new ActiveDataProvider([
            'query' => $query4,
        ]);
        return $provider4;
    }

    private function provider5($id) {
        $query5 = \app\models\Oficial::find()->where(['idpolicial' => $id]);
        $provider5 = new ActiveDataProvider([
            'query' => $query5,
        ]);
        return $provider5;
    }
    
    private function provider6($id) {
        $query6 = \app\models\Praca::find()->where(['idpolicial' => $id]);
        $provider6 = new ActiveDataProvider([
            'query' => $query6,
        ]);
        return $provider6;
    }
    
}
