<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-profile">
    <h1><?= Html::encode($this->title) ?></h1>    
    <div class="user-data-container">
        <h2>Personal Data</h2>
        <div class="section-data">
            <div class="user-personal-data">
                <h3>Username: </h3> <?= Html::encode(Yii::$app->user->getIdentity()->username) ?>
            </div>
            <div class="user-personal-data">
                <h3>Email: </h3> <?= Html::encode(Yii::$app->user->getIdentity()->email) ?>
            </div>   
        </div>         
        <h2>Actions</h2>
        <div class="section-data">
            <?= Html::button('Delete user', ['class'=>'btn btn-primary', 'onclick' =>'deleteUser("delete", '.Yii::$app->user->getIdentity()->id.')'])?>
           
        </div>
    </div>

</div>

<script>
function deleteUser(action, idusuario)
{
    if(confirm("If delete the user, you can't login again. Are you sure?"))
    { $.post(window.location.href,{accion:action, id:idusuario});}   
}
</script>