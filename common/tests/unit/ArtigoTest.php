<?php


namespace common\tests\Unit;

use common\models\Artigo;
use common\tests\UnitTester;

class ArtigoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testRequiredFields()
    {
        $artigo = new Artigo();
        $artigo->nome = "ola";

        $this->assertFalse($artigo->validate(['nome']));
    }
}
