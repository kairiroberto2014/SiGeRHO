<?php

namespace app\controllers;

use Yii;
use app\models\Praca;
use app\models\PracaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PracaController implements the CRUD actions for Praca model.
 */
class PracaController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'ppraca', 'index2'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Praca models.
     * @return mixed
     */
    public function actionIndex2($id)
    {
        if (!isset($id)) {
            $searchModel = new PracaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        } else {
            $searchModel = new PracaSearch();
            $query = new \yii\db\Query();
            $query = Praca::find()->where(['idgraduacao' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        }
    }
    
    public function actionIndex($id)
    {
        if (!isset($id)) {
            $searchModel = new PracaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        } else {
            $searchModel = new PracaSearch();
            $query = new \yii\db\Query();
            $query = Praca::find()->where(['idgraduacao' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        }
    }

    /**
     * Displays a single Praca model.
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
     * Creates a new Praca model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Praca();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpraca]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listGraduacao' => $this->listarGraduacao(),
            ]);
        }
    }

    /**
     * Updates an existing Praca model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpraca]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listGraduacao' => $this->listarGraduacao(),
            ]);
        }
    }

    /**
     * Deletes an existing Praca model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idgraduacao = $this->findModel($id)->idgraduacao;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $idgraduacao]);
    }

    /**
     * Finds the Praca model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Praca the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Praca::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPpraca($id) {
        $model = new \app\models\Praca();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['graduacao/view', 'id' => $model->idgraduacao]);
        } else {
            $model->idgraduacao = $id;
            return $this->render('ppraca', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listGraduacao' => $this->listarGraduacao2($id),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }
    
    private function listarGraduacao() {
        $listGraduacao = \app\models\GraduacaoSearch::find()->all();
        $listGraduacao = \yii\helpers\ArrayHelper::map($listGraduacao, 'idgraduacao', 'nome_graduacao');
        return $listGraduacao;
    }
    
    private function listarGraduacao2($id) {
        $listGraduacao = \app\models\GraduacaoSearch::find($id)->where(['idgraduacao' => $id])->all();
        $listGraduacao = \yii\helpers\ArrayHelper::map($listGraduacao, 'idgraduacao', 'nome_graduacao');
        return $listGraduacao;
    }
    
    public function indexar($id) {
        if (!isset($id)) {
            $searchModel = new PracaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        } else {
            $searchModel = new PracaSearch();
            $query = new \yii\db\Query();
            $query = Praca::find()->where(['idgraduacao' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idgraduacao' => $id,
            ]);
        }
    }
    
}
