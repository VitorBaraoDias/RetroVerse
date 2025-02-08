<?php

namespace frontend\tests\functional;

use common\models\Artigo;
use common\models\Categoriaartigo;
use common\models\Estado;
use common\models\Marca;
use common\models\Tamanho;
use frontend\tests\FunctionalTester;

class EfetuarCompraCest
{
    private $artigoId;

    public function _before(FunctionalTester $I)
    {
        //autentica-se com o user 2 (moderadoer)
        $I->amLoggedInAs(2);

        $estado = new Estado(['descricao' => 'Novo']);
        $estado->save();

        $marca = new Marca(['nome' => 'Marca Teste', 'ativo' => true]);
        $marca->save();

        $categoria = new Categoriaartigo(['nome' => 'Categoria Teste', 'ativo' => true]);
        $categoria->save();

        $tamanho = new Tamanho(['tamanho' => 'M']);
        $tamanho->save();

        //publica um artigo com o perfil da LOJA para poder ser comprado
        $artigo = new Artigo([
            'nome' => 'Artigo de Teste',
            'descricao' => 'Descrição do artigo de teste',
            'precoanuncio' => 100.00,
            'idcomissao' => 1,
            'idestado' => $estado->id,
            'idmarca' => $marca->id,
            'idcategoria' => $categoria->id,
            'idtamanho' => $tamanho->id,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);
        $artigo->save();

        $this->artigoId = $artigo->id;
    }

    public function efetuarCompra(FunctionalTester $I)
    {
        //ir para a pagina do artigo criado
        $I->amOnPage("/artigo/view-marketplace?id={$this->artigoId}");
        $I->see('Descrição do artigo de teste');
        $I->see('Artigo de Teste');
        $I->see(100);

        //adicionar ao carrinho
        $I->click('ADD TO CART');

        //ir para a página do carrinho
        $I->amOnPage('/carrinho/index');

        //verificar se o item foi add no carrinho
        $I->see('Artigo de Teste');
        $I->see(100);


        //ir para o checkout e verificar
        $I->click('CHECKOUT');
        $I->see('CHECKOUT');

        //preencher o formulario de checkout
        $I->fillField('#checkout-name', 'Tomas Ricardo');
        $I->fillField('#checkout-address', 'Rua das flores 1');
        $I->fillField('#checkout-postal-code', '2560-123');
        $I->fillField('#checkout-country', 'Portugal');
        $I->fillField('#checkout-city', 'Lisboa');
        $I->click('FINISH ORDER');


        //confirmar que a venda foi concluida com sucesso
        $I->seeInCurrentUrl('/venda/view');
        $I->see('Artigo de Teste');
    }

}
