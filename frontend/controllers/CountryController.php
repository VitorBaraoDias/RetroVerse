<?php

namespace frontend\controllers;

use common\models\LocationHelper;

class CountryController
{
    public function actionGetCities($countryCode)
    {
        $cities = LocationHelper::getCitiesByCountry($countryCode);
        return $this->asJson($cities);
    }
}