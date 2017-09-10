<?php

namespace app\controllers;

use Yii;
use app\models\Bo;
use app\models\BoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * BoController implements the CRUD actions for Bo model.
 */
class BoController extends Controller {

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
     * Lists all Bo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'provider1' => $this->provider1($id),
                    'provider2' => $this->provider2($id),
                    'provider3' => $this->provider3($id),
        ]);
    }

    /**
     * Creates a new Bo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Bo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->idbo]);
            return $this->render('view', [
                        'model' => $model,
                        'provider1' => $this->provider1($model->idbo),
                        'provider2' => $this->provider2($model->idbo),
                        'provider3' => $this->provider3($model->idbo),
            ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                        'id' => $model->idbo,
                        'model' => $model,
                        'provider1' => $this->provider1($id),
                        'provider2' => $this->provider2($id),
                        'provider3' => $this->provider3($id),
            ]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Bo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBopessoa($id) {
        $pessoa = new \app\models\Pessoa();
        $bo = new Bo();
        $bo_pessoa = new \app\models\BoPessoa();       
        if ($pessoa->load(Yii::$app->request->post())) {
            if ($bo_pessoa->load(Yii::$app->request->post()) && $pessoa->save()) {
                $bo_pessoa->idbo = $id;
                $bo_pessoa->idpessoa = $pessoa->idpessoa;
                if ($bo_pessoa->save()) {
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
        } else {
            return $this->render('bopessoa', [
                        'id' => $id,
                        'bo_pessoa' => $bo_pessoa,
                        'pessoa' => $pessoa,
                        'bo' => $this->findModel($id),
                        'listPessoaTipo' => $this->listarPessoaTipo(),
            ]);
        }
    }

    private function listarCrimes() {
        $listCrime = \app\models\CrimeSearch::find()->all();
        $listCrime = \yii\helpers\ArrayHelper::map($listCrime, 'idcrime', 'artigo');
        return $listCrime;
    }

    private function listarPessoaTipo() {
        $listPessoaTipo = \app\models\PessoaTipoSearch::find()->all();
        $listPessoaTipo = \yii\helpers\ArrayHelper::map($listPessoaTipo, 'idpessoa_tipo', 'nome');
        return $listPessoaTipo;
    }

    private function provider1($id) {
        $query1 = new \yii\db\Query();
        $query1->select(['crime.nome', 'crime.artigo', 'crime.lei'])
                ->from('bo_crime')
                ->innerjoin('crime', 'bo_crime.idcrime = crime.idcrime')
                ->where('bo_crime.idbo = ' . $id);
        $provider1 = new ActiveDataProvider([
            'query' => $query1,
        ]);
        return $provider1;
    }

    private function provider2($id) {
        $query2 = new \yii\db\Query();
        $query2->select('pessoa.nome, pessoa.nascimento, pessoa.rg, pessoa.cpf, pessoa.telefone, pessoa.endereco, pessoa_tipo.nome AS tipo')
                ->from('bo_pessoa')
                ->innerjoin('pessoa', 'bo_pessoa.idpessoa = pessoa.idpessoa')
                ->innerjoin('pessoa_tipo', 'bo_pessoa.idpessoa_tipo = pessoa_tipo.idpessoa_tipo')
                ->where('bo_pessoa.idbo = ' . $id);
        $provider2 = new ActiveDataProvider([
            'query' => $query2,
        ]);
        return $provider2;
    }

    private function provider3($id) {
        $query3 = new \yii\db\Query();
        $query3->select('policial.nome, policial.matricula, bo_policial.cmt')
                ->from('bo_policial')
                ->innerjoin('policial', 'bo_policial.idpolicial = policial.idpolicial')
                ->where('bo_policial.idbo = ' . $id);
        $provider3 = new ActiveDataProvider([
            'query' => $query3,
        ]);
        return $provider3;
    }

}
