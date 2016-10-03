<?php

namespace app\components\helpers;

class KladrHelper
{
    public static function get($query)
    {
        if(empty($query)) {
            return false;
        }

        $kladrApi = new \Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');

        $kladrQuery = new \Kladr\Query();
        $kladrQuery->ContentName = $query;
        $kladrQuery->OneString = true;
        $kladrQuery->Limit = 5;

        $arResult = $kladrApi->QueryToArray($kladrQuery);

        return $arResult;
    }
}