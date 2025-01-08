<?php
namespace backend\tests\Unit;

use backend\tests\Unit;
use common\models\Artigo;

class ArtigoTest extends \Codeception\Test\Unit
{

    public function testRequiredFields()
    {
        $artigo = new Artigo();
        $artigo->nome = "ola";

        $this->assertFalse($artigo->validate(['nome']));
    }
}
