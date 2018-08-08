<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\ */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Media Library';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-media-library">
    <h1><?= Html::encode($this->title) ?></h1>    
    <div class="work-data-container">
    <?php 
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>[
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Title', 
                    'value' => function($data){
                        return $data->title;
                    },
                ],
            ],
        ]);
    ?>
    </div>

</div>
