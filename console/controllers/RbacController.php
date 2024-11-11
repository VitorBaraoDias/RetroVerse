<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // admin permission #1
        $criarArtigosLoja = $auth->createPermission('criarArtigosLoja');
        $criarArtigosLoja->description = 'Criar artigos loja';
        $auth->add($criarArtigosLoja);

        // admin permission #2
        $alterarArtigosLoja = $auth->createPermission('alterarArtigosLoja');
        $alterarArtigosLoja->description = 'Alterar artigos loja';
        $auth->add($alterarArtigosLoja);

        // admin permission #3
        $eliminarArtigosLoja = $auth->createPermission('eliminarArtigosLoja');
        $eliminarArtigosLoja->description = 'Eliminar artigos loja';
        $auth->add($eliminarArtigosLoja);

        // admin permission #4
        $criarBannerLoja = $auth->createPermission('criarBannerLoja');
        $criarBannerLoja->description = 'Criar banner loja';
        $auth->add($criarBannerLoja);

        // admin permission #5
        $alterarBannerLoja = $auth->createPermission('alterarBannerLoja');
        $alterarBannerLoja->description = 'Alterar banner loja';
        $auth->add($alterarBannerLoja);

        // admin permission #6
        $eliminarBannerLoja = $auth->createPermission('eliminarBannerLoja');
        $eliminarBannerLoja->description = 'Eliminar banner loja';
        $auth->add($eliminarBannerLoja);

        // admin permission #7
        $criarFaqLoja = $auth->createPermission('criarFaqLoja');
        $criarFaqLoja->description = 'Criar FAQ loja';
        $auth->add($criarFaqLoja);

        // admin permission #8
        $alterarFaqLoja = $auth->createPermission('alterarFaqLoja');
        $alterarFaqLoja->description = 'Alterar FAQ loja';
        $auth->add($alterarFaqLoja);

        // admin permission #9
        $eliminarFaqLoja = $auth->createPermission('eliminarFaqLoja');
        $eliminarFaqLoja->description = 'Eliminar FAQ loja';
        $auth->add($eliminarFaqLoja);

        // admin permission #10
        $alterarInformacoesMembro = $auth->createPermission('alterarInformacoesMembro');
        $alterarInformacoesMembro->description = 'Alterar informacoes membro';
        $auth->add($alterarInformacoesMembro);

        // admin permission #11
        $desativarMembro = $auth->createPermission('desativarMembro');
        $desativarMembro->description = 'Desativar membro';
        $auth->add($desativarMembro);

        // admin permission #12
        $promoverMembro = $auth->createPermission('promoverMembro');
        $promoverMembro->description = 'Promover membro';
        $auth->add($promoverMembro);

        // admin permission #13
        $desativarArtigoMembro = $auth->createPermission('desativarArtigoMembro');
        $desativarArtigoMembro->description = 'Desativar artigo membro';
        $auth->add($desativarArtigoMembro);

        // admin permission #14
        $editarEstadoEncomendaLoja = $auth->createPermission('editarEstadoEncomendaLoja');
        $editarEstadoEncomendaLoja->description = 'Editar estado encomenda loja';
        $auth->add($editarEstadoEncomendaLoja);

        $verEncomendasLoja = $auth->createPermission('verListaEncomendasLoja');
        $verEncomendasLoja->description = 'Ver lista de encomendas da Loja';
        $auth->add($verEncomendasLoja);
        // admin permission #15
        $verDetalhesEncomendaLoja = $auth->createPermission('verDetalhesEncomendaLoja');
        $verDetalhesEncomendaLoja->description = 'Ver Detalhes Encomenda Loja';
        $auth->add($verDetalhesEncomendaLoja);

        // admin permission #16
        $criarPlanoPremium = $auth->createPermission('criarPlanoPremium');
        $criarPlanoPremium->description = 'Criar Plano Premium';
        $auth->add($criarPlanoPremium);

        // admin permission #17
        $desativarPlanoPremium = $auth->createPermission('desativarPlanoPremium');
        $desativarPlanoPremium->description = 'Desativar Plano Premium';
        $auth->add($desativarPlanoPremium);

        $criarMarcas = $auth->createPermission('criarMarcas');
        $criarMarcas->description = 'Criar marcas';
        $auth->add($criarMarcas);

        $alterarMarcas = $auth->createPermission('alterarMarcas');
        $criarMarcas->description = 'Alterar marcas';
        $auth->add($alterarMarcas);

        $eliminarMarcas = $auth->createPermission('eliminarMarcas');
        $eliminarMarcas->description = 'Eliminar marcas';
        $auth->add($eliminarMarcas);


        $criarCategorias = $auth->createPermission('criarCategorias');
        $criarCategorias->description = 'Criar categorias';
        $auth->add($criarCategorias);

        $alterarCategorias = $auth->createPermission('alterarCategorias');
        $alterarCategorias->description = 'Alterar categorias';
        $auth->add($alterarCategorias);

        $eliminarCategorias = $auth->createPermission('eliminarCategorias');
        $eliminarCategorias->description = 'Eliminar categorias';
        $auth->add($eliminarCategorias);

        $criarTamanhos = $auth->createPermission('criarTamanho');
        $criarTamanhos->description = 'Criar tamanhos';
        $auth->add($criarTamanhos);

        $alterarTamanhos = $auth->createPermission('alterarTamanhos');
        $alterarTamanhos->description = 'Alterar tamanhos';
        $auth->add($alterarTamanhos);

        $eliminarTamanhos = $auth->createPermission('eliminarTamanhos');
        $eliminarTamanhos->description = 'Eliminar tamanhos';
        $auth->add($eliminarTamanhos);

        $criarCondicao = $auth->createPermission('criarCondicao');
        $criarCondicao->description = 'Criar condicao';
        $auth->add($criarCondicao);

        $alterarCondicao = $auth->createPermission('alterarCondicao');
        $alterarCondicao->description = 'Alterar condicao';
        $auth->add($alterarCondicao);

        $eliminarCondicao = $auth->createPermission('eliminarCondicao');
        $eliminarCondicao->description = 'Eliminar condicao';
        $auth->add($eliminarCondicao);

        $verDenuncias = $auth->createPermission('verDenuncias');
        $verDenuncias->description = 'Eliminar condicao';
        $auth->add($verDenuncias);
        //MEMBER PERMISSIONS

        // member permission #1
        $criarArtigoMarketplace = $auth->createPermission('criarArtigoMarketplace');
        $criarArtigoMarketplace->description = 'Criar Artigo Marketplace';
        $auth->add($criarArtigoMarketplace);

















        //criação das roles
        $admin = $auth->createRole('admin');
        $moderador = $auth->createRole('moderador');
        $membro = $auth->createRole('membro');

        $auth->add($admin);
        $auth->add($moderador);
        $auth->add($membro);


        //adicionar as permissoes Às roles
        $auth->addChild($admin, $moderador);
        $auth->addChild($moderador, $membro);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
        $auth->assign($moderador, 2);
    }
}