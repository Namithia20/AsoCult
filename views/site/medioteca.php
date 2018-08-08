<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Work */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Media Library';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-media-library">
    <h1><?= Html::encode($this->title) ?></h1>    
    <div>
    <?php
        if(!Yii::$app->user->isGuest)
        {
            echo Html::button('Add New', ['class'=>'btn btn-primary', 'onclick' =>'addWork()']);
        }
     ?>
    </div>
    <div class="work-data-container">
    <?php 
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>[
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Title',
                    'format' => 'raw', 
                    'value' => function($data){
                        return Html::a($data->title, ['site/workview', 'id'=>$data->id]);
                    },
                ],
            ],
        ]);
    ?>
    </div>

</div>
<script>
function addWork()
{
     window.location.href='<?php echo Url::to(['site/newwork'])?>';  
}
</script>