<?php

namespace app\controllers;

use Yii;
use app\models\Crime;
use app\models\CrimeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CrimeController implements the CRUD actions for Crime model.
 */
class CrimeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Crime models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrimeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Crime model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'provider' => $this->providerCrimes($id),
        ]);
    }

    /**
     * Creates a new Crime model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Crime();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcrime]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Crime model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcrime]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Crime model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Crime model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Crime the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crime::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    private function providerCrimes($id) {
        $sql = 'SELECT policial.nome AS nome, crime.artigo AS crime, COUNT(artigo) AS atendimentos
          FROM bo, bo_crime, bo_policial, crime, policial
          WHERE crime.idcrime = bo_crime.idcrime
          AND policial.idpolicial = bo_policial.idpolicial
          AND bo.idbo = bo_crime.idbo
          AND bo.idbo = bo_policial.idbo
          AND bo_crime.idcrime = :id
          GROUP BY policial.nome';
        $count = Yii::$app->db->createCommand($sql, [':id' => $id])->queryScalar();
        $provider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'params' => [':id' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $query1 = new \yii\db\Query();
        $query1->select('policial.nome AS nome, COUNT(crime.artigo) AS atendimentos')
                ->from('bo_crime')
                ->where(['bo_crime.idcrime' => $id])
                ->innerJoin('crime', 'crime.idcrime = bo_crime.idcrime')
                ->innerJoin('bo', 'bo.idbo = bo_crime.idbo')
                ->innerJoin('bo_policial', 'bo.idbo = bo_policial.idbo')
                ->innerJoin('policial', 'policial.idpolicial = bo_policial.idpolicial')
                ->groupBy('crime.artigo, policial.nome')
                ->orderBy('atendimentos DESC');
        $provider1 = new \yii\data\ActiveDataProvider([
            'query' => $query1,
        ]);
        
        return $provider1;
    }
    
}
