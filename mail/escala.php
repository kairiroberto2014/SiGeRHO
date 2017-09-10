<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

?>

<div class="policial-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
        <?= Html::a(Yii::t('app', 'Voltar'), ['view', 'id' => $model->idpolicial], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idpolicial',
            'nome',
            'cpf',
            'matricula',
            'email',
            'admissao',
        ],
    ]) ?>
      
    <h1>Escala</h1>
        
    <?= GridView::widget([
        'dataProvider' => $provider1,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'data_ini',
            'local',
            'servico',
    
        ],
    ]); ?>
    
    
</div>
