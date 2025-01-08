<?php


namespace common\tests\Unit;

use common\models\Artigo;
use common\tests\UnitTester;
use function PHPUnit\Framework\assertTrue;

class ArtigoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function testValidArtigo()
    {
        $artigo = new Artigo([
            'nome' => 'Teste Artigo',
            'descricao' => 'Descrição de teste',
            'precoanuncio' => 50.00,
            'idcomissao' => 1,
            'idestado' => 1,
            'idmarca' => 2,
            'idcategoria' => 1,
            'idtamanho' => 1,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);
        if (!$artigo->validate()) {
            var_dump($artigo->errors);  // Exibe os erros de validação no console.
        }
        $this->assertTrue($artigo->validate(), 'O modelo Artigo deveria ser válido.');

    }
    public function testRequiredFields()
    {
        $artigo = new Artigo();
        $this->assertFalse($artigo->validate(), 'O modelo Artigo não deve ser válido sem os campos obrigatórios.');
    }

    /**
     * Testa validação do preço do anúncio (deve ser maior que zero).
     */
    public function testPrecoAnuncioValidation()
    {
        $artigo = new Artigo([
            'nome' => 'Teste Artigo',
            'descricao' => 'Descrição de teste',
            'precoanuncio' => -10.00,
            'idcomissao' => 1,
            'idestado' => 1,
            'idmarca' => 2,
            'idcategoria' => 1,
            'idtamanho' => 1,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => 1,
        ]);
        $this->assertFalse($artigo->validate(['precoanuncio']), 'O preço do anúncio não deve ser válido se for negativo.');
    }

    /**
     * Testa se o método getPriceWithCommissionOrProposal retorna o preço esperado.
     */
    public function testPriceWithCommissionOrProposal()
    {
        $artigo = new Artigo([
            'precoanuncio' => 100.00,
            'idcomissao' => 1,
        ]);

        // Mock da relação idcomissao0
        $artigo->populateRelation('idcomissao0', (object)['comissao' => 10]); // 10%

        $this->assertEquals(110.00, $artigo->getPriceWithCommissionOrProposal(), 'O preço com comissão deve ser 110.00.');
    }

    /**
     * Testa se o método getPriceWithProposalIfExist retorna o preço correto.
     */
    public function testPriceWithProposalIfExist()
    {
        $artigo = $this->getMockBuilder(Artigo::class)
            ->onlyMethods(['getPriceWithMyLastAcceptedProposal'])
            ->getMock();

        // Simula a última proposta aceita com preço de 90.00
        $artigo->method('getPriceWithMyLastAcceptedProposal')
            ->willReturn((object)['preco' => 90.00]);

        // Testa se o método retorna o preço correto
        $this->assertEquals(90.00, $artigo->getPriceWithProposalIfExist(), 'O preço com proposta deve ser 90.00.');
    }


    /**
     * Testa se o método isVendedor retorna corretamente.
     */
}
