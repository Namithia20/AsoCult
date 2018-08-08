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
    public $date_public;
    public $id_creator;


    public static function collectionName()
    {
        return 'Obra';
    }

    public function rules()
    {
        return [
            [['title', 'author', 'type'], 'required'],
            [['title', 'author', 'date_public'], 'string', 'max'=>100],
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
            'date_public' => 'Date'          
        ];
    }

    public function attributes()
    {
         return [
             '_id',
         ];
    }

    public function registerWork()
    {
        $query = new Query();
        $response = $query->select(['id'])
            ->from('Obra')
            ->max('id');
        $response++;

        $values =[
            'id' => $response,
            'title' => $this->title,
            'author'=> $this->author,
            'resume' => $this->resume,
            'type' => (int)$this->type,
            'date_public' => $this->date_public,
            'id_creator' =>(int)Yii::$app->user->getIdentity()->getId(),
        ];
      var_dump($values);
       $collection = Yii::$app->mongodb->getCollection('Obra');
       return $collection->insert($values);

    }


    public static function findWorkId($id)
    {
        return static::findOne(['id' =>(int)$id]);
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

    public static function allWorksFilter($title, $type)
    {

        $query = static::find();

        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
        ],
        ]);
        
        if((int)$type!=-1)
        {

            $query->where(['type'=> (int)$type]);
            $query->andWhere(['like', 'title', $title]);
            
        }
        else
        {
            $query->where(['like', 'title', $title]);
        }

        return $data;
    }

}
