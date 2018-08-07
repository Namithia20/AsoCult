<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\User */
/**/

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Administration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-administration">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Admin panel:
    </p>
    <p>
    <?php 
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>[
                //['class' => 'yii\grid\SerialColumn'],
                'id',
                'username',
                [
                    'label' => 'State', 
                    'value' =>function ($data){
                        if($data->bloqueado)
                            {return 'Lock';}
                            else
                            {return 'Unlock';}
                    },
                ],
                [         
                    'label' => 'Actions', 
                    'format' => 'raw',                   
                    'value' => function ($data){

                        if($data != Yii::$app->user->getIdentity())
                        {
                            if($data->bloqueado)
                            {return Html::button('Unlock', ['class'=>'btn btn-primary', 'onclick' =>'lockUnlockUser("unlockUser", '.$data->id.')']);}
                            else
                            {return Html::button('Lock', ['class'=>'btn btn-primary', 'onclick' =>'lockUnlockUser("lockUser", '.$data->id.')']);}
                        }
                        else
                        { return 'No action';}
                        
                    },
                ],
            ],
        ]);
    ?>
    </p>

</div>

<script>
function lockUnlockUser(action, idusuario)
{
    $.post(window.location.href,{accion:action, id:idusuario});
}
</script>