<?php

namespace app\controllers;

use Yii;
use app\models\PolicialCargo;
use app\models\PolicialCargoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PolicialCargoController implements the CRUD actions for PolicialCargo model.
 */
class PolicialCargoController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'pcargo', 'index2'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PolicialCargo models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialCargoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcargo' => $id,
            ]);
        } else {
            $searchModel = new PolicialCargoSearch();
            $query = new \yii\db\Query();
            $query = PolicialCargo::find()->where(['idcargo' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcargo' => $id,
            ]);
        }
    }
    
    public function actionIndex2($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialCargoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcargo' => $id,
            ]);
        } else {
            $searchModel = new PolicialCargoSearch();
            $query = new \yii\db\Query();
            $query = PolicialCargo::find()->where(['idcargo' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcargo' => $id,
            ]);
        }
    }

    /**
     * Displays a single PolicialCargo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PolicialCargo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PolicialCargo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_cargo]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listCargo' => $this->listarCargos(),
            ]);
        }
    }

    /**
     * Updates an existing PolicialCargo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_cargo]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listCargo' => $this->listarCargos(),
            ]);
        }
    }

    /**
     * Deletes an existing PolicialCargo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idcargo = $this->findModel($id)->idcargo;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $idcargo]);
    }

    /**
     * Finds the PolicialCargo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PolicialCargo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PolicialCargo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPcargo($id) {
        $model = new \app\models\PolicialCargo();
        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->idpolicial as $value) {
                $model2 = new PolicialCargo();
                $model2->idcargo = $model->idcargo;
                $model2->idpolicial = $value;
                $model2->inicio = $model->inicio;
                $model2->fim = $model->fim;
                $model2->save();
            }
            return $this->redirect(['cargo/view', 'id' => $model->idcargo]);
        } else {
            $model->idcargo = $id;
            return $this->render('pcargo', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listCargo' => $this->listarCargos2($id),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }
    
    private function listarCargos() {
        $listCargo = \app\models\CargoSearch::find()->all();
        $listCargo = \yii\helpers\ArrayHelper::map($listCargo, 'idcargo', 'nome');
        return $listCargo;
    }
    
    private function listarCargos2($id) {
        $listCargo = \app\models\CargoSearch::find()->where(['idcargo' => $id])->all();
        $listCargo = \yii\helpers\ArrayHelper::map($listCargo, 'idcargo', 'nome');
        return $listCargo;
    }
    
}
