<?php


namespace common\tests\Unit;

use common\models\Artigo;
use common\models\Estado;
use common\models\Carrinho;
use common\models\Linhascarrinho;
use common\models\Perfil;
use common\tests\UnitTester;

class CarrinhoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    protected $userId;
    protected $carrinhoId;

    protected function _before()
    {
        // Cria um utilizador para associar ao carrinho
        $this->userId = $this->tester->haveRecord(Perfil::class, [
            'banido' => false,
        ]);

        // Cria um carrinho associado ao utilizador
        $this->carrinhoId = $this->tester->haveRecord(Carrinho::class, [
            'iduser' => $this->userId,
        ]);
    }

    // Testa a validação do campo 'iduser'
    public function testValidateIdUserRequired()
    {
        $carrinho = new Carrinho();
        $this->assertFalse($carrinho->validate(['iduser']), 'O iduser é obrigatório e a validação deveria falhar.');
    }

    // Testa a unicidade do campo 'iduser'
    public function testValidateIdUserUnique()
    {
        $carrinho = new Carrinho();
        $carrinho->iduser = 1; //id do admin

        $this->assertFalse($carrinho->validate(['iduser']), 'O iduser deve ser único e a validação deveria falhar.');
    }

    // Testa o relacionamento com linhas do carrinho
    public function testRelacionamentoLinhasCarrinho()
    {
        $carrinho = Carrinho::findOne($this->carrinhoId);

        // Cria uma linha de carrinho associada ao carrinho
        $linhaId = $this->tester->haveRecord(Linhascarrinho::class, [
            'idcarrinho' => $this->carrinhoId,
            'idartigo' => 1,
        ]);

        $this->assertNotEmpty($carrinho->linhascarrinhos, 'O carrinho deveria ter linhas associadas.');
        $this->assertEquals(1, count($carrinho->linhascarrinhos), 'O número de linhas associadas está incorreto.');
    }

    // Testa o método ifExistsCart()
    public function testIfExistsCart()
    {
        $carrinho = Carrinho::findOne($this->carrinhoId);

        $this->assertFalse($carrinho->ifExistsCart(), 'O carrinho não deveria conter linhas inicialmente.');

        // Adiciona uma linha ao carrinho
        $this->tester->haveRecord(Linhascarrinho::class, [
            'idcarrinho' => $this->carrinhoId,
            'idartigo' => 1,
        ]);

        $this->assertTrue($carrinho->ifExistsCart(), 'O carrinho deveria conter linhas após a inserção.');
    }

    // Testa o cálculo do total de venda
    public function testGetTotalVenda()
    {
        $carrinho = Carrinho::findOne($this->carrinhoId);

        $artigoId1 = $this->tester->haveRecord('common\models\Artigo', [
            'nome' => 'Teste Artigo',
            'descricao' => 'Descrição de teste',
            'precoanuncio' => 100.00,
            'idcomissao' => 1,
            'idestado' => 1,
            'idmarca' => 2,
            'idcategoria' => 1,
            'idtamanho' => 1,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => 1,
        ]);

        $this->tester->haveRecord(Linhascarrinho::class, [
            'idcarrinho' => $this->carrinhoId,
            'idartigo' => $artigoId1,
        ]);

        $totalVenda = $carrinho->getTotalVenda();

        $this->assertEquals(100.00, $totalVenda, 'O total da venda está incorreto ');
    }
}
