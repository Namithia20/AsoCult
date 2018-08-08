<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'New Work';
$this->params['breadcrumbs'][] = ['label'=>'Media Library', 'url'=> Url::to(['site/medioteca']) ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-form-work">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'work-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'author')->textInput() ?>

        <?= $form->field($model, 'resume')->textArea(['rows' => '6']) ?>

        <?= $form->field($model, 'type')->dropDownList(['0'=>'Book', '1'=>'Music', '2'=>'Movie']) ?>

        <?= $form->field($model, 'date_public')->textInput() ?>
        
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button', 'value'=>'create-button']) ?>
                <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'cancel()']) ?>
            </div>
            
        </div>

    <?php ActiveForm::end(); ?>
    
</div>
<script>
function cancel()
{
    window.location.href='<?= Url::to(['site/medioteca'])?>';     
}
</script>