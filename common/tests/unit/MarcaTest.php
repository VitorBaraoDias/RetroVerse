<?php


namespace common\tests\Unit;

use common\models\Marca;
use common\tests\UnitTester;

class MarcaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testValidMarca()
    {
        $marca = new Marca([
            'nome' => 'Marca Teste',
            'ativo' => true,
        ]);

        $this->assertTrue($marca->validate(), 'A marca deve ser válida com os dados corretos.');
    }
    public function testMarcaWithoutNome()
    {
        $marca = new Marca([
            'ativo' => true,
        ]);

        $this->assertFalse($marca->validate(), 'A marca não deve ser válida sem o nome.');
    }
    public function testMarcaNomeMaxLength()
    {
        $marca = new Marca([
            'nome' => str_repeat('a', 151), // Nome com 151 caracteres
            'ativo' => true,
        ]);

        $this->assertFalse($marca->validate(), 'A marca não deve ser válida se o nome exceder 150 caracteres.');
        $this->assertArrayHasKey('nome', $marca->errors, 'Deve haver um erro de validação para o campo "nome".');
    }}
