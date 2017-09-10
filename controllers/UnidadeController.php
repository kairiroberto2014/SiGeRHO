<?php

namespace app\controllers;

use Yii;
use app\models\Unidade;
use app\models\UnidadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * UnidadeController implements the CRUD actions for Unidade model.
 */
class UnidadeController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'punidade'],
                        'roles' => ['crudSecretario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Unidade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnidadeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unidade model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*
        SELECT *
        FROM POLICIAL, POLICIAL_UNIDADE, UNIDADE
        WHERE POLICIAL.IDPOLICIAL = POLICIAL_UNIDADE.IDPOLICIAL
        AND UNIDADE.IDUNIDADE = POLICIAL_UNIDADE.IDUNIDADE
        AND UNIDADE.IDUNIDADE = 1
        AND POLICIAL_UNIDADE.FIM IS NULL
         */
        
        $query1 = new \yii\db\Query();
        $query1->select('policial.idpolicial, policial.nome, policial.cpf, policial.matricula, '
                . 'policial_unidade.inicio, policial_unidade.fim')
                ->from('policial_unidade')                
                ->where('policial_unidade.fim <> ""')
                ->innerjoin('policial', 'policial.idpolicial = policial_unidade.idpolicial')
                ->where('policial_unidade.idunidade=' . $id)
                ->orderBy('policial_unidade.fim ASC, policial_unidade.inicio ASC, policial.nome ASC');
        $provider1 = new ActiveDataProvider([
            'query' => $query1,           
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'provider1' => $provider1,
        ]);
    }

    /**
     * Creates a new Unidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unidade();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idunidade]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Unidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idunidade]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Unidade model.
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
     * Finds the Unidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Unidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unidade::findOne($id)) !== null) {
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
    
}
