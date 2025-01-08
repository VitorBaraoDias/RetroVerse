<?php

namespace common\tests\Unit;

use common\models\Artigospremium;
use common\models\Clientesplano;
use common\models\Iva;
use common\models\Plano;
use common\tests\UnitTester;

class PlanTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    protected $planId;
    protected $vatId;

    // Método _before para preparar os dados antes de cada teste
    protected function _before()
    {
        // Criar um registro na tabela 'Iva' (relacionamento com 'Plano')
        $this->vatId = $this->tester->haveRecord(Iva::class, [
            'percentagem' => 23,
            'emvigor' => true,
        ]);

        // Criar um registro na tabela 'planos' (com as colunas principais)
        $this->planId = $this->tester->haveRecord(Plano::class, [
            'precomensal' => 100.50,
            'idiva' => $this->vatId,
            'descricao' => 'Plano Premium',
            'ativo' => true
        ]);
    }

    // Testar a validação dos campos obrigatórios do modelo 'Plano'
    public function testValidateRequiredFields()
    {
        $plan = new Plano();
        $this->assertFalse($plan->validate(), 'Validação falhou quando não foram preenchidos todos os campos obrigatórios');
    }

    // Testar o relacionamento com o IVA (Iva)
    public function testVatRelationship()
    {
        $plan = Plano::findOne($this->planId);
        $this->assertNotNull($plan->iva, 'O plano não possui um IVA associado.');
        $this->assertEquals(23, $plan->iva->percentagem, 'A descrição do IVA não corresponde.');
    }

    // Testar a validação do campo 'precomensal' (não pode ser negativo)
    public function testValidateNegativePrice()
    {
        $plan = new Plano();
        $plan->precomensal = -50.00;
        $this->assertFalse($plan->validate(['precomensal']), 'O preço do plano não deve ser válido se for negativo');
    }

    // Testar a criação de um novo plano no banco de dados
    public function testCreatePlan()
    {
        $plan = new Plano();
        $plan->precomensal = 120.00;
        $plan->idiva = $this->vatId;
        $plan->descricao = 'Plano Teste';
        $plan->ativo = true;

        // Verificar se o plano é salvo corretamente
        $this->assertTrue($plan->save(), 'O plano não foi salvo!');
    }

    // Testar a atualização de um plano existente
    public function testUpdatePlan()
    {
        $plan = Plano::findOne($this->planId);
        $plan->descricao = 'Plano Atualizado';

        $this->assertTrue($plan->save(), 'O plano não foi atualizado!');
    }
}
