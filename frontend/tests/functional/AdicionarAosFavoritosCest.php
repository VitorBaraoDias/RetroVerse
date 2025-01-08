<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class AdicionarAosFavoritosCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
    }

    public function testAdicionarFavorito(FunctionalTester $I)
    {
        $itemID = 75;

        $I->amOnPage("/artigo/view-marketplace?id={$itemID}");

        $I->see('Billabong T-shirt');

        $I->click('#favorite-button');

        $I->click('.user-favorites-items');

        $I->see('FAVORITES');
    }
}
