<?php

namespace app\controllers;

use Yii;
use app\models\PolicialDiaria;
use app\models\PolicialDiariaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PolicialDiariaController implements the CRUD actions for PolicialDiaria model.
 */
class PolicialDiariaController extends Controller {

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
                        'actions' => ['create', 'update', 'delete', 'pdiaria'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PolicialDiaria models.
     * @return mixed
     */
    public function actionIndex($id) {
        if (!isset($id)) {
            $searchModel = new PolicialDiariaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'iddiaria' => $id,
            ]);
        } else {
            $searchModel = new PolicialDiariaSearch();
            $query = new \yii\db\Query();
            $query = PolicialDiaria::find()->where(['iddiaria' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'iddiaria' => $id,
            ]);
        }
    }

    public function actionIndex2($id) {
        if (!isset($id)) {
            $searchModel = new PolicialDiariaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'iddiaria' => $id,
            ]);
        } else {
            $searchModel = new PolicialDiariaSearch();
            $query = new \yii\db\Query();
            $query = PolicialDiaria::find()->where(['iddiaria' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'iddiaria' => $id,
            ]);
        }
    }

    /**
     * Displays a single PolicialDiaria model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PolicialDiaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PolicialDiaria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_diaria]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listDiaria' => $this->listarDiarias(),
            ]);
        }
    }

    /**
     * Updates an existing PolicialDiaria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $this->findModel($id)->iddiaria]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listDiaria' => $this->listarDiarias(),
            ]);
        }
    }

    /**
     * Deletes an existing PolicialDiaria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $iddiria = $this->findModel($id)->iddiaria;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $iddiria]);
    }

    /**
     * Finds the PolicialDiaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PolicialDiaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PolicialDiaria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }

    private function listarDiarias() {
        $listDiaria = \app\models\DiariaSearch::find()->all();
        $listDiaria = \yii\helpers\ArrayHelper::map($listDiaria, 'iddiaria', 'data_ini', 'servico', 'servico');
        return $listDiaria;
    }

    public function actionPdiaria($id) {
        $model = new PolicialDiaria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['diaria/view', 'id' => $model->iddiaria]);
        } else {
            $model->iddiaria = $id;
            return $this->render('pdiaria', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
            ]);
        }
    }

}
