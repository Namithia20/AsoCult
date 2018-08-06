<?php

return [
    'class' => 'yii\mongodb\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',    
    'options' => [
        "username" => "yii2",
        "password" => "yii2pass"
    ]
    

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
