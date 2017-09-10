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
    
    <table class="table table-striped table-bordered dettail-view">
        <tr>
            <td><b>Expedientes</b></td>
            <td><?= $expedientes ?></td>
        </tr>
        <tr>
            <td><b>Expedientes cumpridos</b></td>
            <td><?= $cumpridos ?></td>
        </tr>
        <tr>
            <td><b>Expedientes justificados</b></td>
            <td><?= $justificados ?></td>
        </tr>
        <tr>
            <td><b>Ocorrências</b></td>
            <td><?= $ocorrencias ?></td>
        </tr>
    </table>
      
    <h1>Ocorrências</h1>
        
    <?= GridView::widget([
        'dataProvider' => $provider1,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //'nome',
            'crime',
            'atendimento',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <h1>Unidades</h1>
        
    <?= GridView::widget([
        'dataProvider' => $provider2,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idpolicial_unidade',
            //'idpolicial',
            'idunidade',
            'idunidade0.nome',
            'inicio',
            'fim',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <h1>Cargos</h1>
    
    <?= GridView::widget([
        'dataProvider' => $provider3,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //'idpolicial_cargo',
            //'idpolicial',
            'idcargo',
            'idcargo0.nome',
            'inicio',
            'fim',
            
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <h1>Cursos</h1>
    
    <?= GridView::widget([
        'dataProvider' => $provider4,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //'idpolicial_cargo',
            //'idpolicial',
            'idcurso',
            'idcurso0.nome',
            'instituicao',
            'inicio',
            'fim',
            'horas',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <h1>Posto</h1>
    
    <?= GridView::widget([
        'dataProvider' => $provider5,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'idposto',
            'idposto0.nome_posto',
            'inicio',
            'fim',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <h1>Praça</h1>
    
    <?= GridView::widget([
        'dataProvider' => $provider6,
        //'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'idgraduacao',
            'idgraduacao0.nome_graduacao',
            'inicio',
            'fim',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>