<?php

namespace app\controllers;

use Yii;
use app\models\Oficial;
use app\models\OficialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OficialController implements the CRUD actions for Oficial model.
 */
class OficialController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'poficial', 'index2'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Oficial models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (!isset($id)) {
            $searchModel = new OficialSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        } else {
            $searchModel = new OficialSearch();
            $query = new \yii\db\Query();
            $query = Oficial::find()->where(['idposto' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        }
    }
    
    public function actionIndex2($id)
    {
        if (!isset($id)) {
            $searchModel = new OficialSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        } else {
            $searchModel = new OficialSearch();
            $query = new \yii\db\Query();
            $query = Oficial::find()->where(['idposto' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        }
    }

    /**
     * Displays a single Oficial model.
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
     * Creates a new Oficial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Oficial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idoficial]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listPosto' => $this->listarPosto(),
            ]);
        }
    }

    /**
     * Updates an existing Oficial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idoficial]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listPosto' => $this->listarPosto(),
            ]);
        }
    }

    /**
     * Deletes an existing Oficial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idposto = $this->findModel($id)->idposto;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $idposto]);
    }

    /**
     * Finds the Oficial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Oficial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Oficial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPoficial($id) {
        $model = new \app\models\Oficial();
        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model->idpolicial);
            //die();
            foreach ($model->idpolicial as $value) {
                $model2 = new \app\models\Oficial();
                $model2->idposto = $model->idposto;
                $model2->idpolicial = $value;
                $model2->inicio = $model->inicio;
                $model2->fim = $model->fim;
                $model2->save();
            }
            return $this->redirect(['posto/view', 'id' => $model->idposto]);
        } else {
            $model->idposto = $id;
            return $this->render('poficial', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listPosto' => $this->listarPosto2($id),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }
    
    private function listarPosto() {
        $listPosto = \app\models\PostoSearch::find()->all();
        $listPosto = \yii\helpers\ArrayHelper::map($listPosto, 'idposto', 'nome_posto');
        return $listPosto;
    }
    
    private function listarPosto2($id) {
        $listPosto = \app\models\PostoSearch::find($id)->where(['idposto' => $id])->all();
        $listPosto = \yii\helpers\ArrayHelper::map($listPosto, 'idposto', 'nome_posto');
        return $listPosto;
    }
    
    private function indexar($id) {
        if (!isset($id)) {
            $searchModel = new OficialSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        } else {
            $searchModel = new OficialSearch();
            $query = new \yii\db\Query();
            $query = Oficial::find()->where(['idposto' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idposto' => $id,
            ]);
        }
    }
    
}
