<?php

return [
    'id' => 'app-console',
    'class' => 'yii\console\Application',
    'basePath' => \Yii::getAlias('@tests'),
    'runtimePath' => \Yii::getAlias('@tests/_output'),
    'bootstrap' => [],
    'components' => [
        'imagable' => [
            'class' => 'ymaker\imagable\Imagable',
            'imagesPath' => '@tests/_data/images',
            'imageClass' => 'ymaker\imagable\instances\CreateImageImagine',
        ],
        'db' => [
            'class' => '\yii\db\Connection',
            'dsn' => 'sqlite:' . \Yii::getAlias('@tests/_output/temp.db'),
            'username' => '',
            'password' => '',
        ]
    ]
];
