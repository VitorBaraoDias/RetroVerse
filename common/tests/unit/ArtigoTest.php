<?php

namespace common\tests\Unit;

use common\models\Artigo;
use common\models\Mensagemproposta;
use common\models\Comissao;
use common\models\Categoriaartigo;
use common\models\Estado;
use common\models\Marca;
use common\models\Perfil;
use common\models\Tamanho;
use common\tests\UnitTester;
use Yii;

class ArtigoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
        // Configuração inicial antes de cada teste, se necessário
    }

    /**
     * Testa a criação de um artigo válido e sua persistência na base de dados.
     */
    public function testCreateValidArtigo()
    {
        $artigo = new Artigo([
            'nome' => 'Artigo de Teste',
            'descricao' => 'Descrição do artigo de teste',
            'precoanuncio' => 100.00,
            'idcomissao' => 1,
            'idestado' => 1,
            'idmarca' => 1,
            'idcategoria' => 1,
            'idtamanho' => 1,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);

        $this->assertTrue($artigo->save(), 'O artigo não foi salvo com sucesso.');
        //$this->tester->seeInDatabase('artigos', ['nome' => 'Artigo de Teste']);
    }

    /**
     * Testa a validação do campo 'precoanuncio' para garantir que não aceite valores negativos.
     */
    public function testPrecoAnuncioNaoAceitaNegativo()
    {
        $artigo = new Artigo([
            'nome' => 'Artigo Inválido',
            'descricao' => 'Descrição inválida',
            'precoanuncio' => -50.00,
            'idcomissao' => 1,
            'idestado' => 1,
            'idmarca' => 1,
            'idcategoria' => 1,
            'idtamanho' => 1,
            'idperfil' => 1,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);

        $this->assertFalse($artigo->validate(), 'O modelo Artigo não deve ser válido com preço negativo.');
        $this->assertArrayHasKey('precoanuncio', $artigo->errors, 'Deve haver um erro de validação para o campo precoanuncio.');
    }

    /**
     * Testa o cálculo do preço com comissão.
     */
    public function testCalculoPrecoComComissao()
    {
        $comissao = new Comissao(['comissao' => 10]); // 10% de comissão
        $artigo = new Artigo([
            'precoanuncio' => 200.00,
            'idcomissao' => 1,
        ]);
        $artigo->populateRelation('idcomissao0', $comissao);

        $precoComComissao = $artigo->getPriceWithCommissionOrProposal();
        $this->assertEquals(220.00, $precoComComissao, 'O preço com comissão deve ser 220.00.');
    }

    /**
     * Testa a relação entre Artigo e Mensagemproposta.
     */
    public function testRelacaoComMensagemProposta()
    {
        $artigo = Artigo::findOne(106);
        $this->assertNotEmpty($artigo->mensagempropostas, 'O artigo deve ter mensagens de proposta associadas.');
    }

    /**
     * Testa a validação dos campos obrigatórios.
     */
    public function testCamposObrigatorios()
    {
        $artigo = new Artigo();
        $this->assertFalse($artigo->validate(), 'O modelo Artigo não deve ser válido sem os campos obrigatórios.');
        $this->assertArrayHasKey('nome', $artigo->errors, 'Deve haver um erro de validação para o campo nome.');
        $this->assertArrayHasKey('descricao', $artigo->errors, 'Deve haver um erro de validação para o campo descricao.');
    }
}
