<?php

namespace common\tests\Unit;

use common\models\Artigo;
use common\models\Mensagemproposta;
use common\models\Listachats;
use common\models\Comissao;
use common\models\Venda;
use common\models\Linhavenda;
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
    public $artigoId;
    public $comissaoId;
    public $estadoId;
    public $marcaId;
    public $categoriaId;
    public $tamanhoId;
    public $perfilId;
    public $mensagemPropostaId;
    public $linhaVendaId;
    public $vendaId;
    public $chatId;


    //criação de todos os objetos necessarios para testar os atributos e relacionamentos do modelo Artigo bem como lógica de negócio
    protected function _before()
    {
        $estado = new Estado(['descricao' => 'Novo']);
        $estado->save();

        $marca = new Marca(['nome' => 'Marca Teste', 'ativo' => true]);
        $marca->save();

        $categoria = new Categoriaartigo(['nome' => 'Categoria Teste', 'ativo' => true]);
        $categoria->save();

        $tamanho = new Tamanho(['tamanho' => 'M']);
        $tamanho->save();

        $perfil = new Perfil(['nome' => 'Perfil Teste']);
        $perfil->save();

        $artigo = new Artigo([
            'nome' => 'Artigo de Teste',
            'descricao' => 'Descrição do artigo de teste',
            'precoanuncio' => 100.00,
            'idcomissao' => 1,
            'idestado' => $estado->id,
            'idmarca' => $marca->id,
            'idcategoria' => $categoria->id,
            'idtamanho' => $tamanho->id,
            'idperfil' => $perfil->id,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);
        $artigo->save();

        $venda = new Venda([
            'idcomprador' => 1,
            'idmetodoexpedicao' => 1,
            'idtipopagamento' => 1,
            'total' => 100.00,
            'datavenda' => date('Y-m-d H:i:s'),
            'idestadoencomenda' => 1,
            'nome' => 'Nome do Comprador',
            'codigopostal' => '1234-567',
            'morada' => 'Rua Exemplo, 123',
            'pais' => 'Portugal',
            'cidade' => 'Lisboa',
        ]);
        $venda->save();

        $linhaVenda = new LinhaVenda([
            'idvenda' => $venda->id,
            'idartigo' => $artigo->id,
            'idvendedor' => 1,
            'idestadoencomenda' => 1,
            'precolinhavenda' => 100.00,
        ]);
        $linhaVenda->save();

        $chat = new Listachats([
            'idremetente' => 1,
            'iddestinatario' => 2,
            'idartigo' => $artigo->id,
        ]);
        $chat->save();
        $mensagemProposta = new MensagemProposta([
            'preco' => 90.00,
            'estado' => 1,
            'idchat' => $chat->id,
            'idartigo' => $artigo->id,
            'iduser' => 1,
        ]);
        $mensagemProposta->save();

        $this->artigoId = $artigo->id;
        $this->chatId = $chat->id;
        $this->comissaoId = 1;
        $this->estadoId = $estado->id;
        $this->marcaId = $marca->id;
        $this->categoriaId = $categoria->id;
        $this->tamanhoId = $tamanho->id;
        $this->perfilId = $perfil->id;
        $this->vendaId = $venda->id;
        $this->linhaVendaId = $linhaVenda->id;
        $this->mensagemPropostaId = $mensagemProposta->id;
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
            'idcomissao' => $this->comissaoId,
            'idestado' => $this->estadoId,
            'idmarca' => $this->marcaId,
            'idcategoria' => $this->categoriaId,
            'idtamanho' => $this->tamanhoId,
            'idperfil' => $this->perfilId,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);

        $this->assertTrue($artigo->save(), 'O artigo não foi salvo com sucesso.');
    }

    /**
     * Testa a atualização de um artigo
     */
    public function testUpdateArtigo()
    {
        $artigo = Artigo::findOne($this->artigoId);

        $this->assertTrue($artigo->save(), 'O artigo não foi salvo corretamente.');

        // atualizar dados do artigo
        $artigo->nome = 'Artigo Atualizado';
        $artigo->descricao = 'Descrição Atualizada';
        $artigo->precoanuncio = 75.00;

        $this->assertTrue($artigo->save(), 'O artigo não foi atualizado corretamente.');

        $artigoAtualizado = Artigo::findOne($artigo->id);

        $this->assertNotNull($artigoAtualizado, 'O artigo atualizado não foi encontrado.');
        $this->assertEquals('Artigo Atualizado', $artigoAtualizado->nome, 'O nome do artigo não foi atualizado corretamente.');
        $this->assertEquals('Descrição Atualizada', $artigoAtualizado->descricao, 'A descrição do artigo não foi atualizada corretamente.');
        $this->assertEquals(75.00, $artigoAtualizado->precoanuncio, 'O preço do artigo não foi atualizado corretamente.');
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
            'idcomissao' => $this->comissaoId,
            'idestado' => $this->estadoId,
            'idmarca' => $this->marcaId,
            'idcategoria' => $this->categoriaId,
            'idtamanho' => $this->tamanhoId,
            'idperfil' => $this->perfilId,
            'tipoartigo' => 'LOJA',
            'ativo' => true,
        ]);

        $this->assertFalse($artigo->validate(), 'O modelo Artigo não deve ser válido com preço negativo.');
        $this->assertArrayHasKey('precoanuncio', $artigo->errors, 'Deve haver um erro de validação para o campo precoanuncio.');
    }

    /**
     * Testa o cálculo do preço com comissão.
     */
    public function testCalculaPrecoComComissao()
    {
        $artigo = new Artigo([
            'precoanuncio' => 200.00,
            'idcomissao' => $this->comissaoId,
        ]);
        $comissao = Comissao::findOne($this->comissaoId);

        $artigo->populateRelation('idcomissao0', $comissao);

        $precoComComissao = $artigo->getPriceWithCommissionOrProposal();
        $this->assertEquals(220.00, $precoComComissao, 'O preço com comissão deve ser 220.00.');
    }


    public function testCalculaPrecoComComissaoOuProposta()
    {
        $artigo = Artigo::findOne($this->artigoId);
        $priceWithCommission = $artigo->getPriceWithCommissionOrProposal();
        $expectedPrice = round(($artigo->precoanuncio * (1 + ($artigo->idcomissao0->comissao / 100))), 2);
        $this->assertEquals($expectedPrice, $priceWithCommission, 'O preço com comissão não foi calculado corretamente.');

        $acceptedProposal = new MensagemProposta([
            'preco' => 100,
            'estado' => 2,
            'idchat' => $this->chatId,
            'idartigo' => $artigo->id,
            'iduser' => 1,
        ]);
        $acceptedProposal->save();

        $priceWithProposal = $artigo->getPriceWithCommissionOrProposal();
        $expectedPriceWithProposal = round($acceptedProposal->preco * (1 + ($artigo->idcomissao0->comissao / 100)), 2);
        $this->assertEquals($expectedPriceWithProposal, $priceWithProposal, 'O preço com proposta aceita não foi calculado corretamente.');
    }


    /**
     * Testa a relação entre Artigo e Mensagemproposta.
     */
    public function testRelacaoComMensagemProposta()
    {
        $artigo = Artigo::findOne($this->artigoId);
        $this->assertNotEmpty($artigo->mensagempropostas, 'O artigo deve ter mensagens de proposta associadas.');
    }

    /**
     * Testa a relação entre Artigo e LinhasVendas.
     */
    public function testRelacaoComLinhaVendas()
    {
        $artigo = Artigo::findOne($this->artigoId);
        $this->assertNotEmpty($artigo->linhavendas, 'O artigo deve ter linhas de venda associadas.');
    }


    /**
     * Testa a validação dos campos obrigatórios.
     */
    public function testCamposObrigatorios()
    {
        $artigo = new Artigo();
        $this->assertFalse($artigo->validate(), 'O modelo Artigo não deve ser válido sem os campos obrigatórios.');

        //verificar qual campo falhou nos erros
        $this->assertArrayHasKey('nome', $artigo->errors, 'Deve haver um erro de validação para o campo nome.');
        $this->assertArrayHasKey('descricao', $artigo->errors, 'Deve haver um erro de validação para o campo descricao.');
        $this->assertArrayHasKey('precoanuncio', $artigo->errors, 'Deve haver um erro de validação para o campo precoanuncio.');
        $this->assertArrayHasKey('idcomissao', $artigo->errors, 'Deve haver um erro de validação para o campo idcomissao.');
        $this->assertArrayHasKey('idestado', $artigo->errors, 'Deve haver um erro de validação para o campo idestado.');
        $this->assertArrayHasKey('idmarca', $artigo->errors, 'Deve haver um erro de validação para o campo idmarca.');
        $this->assertArrayHasKey('idcategoria', $artigo->errors, 'Deve haver um erro de validação para o campo idcategoria.');
        $this->assertArrayHasKey('idtamanho', $artigo->errors, 'Deve haver um erro de validação para o campo idtamanho.');
        $this->assertArrayHasKey('idperfil', $artigo->errors, 'Deve haver um erro de validação para o campo idperfil.');
        $this->assertArrayHasKey('tipoartigo', $artigo->errors, 'Deve haver um erro de validação para o campo tipoartigo.');
    }
}


