<?php


namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;

class LoginBackendCest
{

    public function _before(FunctionalTester $I)
    {
        //utilizador admin
        $I->haveRecord(User::class, [
            'username' => 'adminteste',
            'password_hash' => '$2y$13$8JjwEMIRiHXD5Y9qdRn0kePh05UqMIrs8ML.4lXKvu5SQXnbHrUOG',
            'email' => 'adminteste@gmail.com',
            'auth_key' => 'khhkhk',
            'status' => 10
        ]);

        $auth = \Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        $adminId = $I->grabRecord(User::class, ['username' => 'adminteste'])->id;
        $auth->assign($adminRole, $adminId);

        //utilizador com role utilizador
        $I->haveRecord(User::class,[
            'username' => 'membroteste',
            'password_hash' => \Yii::$app->security->generatePasswordHash('12345678'),
            'email' => 'membroteste@gmail.com',
            'auth_key' => 'khhkhk',

            'status' => 10,
        ]);

        $auth = \Yii::$app->authManager;
        $role = $auth->getRole('membro');
        $userId = $I->grabRecord(User::class, ['username' => 'membroteste'])->id;
        $auth->assign($role, $userId);
    }

    public function testLoginBackend(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'adminteste');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('Login');
        $I->see('Bem-vindo');
        $I->seeInCurrentUrl('index');
    }

    public function testLoginSemRole(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'membroteste');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('Login');
        $I->see('Login permitido apenas para administradores');
        $I->amOnPage('login');
    }
}
