<?php

namespace springdev\yii2\oauth2mysqlserver\traits;

trait ClassNamespace
{
    public static function className()
    {
        return get_called_class();
    }
}