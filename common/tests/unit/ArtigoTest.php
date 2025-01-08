<?php


namespace common\tests\Unit;

use common\models\Artigo;
use common\tests\UnitTester;
class ArtigoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function testRequiredFields()
    {
        $artigo = new Artigo();
        $artigo->nome = null;

        $this->assertFalse($artigo->validate(['nome']));
    }
}
