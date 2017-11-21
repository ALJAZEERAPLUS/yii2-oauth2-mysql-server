<?php

namespace springdev\yii2\oauth2mysqlserver;

use yii\web\GroupUrlRule;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @var array Model's map
     */
    private $_modelMap = [
        'OauthClients'               => 'springdev\yii2\oauth2mysqlserver\models\OauthClients',
        'OauthAccessTokens'          => 'springdev\yii2\oauth2mysqlserver\models\OauthAccessTokens',
        'OauthAuthorizationCodes'    => 'springdev\yii2\oauth2mysqlserver\models\OauthAuthorizationCodes',
        'OauthRefreshTokens'         => 'springdev\yii2\oauth2mysqlserver\models\OauthRefreshTokens',
        'OauthScopes'                => 'springdev\yii2\oauth2mysqlserver\models\OauthScopes',
    ];
    
    /**
     * @var array Storage's map
     */
    private $_storageMap = [
        'access_token'          => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'authorization_code'    => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'client_credentials'    => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'client'                => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'refresh_token'         => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'user_credentials'      => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'public_key'            => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'jwt_bearer'            => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
        'scope'                 => 'springdev\yii2\oauth2mysqlserver\storage\Pdo',
    ];
    
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        /** @var $module Module */
        if ($app->hasModule('oauth2') && ($module = $app->getModule('oauth2')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                \Yii::$container->set("springdev\\yii2\\oauth2server\\models\\" . $name, $definition);
                $module->modelMap[$name] = is_array($definition) ? $definition['class'] : $definition;
            }
            
            $this->_storageMap = array_merge($this->_storageMap, $module->storageMap);
            foreach ($this->_storageMap as $name => $definition) {
                \Yii::$container->set($name, $definition);
                $module->storageMap[$name] = is_array($definition) ? $definition['class'] : $definition;
            }
            
            if ($app instanceof \yii\console\Application) {
                $module->controllerNamespace = 'springdev\yii2\oauth2server\commands';
            }
        }
    }
}