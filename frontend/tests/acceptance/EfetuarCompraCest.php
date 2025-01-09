<?php


namespace frontend\tests\Acceptance;

use frontend\tests\AcceptanceTester;

class EfetuarCompraCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function efetuarCompra(AcceptanceTester $I)
    {
        // sign-in userteste
        $I->amOnPage('login');
        $I->fillField('#login-username', 'defesaplsi');
        $I->fillField('#login-password', '12345678');
        $I->click('.btn-login');

        // espera até 7 segundos para carregar a aba collection da navbar
        $I->waitForElementVisible('#collection-link', 7);
        $I->seeElement('#collection-link');
        $I->click('#collection-link');
        $I->see('COLLECTION');

        // verificar se existe algum artigo card
        $I->waitForElementVisible('.card', 7);
        $I->seeElement('.card');

/*        //adiciona/remove aos favoritos
       // $I->click('.favorite-button');
        $I->wait(2);
        $I->click('.btn-close');
        $I->wait(2);*/

        //clica para ver o artigo
        $I->click('.view-item-button');
        $I->wait(2);

        //adicona artigo ao carrinho
        $I->seeInCurrentUrl('artigo/view');
        $I->click('ADD TO CART');
        $I->wait(2);

        //entre no carrinho
        $I->click('.user-cart-items');
        $I->wait(2);
        $I->click('.button-checkout');

        // confirma que esta no checkput e preenche tudo
        $I->seeInCurrentUrl('venda/create');
        $I->see('CHECKOUT');
        $I->waitForElementVisible('#checkout-name', 7);
        $I->fillField('#checkout-name', 'Tomas Ricardo');
        $I->fillField('#checkout-address', 'Rua das flores 1');
        $I->fillField('#checkout-postal-code', '2560-123');
        $I->fillField('#checkout-country', 'Portugal');
        $I->fillField('#checkout-city', 'Lisboa');
        $I->scrollTo('#checkout-shipping-method');
        $I->selectOption('#checkout-shipping-method', 'CTT');
        $I->selectOption('#checkout-payment-method', 'MBWay');
        $I->executeJS('document.querySelector(".checkout-finish-order").scrollIntoView(true);');
        $I->waitForElementVisible('.checkout-finish-order', 10);
        $I->wait(2);
        $I->executeJS('document.querySelector(".checkout-finish-order").click();');
        $I->wait(5);
        //verifica que chegou aos detalhes da venda (venda concluida)
        $I->seeInCurrentUrl('venda/view');
        $I->wait(5);
    }
}
