<?php

namespace app\controllers;

use Yii;
use app\models\BoPolicial;
use app\models\BoPolicialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BoPolicialController implements the CRUD actions for BoPolicial model.
 */
class BoPolicialController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'bopolicia'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BoPolicial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoPolicialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoPolicial model.
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
     * Creates a new BoPolicial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BoPolicial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idbo_policial]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listPolicia' => $this->listarPoliciais(),
                'listBo' => $this->listarBo(),
            ]);
        }
    }

    /**
     * Updates an existing BoPolicial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idbo_policial]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listPolicia' => $this->listarPoliciais(),
                'listBo' => $this->listarBo(),
            ]);
        }
    }

    /**
     * Deletes an existing BoPolicial model.
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
     * Finds the BoPolicial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BoPolicial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoPolicial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionBopolicia($id) {
        $model = new BoPolicial();        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bo/view', 'id' => $model->idbo]);
        } else {
            $model->idbo = $id;
            return $this->render('bopolicia', [
                    'model' => $model,
                    'listPolicia' => $this->listarPoliciais(),
            ]);
        }
    }
    
    private function listarPoliciais() {
        $listPolicia = \app\models\PolicialSearch::find()->all();
        $listPolicia = \yii\helpers\ArrayHelper::map($listPolicia, 'idpolicial', 'nome');
        return $listPolicia;
    }
    
    private function listarBo() {
        $listBo = \app\models\BoSearch::find()->all();
        $listBo = \yii\helpers\ArrayHelper::map($listBo, 'idbo', 'descricao', 'data');
        return $listBo;
    }
    
}
