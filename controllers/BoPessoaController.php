<?php

namespace app\controllers;

use Yii;
use app\models\BoPessoa;
use app\models\BoPessoaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BoPessoaController implements the CRUD actions for BoPessoa model.
 */
class BoPessoaController extends Controller {

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
                        'actions' => ['create', 'update', 'delete', 'bopessoa'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BoPessoa models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BoPessoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoPessoa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BoPessoa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BoPessoa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idbo_pessoa]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'listPessoa' => $this->listarPessoas(),
                        'listPessoaTipo' => $this->listarPessoaTipo(),
                        'listBo' => $this->listarBo(),
            ]);
        }
    }

    /**
     * Updates an existing BoPessoa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idbo_pessoa]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'listPessoa' => $this->listarPessoas(),
                        'listPessoaTipo' => $this->listarPessoaTipo(),
                        'listBo' => $this->listarBo(),
            ]);
        }
    }

    /**
     * Deletes an existing BoPessoa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BoPessoa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BoPessoa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BoPessoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBopessoa($id) {
        $model = new BoPessoa();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bo/view', 'id' => $model->idbo]);
        } else {
            $model->idbo = $id;
            return $this->render('bopessoa', [
                        'model' => $model,
                        'listPessoa' => $this->listarPessoas(),
                        'listPessoaTipo' => $this->listarPessoaTipo(),
            ]);
        }
    }

    private function listarPessoas() {
        $listPessoa = \app\models\PessoaSearch::find()->all();
        $listPessoa = \yii\helpers\ArrayHelper::map($listPessoa, 'idpessoa', 'nome');
        return $listPessoa;
    }

    private function listarPessoaTipo() {
        $listPessoaTipo = \app\models\PessoaTipoSearch::find()->all();
        $listPessoaTipo = \yii\helpers\ArrayHelper::map($listPessoaTipo, 'idpessoa_tipo', 'nome');
        return $listPessoaTipo;
    }

    private function listarBo() {
        $listBo = \app\models\BoSearch::find()->all();
        $listBo = \yii\helpers\ArrayHelper::map($listBo, 'idbo', 'descricao', 'data');
        return $listBo;
    }

}
