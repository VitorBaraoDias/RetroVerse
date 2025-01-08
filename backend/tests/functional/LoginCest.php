<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function loginTestValido(FunctionalTester $I)
    {
        $I->wantTo('log in as a registered user');

        $I->amOnPage(['/site/login']);

        $I->fillField('input[name="LoginForm[username]"]', 'erau');

        $I->fillField('input[name="LoginForm[password]"]', 'password_0');

        $I->click('Sign In');

        $I->see('Logout');
        $I->seeInCurrentUrl('/admin');
    }
}
