    <?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
        'class' => 'backend\modules\api\ModuleAPI',
                ],
        ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/course',
                    'extraPatterns' => [
                        'GET search/{title}' => 'search',
                        'GET {id}' => 'course',
                        'GET courses'=> 'allcourses',
                        'POST createcourse'=> 'createcourse',
                        'PUT updatecourse/{title}'=> 'updatecoursepricebytitle',
                        'DELETE {title}'=> 'deletecoursebytitle',
                        'GET {id}/mycourses'=>'enrollment',
                        'GET {id}/hascourse/{course_id}'=> 'hascourse',
                        ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                        '{title}' => '<title:\w+>', //[a-zA-Z0-9_] 1 ou + vezes (char)
                        '{course_id}' => '<course_id:\d+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',],

                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/login',
                'extraPatterns' => [
                        'POST login' => 'login',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/lesson',
                    'extraPatterns' => [
                        'GET lessonsbycourse/{id}' => 'lessonsbycourse',
                        'GET {id}'=> 'lesson',
                        'GET {title}'=>'lessonbytitle',
                        'DELETE {title}'=> 'deletebytitle',
                        'PUT updatelesson/{title}'=> 'updatecontextbytitle',
                        'POST createlesson '=>'create',
                        ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                        '{title}' => '<title:\w+>',
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/cart',
                    'extraPatterns' => [
                        'GET {id}/course/{course_id}' => 'additem',
                        'GET {id}/items'=> 'items',
                        'DELETE {id}/course/{course_id}' => 'removeitem',
                        'POST createcart'=> 'createcart',
                        'GET payment/{id}'=> 'payment',
                        'GET {id}'=> 'cart',],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                        '{course_id}' => '<course_id:\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/order',
                    'extraPatterns' => [
                        'GET {id}/items'=> 'items',
                        'GET {id}'=>'order',
                        'GET allorders'=>'allorders',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                        '{course_id}' => '<course_id:\d+>',
                    ],
                ],

            ],
        ],


    ],
    'params' => $params,
];
