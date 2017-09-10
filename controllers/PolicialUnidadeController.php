<?php

namespace app\controllers;

use Yii;
use app\models\PolicialUnidade;
use app\models\PolicialUnidadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PolicialUnidadeController implements the CRUD actions for PolicialUnidade model.
 */
class PolicialUnidadeController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'punidade', 'index2'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PolicialUnidade models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialUnidadeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idunidade' => $id,
            ]);
        } else {
            $searchModel = new PolicialUnidadeSearch();
            $query = new \yii\db\Query();
            $query = PolicialUnidade::find()->where(['idunidade' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idunidade' => $id,
            ]);
        }
    }
    
    public function actionIndex2($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialUnidadeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idunidade' => $id,
            ]);
        } else {
            $searchModel = new PolicialUnidadeSearch();
            $query = new \yii\db\Query();
            $query = PolicialUnidade::find()->where(['idunidade' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idunidade' => $id,
            ]);
        }
    }

    /**
     * Displays a single PolicialUnidade model.
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
     * Creates a new PolicialUnidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PolicialUnidade();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_unidade]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listUnidade' => $this->listarUnidades(),
            ]);
        }
    }

    /**
     * Updates an existing PolicialUnidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_unidade]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listUnidade' => $this->listarUnidades(),
            ]);
        }
    }

    /**
     * Deletes an existing PolicialUnidade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idunidade = $this->findModel($id)->idunidade;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $idunidade]);
    }

    /**
     * Finds the PolicialUnidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PolicialUnidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PolicialUnidade::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPunidade($id) {
        $model = new \app\models\PolicialUnidade();
        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model->idpolicial);
            //die();
            foreach ($model->idpolicial as $value) {
                $model2 = new \app\models\PolicialUnidade();
                $model2->idunidade = $model->idunidade;
                $model2->idpolicial = $value;
                $model2->inicio = $model->inicio;
                $model2->fim = $model->fim;
                $model2->save();
            }
            return $this->redirect(['unidade/view', 'id' => $model->idunidade]);
        } else {
            $model->idunidade = $id;
            return $this->render('punidade', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listUnidade' => $this->listarUnidades2($id),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }
    
    private function listarUnidades() {
        $listUnidade = \app\models\UnidadeSearch::find()->all();
        $listUnidade = \yii\helpers\ArrayHelper::map($listUnidade, 'idunidade', 'nome');
        return $listUnidade;
    }
    
    private function listarUnidades2($id) {
        $listUnidade = \app\models\UnidadeSearch::find($id)->where(['idunidade' => $id])->all();
        $listUnidade = \yii\helpers\ArrayHelper::map($listUnidade, 'idunidade', 'nome');
        return $listUnidade;
    }
    
}
