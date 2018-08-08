<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use yii\mongodb\Query;
use yii\data\ActiveDataProvider;

class Work extends \yii\mongodb\ActiveRecord
{

    public $id;
    public $title;
    public $author;
    public $resume;
    public $type;
    public $date;
    public $id_creator;


    public static function collectionName()
    {
        return 'Obra';
    }

    public function rules()
    {
        return [
            [['title', 'author', 'type'], 'required'],
            [['title', 'author'], 'string', 'max'=>100],
            [['resume'], 'string', 'max'=>250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title'=> 'Title',
            'author'=> 'Author',
            'resume' => 'Resume',
            'type' => 'Type',  
            'date' => 'Date'          
        ];
    }

    public function attributes()
    {
         return [
             '_id',
         ];
    }

    public static function registerWork($title, $author, $resume, $type, $date)
    {
        $query = new Query();
        $response = $query->select(['id'])
            ->from('Obra')
            ->max('id');
        $response++;

        $values =[
            'id' => $response,
            'title' => $title,
            'author'=> $author,
            'resume' => $resume,
            'type' => (int)$type,
            'date' => $date,
            'id_creator' =>(int)Yii::$app->user->getIdentity()->getId(),
        ];
       
       $collection = Yii::$app->mongodb->getCollection('Obra');
       return $collection->insert($values);

    }


    public static function findWorkId($id)
    {
        return static::findOne(['id' =>$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public static function allWorks()
    {
        $data = new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => [
                'pageSize' => 20,
        ],
        ]);

        return $data;
    }


}
