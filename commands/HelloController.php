<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }
    
    public function actionPermissoes() {
        $auth = Yii::$app->authManager;
        
        //CRUD DE COMANDANTE
        $crudComandante = $auth->createPermission('crudComandante');
        $crudComandante->description = 'CRUD de Comandante';
        $auth->add($crudComandante);
        
        //CRUD DE SECRETARIO
        $crudSecretario = $auth->createPermission('crudSecretario');
        $crudSecretario->description = 'CRUD de Secretario';
        $auth->add($crudSecretario);
        
        //PAPEL DE COMANDANTE
        $comandante = $auth->createRole('comandante');
        $auth->add($comandante);
        $auth->addChild($comandante, $crudComandante);
        
        //CRIANDO O PAPEL GERENTE
        $secretario = $auth->createRole('secretario');
        $auth->add($secretario);
        $auth->addChild($secretario, $crudSecretario);
                
        //CRIANDO O PAPEL ADMIN
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $secretario);
        
    }
    
}
