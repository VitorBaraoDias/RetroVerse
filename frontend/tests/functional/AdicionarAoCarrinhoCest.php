<?php

namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class AdicionarAoCarrinhoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
    }

    public function testAdicionarAoCarrinho(FunctionalTester $I)
    {
        $itemID = 75;

        $I->amOnPage("/artigo/view-marketplace?id={$itemID}");

        $I->see('Billabong T-shirt');

        $I->click('ADD TO CART');

        $I->seeInCurrentUrl('index');

        $I->see('CART');
    }

}
