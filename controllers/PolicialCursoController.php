<?php

namespace app\controllers;

use Yii;
use app\models\PolicialCurso;
use app\models\PolicialCursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PolicialCursoController implements the CRUD actions for PolicialCurso model.
 */
class PolicialCursoController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'pcurso', 'index2'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PolicialCurso models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialCursoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcurso' => $id,
            ]);
        } else {
            $searchModel = new PolicialCursoSearch();
            $query = new \yii\db\Query();
            $query = PolicialCurso::find()->where(['idcurso' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcurso' => $id,
            ]);
        }
    }
    
    public function actionIndex2($id)
    {
        if (!isset($id)) {
            $searchModel = new PolicialCursoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcurso' => $id,
            ]);
        } else {
            $searchModel = new PolicialCursoSearch();
            $query = new \yii\db\Query();
            $query = PolicialCurso::find()->where(['idcurso' => $id]);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('index2', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'idcurso' => $id,
            ]);
        }
    }

    /**
     * Displays a single PolicialCurso model.
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
     * Creates a new PolicialCurso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PolicialCurso();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_curso]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listCurso' => $this->listarCursos(),
            ]);
        }
    }

    /**
     * Updates an existing PolicialCurso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpolicial_curso]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicial' => $this->listarPoliciais(),
                'listCurso' => $this->listarCursos(),
            ]);
        }
    }

    /**
     * Deletes an existing PolicialCurso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idcurso = $this->findModel($id)->idcurso;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $idcurso]);
    }

    /**
     * Finds the PolicialCurso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PolicialCurso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PolicialCurso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPcurso($id) {
        $model = new \app\models\PolicialCurso;
        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model->idpolicial);
            //die();
            foreach ($model->idpolicial as $value) {
                $model2 = new \app\models\PolicialCurso;
                $model2->idcurso = $model->idcurso;
                $model2->idpolicial = $value;
                $model2->instituicao = $model->instituicao;
                $model2->inicio = $model->inicio;
                $model2->fim = $model->fim;
                $model2->horas = $model->horas;
                $model2->save();
            }
            return $this->redirect(['curso/view', 'id' => $model->idcurso]);
        } else {
            $model->idcurso = $id;
            return $this->render('pcurso', [
                        'model' => $model,
                        'listPolicial' => $this->listarPoliciais(),
                        'listCurso' => $this->listarCursos2($id),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicial = \app\models\PolicialSearch::find()->all();
        $listPolicial = \yii\helpers\ArrayHelper::map($listPolicial, 'idpolicial', 'nome');
        return $listPolicial;
    }
    
    private function listarCursos() {
        $listCurso = \app\models\CursoSearch::find()->all();
        $listCurso = \yii\helpers\ArrayHelper::map($listCurso, 'idcurso', 'nome');
        return $listCurso;
    }
    
    private function listarCursos2($id) {
        $listCurso = \app\models\CursoSearch::find()->where(['idcurso' => $id])->all();
        $listCurso = \yii\helpers\ArrayHelper::map($listCurso, 'idcurso', 'nome');
        return $listCurso;
    }
    
}
