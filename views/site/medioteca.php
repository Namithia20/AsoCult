<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Work */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$data_search="";

$this->title = 'Media Library';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-media-library">
    <h1><?= Html::encode($this->title) ?></h1>    

    <div class="work-searcher">
        <form action="<?php echo Url::to(['site/medioteca'])?>" id="search-form" class="input-group pull-right col-md-4" method="get">
            <select name="type" class="form-control">
                <option value="-1">All</option>
                <option value="0">Book</option>
                <option value="1">Music</option>
                <option value="2">Movie</option>
            </select>
            <span class="input-group-addon work-search-union" ></span>
            <input class="form-control" type="text" name="search" placeholder="Insert text...">  
            <input type="hidden" name="r" value="site/medioteca">
            <span class="input-group-btn">   
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-group', 'name' => 'search-button', 'value' => 'search-button']) ?> 
        </form>        
    </div>
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
                [
                    'label' => 'Type',
                    'format' => 'raw',
                    'value' => function($data){
                        
                        switch($data->type)
                        {
                            case 0: return 'Book';
                            case 1: return 'Music';
                            case 2: return 'Movie';
                            default: return 'Others';
                        }
                    }
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