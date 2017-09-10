<?php

namespace app\controllers;

use Yii;
use app\models\Diaria;
use app\models\DiariaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * DiariaController implements the CRUD actions for Diaria model.
 */
class DiariaController extends Controller {

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
                        'actions' => ['index', 'index2', 'view'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'varias', 'pdiaria'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Diaria models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DiariaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2() {
        $searchModel = new DiariaSearch();
        $query = new \yii\db\Query();
        $query = Diaria::find()->orderBy('data_ini DESC');
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Diaria model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'provider' => $this->provider($id),
        ]);
    }

    /**
     * Creates a new Diaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Diaria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iddiaria]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Diaria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iddiaria]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Diaria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Diaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Diaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Diaria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function provider($id) {
        $query = new \yii\db\Query();
        $query->select(['policial_diaria.idpolicial_diaria', 'policial.matricula',
                    'policial.nome', 'policial_diaria.executada', 'policial_diaria.justificada'])
                ->from('policial_diaria')
                ->where('policial_diaria.iddiaria = ' . $id)
                ->innerjoin('diaria', 'policial_diaria.iddiaria = diaria.iddiaria')
                ->innerjoin('policial', 'policial_diaria.idpolicial = policial.idpolicial');
        $provider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        return $provider;
    }

    public function actionVarias() {
        $model = new Diaria();
        $model3 = new \app\models\PolicialDiaria();
        if ($model->load(Yii::$app->request->post())) {
            $datas = explode(';', $model->data_ini);
            $diarias = [];
            foreach ($datas as $value) {
                $model2 = new Diaria();
                $model2->data_ini = $value;
                $model2->hora_ini = $model->hora_ini;
                $model2->data_fin = $value;
                $model2->hora_fin = $model->hora_fin;
                $model2->servico = $model->servico;
                $model2->local = $model->local;
                $model2->qtd_policiais = $model->qtd_policiais;
                $model2->extra = $model->extra;
                $model2->valor = $model->valor;
                $model2->save();
                array_push($diarias, $model2);
            }
            $diarias = \yii\helpers\ArrayHelper::map($diarias, 'iddiaria', 'data_ini');
            return $this->render('_formPoliciais', [
                        'model' => $model3,
                        'diarias' => $diarias,
                        'listarPoliciais' => $this->listarPoliciais(),
            ]);
        } else if ($model3->load(Yii::$app->request->post())) {
            foreach ($model3->iddiaria as $value1) {
                foreach ($model3->idpolicial as $valu2) {
                    $model4 = new \app\models\PolicialDiaria();
                    $model4->iddiaria = $value1;
                    $model4->idpolicial = $valu2;
                    $model4->save();
                    $searchModel = new DiariaSearch();
                    $query = new \yii\db\Query();
                    $query = Diaria::find()->orderBy('data_ini DESC');
                    $dataProvider = new \yii\data\ActiveDataProvider([
                        'query' => $query,
                    ]);
                }
            }
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('_formDiarias', [
                        'model' => $model,
            ]);
        }
    }

    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }

    public function actionPdiaria($id) {
        
        die();
        $query = new \yii\db\Query();
        $query->select(['matricula', 'nome', 'executada', 'justificada'])
                ->from('policial_diaria')
                ->where(['iddiaria' => $id])
                ->innerJoin('policial', 'policial_diaria.idpolicial = policial.idpolicial');
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('_formPDiaria', [
                    'provider' => $dataProvider,
        ]);
    }

}
