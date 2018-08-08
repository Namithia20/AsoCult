<?php

/* @var $this yii\web\View */
/* @var $model app\models\Work */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Work Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-work-details">
    <h1><?= Html::encode($this->title) ?></h1>    
    <div class="work-data-container">
        <h2><?= Html::encode($model->title) ?></h2>
        <div class="section-data">
            <div class="work-data">
                <h3>Author: </h3> <?= Html::encode($model->author) ?>
            </div>
            <div class="work-data">
                <h3>Publication date: </h3> <?= Html::encode($model->date_public) ?>
            </div>  
            <div class="work-data">
                <h3>Type: </h3> 
                <?php 
                    switch($model->type)
                    {
                        case 0: echo Html::encode('Book'); break;
                        case 1: echo Html::encode('Music'); break;
                        case 2: echo Html::encode('Movie'); break;
                        default: echo Html::encode('Others'); break;
                    }
                ?>
            </div>  
            <div>
                <h3>Resume: </h3> <?= Html::encode($model->resume) ?>
            </div>  
        </div>        
    </div>
    <div>
        <?= Html::button('Back to Media Library', ['class'=>'btn btn-primary', 'onclick' =>'backLibrary()'])?>           
    </div> 
</div>
<script>
function backLibrary()
{
    window.location.href='<?= Url::to(['site/medioteca'])?>';     
}
</script>
