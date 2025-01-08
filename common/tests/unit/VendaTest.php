<?php


namespace common\tests\Unit;

use common\models\Estadoencomenda;
use common\models\Iva;
use common\models\Metodosexpedicao;
use common\models\Perfil;
use common\models\Tipopagamento;
use common\models\User;
use common\models\Venda;
use common\tests\UnitTester;

class VendaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    protected $vendaId;
    protected $ivaId;
    protected $compradorId;
    protected $metodoExpedicaoId;
    protected $tipoPagamentoId;
    protected $estadoEncomendaId;
    protected function _before()
    {
        // Criar um registro na tabela 'Iva' (relacionamento com 'Venda')
        $this->ivaId = $this->tester->haveRecord(Iva::class, [
            'percentagem' => 23,
            'emvigor' => true,
        ]);

        $this->compradorId = $this->tester->haveRecord(Perfil::class, [
            'banido' => false,
        ]);
        $this->metodoExpedicaoId = $this->tester->haveRecord(Metodosexpedicao::class, [
            'nome' => 'Expedição Rápida'
        ]);
        $this->tipoPagamentoId = $this->tester->haveRecord(Tipopagamento::class, [
            'descricao' => 'Cartão de Crédito'
        ]);

        $this->estadoEncomendaId = $this->tester->haveRecord(Estadoencomenda::class, [
            'status' => 'Em Processamento',
            'descricao' => 'Iniciada'
        ]);

        $this->vendaId = $this->tester->haveRecord(Venda::class, [
            'idcomprador' => $this->compradorId,
            'idmetodoexpedicao' => $this->metodoExpedicaoId,
            'idtipopagamento' => $this->tipoPagamentoId,
            'total' => 250.00,
            'datavenda' => '2025-01-08',
            'idestadoencomenda' => $this->estadoEncomendaId,
            'nome' => 'Venda Teste',
            'codigopostal' => '1234-567',
            'morada' => 'Rua Teste, 123',
            'pais' => 'Portugal',
            'cidade' => 'Lisboa'
        ]);
    }

    public function testValidateRequiredFields()
    {
        $venda = new Venda();
        $this->assertFalse($venda->validate(), 'Validação falhou quando não foram preenchidos todos os campos obrigatórios');
    }

    // Testar o relacionamento com o Comprador
    public function testValidateBuyerRelationship()
    {
        $venda = Venda::findOne($this->vendaId);
        $this->assertNotNull($venda->comprador, 'A venda não possui um comprador associado.');
        $this->assertEquals($this->compradorId, $venda->comprador->id, 'O nome do comprador não corresponde.');
    }

    public function testValidatePositiveTotal()
    {
        $venda = new Venda();
        $venda->total = -50.00;
        $this->assertFalse($venda->validate(['total']), 'O total da venda não deve ser válido se for negativo');
    }

    public function testCreateSale()
    {
        $venda = new Venda();
        $venda->idcomprador = $this->compradorId;
        $venda->idmetodoexpedicao = $this->metodoExpedicaoId;
        $venda->idtipopagamento = $this->tipoPagamentoId;
        $venda->total = 350.00;
        $venda->datavenda = '2025-01-10';
        $venda->idestadoencomenda = $this->estadoEncomendaId;
        $venda->nome = 'Venda Teste 2';
        $venda->codigopostal = '1234-678';
        $venda->morada = 'Avenida Teste, 456';
        $venda->pais = 'Portugal';
        $venda->cidade = 'Porto';

        $this->assertTrue($venda->save(), 'Venda não foi salva!');
    }

    public function testUpdateSale()
    {
        $venda = Venda::findOne($this->vendaId);
        $venda->nome = 'Venda Atualizada';

        $this->assertTrue($venda->save(), 'Venda não foi atualizada!');
    }
}
