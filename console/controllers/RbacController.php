<?php
namespace console\controllers;

use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\rbac\Permission;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();


        $criarArtigosLoja = $auth->createPermission('criarArtigosLoja');
        $criarArtigosLoja->description = 'Criar artigos loja';
        $auth->add($criarArtigosLoja);


        $alterarArtigosLoja = $auth->createPermission('alterarArtigosLoja');
        $alterarArtigosLoja->description = 'Alterar artigos loja';
        $auth->add($alterarArtigosLoja);


        $eliminarArtigosLoja = $auth->createPermission('eliminarArtigosLoja');
        $eliminarArtigosLoja->description = 'Eliminar artigos loja';
        $auth->add($eliminarArtigosLoja);


        $criarBannerLoja = $auth->createPermission('criarBannerLoja');
        $criarBannerLoja->description = 'Criar banner loja';
        $auth->add($criarBannerLoja);


        $alterarBannerLoja = $auth->createPermission('alterarBannerLoja');
        $alterarBannerLoja->description = 'Alterar banner loja';
        $auth->add($alterarBannerLoja);


        $eliminarBannerLoja = $auth->createPermission('eliminarBannerLoja');
        $eliminarBannerLoja->description = 'Eliminar banner loja';
        $auth->add($eliminarBannerLoja);

        //FAQS BACKEND
        $verFaqsBackend = $auth->createPermission('verFaqsBackend');
        $verFaqsBackend->description = 'Ver FAQS Backend';
        $auth->add($verFaqsBackend);

        $verDetalhesFaqsBackend = $auth->createPermission('verDetalhesFaqsBackend');
        $verDetalhesFaqsBackend->description = 'Ver detalhes FAQS Backend';
        $auth->add($verDetalhesFaqsBackend);

        $criarFaqsBackend = $auth->createPermission('criarFaqsBackend');
        $criarFaqsBackend->description = 'Criar Faqs Backend';
        $auth->add($criarFaqsBackend);

        $alterarFaqsBackend = $auth->createPermission('alterarFaqsBackend');
        $alterarFaqsBackend->description = 'Alterar Faqs Backend';
        $auth->add($alterarFaqsBackend);

        $eliminarFaqsBackend = $auth->createPermission('eliminarFaqsBackend');
        $eliminarFaqsBackend->description = 'Eliminar Faqs Backend';
        $auth->add($eliminarFaqsBackend);

        //FIM FAQS BACKEND

        $alterarInformacoesMembro = $auth->createPermission('alterarInformacoesMembro');
        $alterarInformacoesMembro->description = 'Alterar informacoes membro';
        $auth->add($alterarInformacoesMembro);


        $alterarEstadoEncomendaLoja = $auth->createPermission('alterarEstadoEncomendaLoja');
        $alterarEstadoEncomendaLoja->description = 'Alterar estado encomenda loja';
        $auth->add($alterarEstadoEncomendaLoja);


        $editarEstadoEncomendaLoja = $auth->createPermission('editarEstadoEncomendaLoja');
        $editarEstadoEncomendaLoja->description = 'Editar estado encomenda loja';
        $auth->add($editarEstadoEncomendaLoja);

        $verEncomendasLoja = $auth->createPermission('verListaEncomendasLoja');
        $verEncomendasLoja->description = 'Ver lista de encomendas da Loja';
        $auth->add($verEncomendasLoja);


        $verDetalhesEncomendaLoja = $auth->createPermission('verDetalhesEncomendaLoja');
        $verDetalhesEncomendaLoja->description = 'Ver Detalhes Encomenda Loja';
        $auth->add($verDetalhesEncomendaLoja);


        $criarPlanoPremium = $auth->createPermission('criarPlanoPremium');
        $criarPlanoPremium->description = 'Criar Plano Premium';
        $auth->add($criarPlanoPremium);


        $desativarPlanoPremium = $auth->createPermission('desativarPlanoPremium');
        $desativarPlanoPremium->description = 'Desativar Plano Premium';
        $auth->add($desativarPlanoPremium);

        // MARCAS BACKEND
        $verMarcasBackend = $auth->createPermission('verMarcasBackend');
        $verMarcasBackend->description = 'Ver marcas Backend';
        $auth->add($verMarcasBackend);

        $verDetalhesMarcasBackend = $auth->createPermission('verDetalhesMarcasBackend');
        $verDetalhesMarcasBackend->description = 'Ver Detalhes marcas Backend';
        $auth->add($verDetalhesMarcasBackend);

        $criarMarcasBackend = $auth->createPermission('criarMarcasBackend');
        $criarMarcasBackend->description = 'Criar marcas Backend';
        $auth->add($criarMarcasBackend);

        $alterarMarcasBackend = $auth->createPermission('alterarMarcasBackend');
        $alterarMarcasBackend->description = 'Alterar marcas Backend';
        $auth->add($alterarMarcasBackend);

        $eliminarMarcasBackend = $auth->createPermission('eliminarMarcasBackend');
        $eliminarMarcasBackend->description = 'Eliminar marcas Backend';
        $auth->add($eliminarMarcasBackend);
        // FIM MARCAS BACKEND

        // ESTADOS BACKEND
        $verEstadosBackend = $auth->createPermission('verEstadosBackend');
        $verEstadosBackend->description = 'Ver estados Backend';
        $auth->add($verEstadosBackend);

        $verDetalhesEstadosBackend = $auth->createPermission('verDetalhesEstadosBackend');
        $verDetalhesEstadosBackend->description = 'Ver Detalhes estados Backend';
        $auth->add($verDetalhesEstadosBackend);

        $criarEstadosBackend = $auth->createPermission('criarEstadosBackend');
        $criarEstadosBackend->description = 'Criar estados Backend';
        $auth->add($criarEstadosBackend);


        $alterarEstadosBackend = $auth->createPermission('alterarEstadosBackend');
        $alterarEstadosBackend->description = 'Alterar estados Backend';
        $auth->add($alterarEstadosBackend);


        $eliminarEstadosBackend = $auth->createPermission('eliminarEstadosBackend');
        $eliminarEstadosBackend->description = 'Eliminar estados Backend';
        $auth->add($eliminarEstadosBackend);
        // FIM ESTADOS BACKEND


        $criarCategorias = $auth->createPermission('criarCategorias');
        $criarCategorias->description = 'Criar categorias Backend';
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

        $verDenuncias = $auth->createPermission('verDenuncias');
        $verDenuncias->description = 'Eliminar condicao';
        $auth->add($verDenuncias);

        $verTodosFavoritos = $auth->createPermission('verTodosFavoritos');
        $verTodosFavoritos->description = 'Ver Todos os Favoritos';
        $auth->add($verTodosFavoritos);

        //METODOS EXPEDICAO BACKEND
        $verMetodosExpedicaoBackend = $auth->createPermission('verMetodosExpedicaoBackend');
        $verMetodosExpedicaoBackend->description = 'Ver Métodos de Expedição Backend';
        $auth->add($verMetodosExpedicaoBackend);

        $verDetalhesMetodosExpedicaoBackend = $auth->createPermission('verDetalhesMetodosBackend');
        $verDetalhesMetodosExpedicaoBackend->description = 'Ver Detalhes Métodos de Expedicao Backend';
        $auth->add($verDetalhesMetodosExpedicaoBackend);

        $criarMetodosExpedicaoBackend = $auth->createPermission('criarMetodosExpedicaoBackend');
        $criarMetodosExpedicaoBackend->description = 'Criar Métodos de Expedição Backend';
        $auth->add($criarMetodosExpedicaoBackend);


        $alterarMetodosExpedicaoBackend = $auth->createPermission('alterarMetodosExpedicaoBackend');
        $alterarMetodosExpedicaoBackend->description = 'Alterar Métodos de Expedição Backend';
        $auth->add($alterarMetodosExpedicaoBackend);

        $eliminarMetodosExpedicaoBackend = $auth->createPermission('eliminarMetodosExpedicaoBackend');
        $eliminarMetodosExpedicaoBackend->description = 'Eliminar Métodos de Expedição Backend';
        $auth->add($eliminarMetodosExpedicaoBackend);
        //FIM METODOS EXPEDICAO BACKEND


        //MODERATOR PERMISSIONS
        // moderator permission #1
        $desativarMembro = $auth->createPermission('desativarMembro');
        $desativarMembro->description = 'Desativar membro';
        $auth->add($desativarMembro);

        // moderator permission #2
        $promoverMembro = $auth->createPermission('promoverMembro');
        $promoverMembro->description = 'Promover membro';
        $auth->add($promoverMembro);

        // moderator permission #3
        $desativarArtigoMembro = $auth->createPermission('desativarArtigoMembro');
        $desativarArtigoMembro->description = 'Desativar artigo membro';
        $auth->add($desativarArtigoMembro);



        //MEMBER PERMISSIONS
        // member permission #1
        $criarArtigoMarketplace = $auth->createPermission('criarArtigoMarketplace');
        $criarArtigoMarketplace->description = 'Criar Artigo Marketplace';
        $auth->add($criarArtigoMarketplace);

        // member permission #2
        $alterarArtigoMarketplace = $auth->createPermission('alterarArtigoMarketplace');
        $alterarArtigoMarketplace->description = 'Alterar Artigo Marketplace';
        $auth->add($alterarArtigoMarketplace);

        // member permission #3
        $eliminarArtigoMarketplace = $auth->createPermission('eliminarArtigoMarketplace');
        $eliminarArtigoMarketplace->description = 'Eliminar Artigo Marketplace';
        $auth->add($eliminarArtigoMarketplace);

        // member permission #4
        $adicionarArtigoCarrinho = $auth->createPermission('adicionarArtigoCarrinho');
        $adicionarArtigoCarrinho->description = 'Adicionar Artigo Carrinho';
        $auth->add($adicionarArtigoCarrinho);

        // member permission #5
        $eliminarArtigoCarrinho = $auth->createPermission('eliminarArtigoCarrinho');
        $eliminarArtigoCarrinho->description = 'Eliminar Artigo Carrinho';
        $auth->add($eliminarArtigoCarrinho);

        // member permission #6
        $alterarDetalhesPerfil = $auth->createPermission('alterarDetalhesPerfil');
        $alterarDetalhesPerfil->description = 'Alterar Detalhes Perfil';
        $auth->add($alterarDetalhesPerfil);

        // member permission #7
        $adicionarDetalhesPerfil = $auth->createPermission('adicionarDetalhesPerfil');
        $adicionarDetalhesPerfil->description = 'Adicionar Detalhes Perfil';
        $auth->add($adicionarDetalhesPerfil);

        // member permission #8
        $criarFaq = $auth->createPermission('criarFaq');
        $criarFaq->description = 'criar FAQ';
        $auth->add($criarFaq);

        // member permission #9
        $eliminarFaq = $auth->createPermission('eliminarFaq');
        $eliminarFaq->description = 'Eliminar FAQ';
        $auth->add($eliminarFaq);


        //VIEW PERMISSIONS
        // member permission
        $verProdutosLoja = $auth->createPermission('verProdutosLoja');
        $verProdutosLoja->description = 'Ver Produtos Loja';
        $auth->add($verProdutosLoja);

        // member permission
        $verProdutosLojaPremium = $auth->createPermission('verProdutosLojaPremium');
        $verProdutosLojaPremium->description = 'Ver Produtos Loja Premium';
        $auth->add($verProdutosLojaPremium);

        // member permission
        $verProdutosMarketplace = $auth->createPermission('verProdutosMarketplace');
        $verProdutosMarketplace->description = 'Ver Produtos Marketplace';
        $auth->add($verProdutosMarketplace);

        // member permission
        $verMeuPrefil = $auth->createPermission('verMeuPrefil');
        $verMeuPrefil->description = 'Ver o Meu Perfil';
        $auth->add($verMeuPrefil);

        // member permission
        $verPerfilMembro = $auth->createPermission('verPerfilMembro');
        $verPerfilMembro->description = 'Ver Perfil Membro';
        $auth->add($verPerfilMembro);

        // member permission
        $verDetalhesArtigoLoja = $auth->createPermission('verDetalhesArtigoLoja');
        $verDetalhesArtigoLoja->description = 'Ver Detalhes Artigo Loja';
        $auth->add($verDetalhesArtigoLoja);

        // member permission
        $verDetalhesArtigoMarketplace = $auth->createPermission('verDetalhesArtigoMarketplace');
        $verDetalhesArtigoMarketplace->description = 'Ver Detalhes Artigo Marketplace';
        $auth->add($verDetalhesArtigoMarketplace);

        // member permission
        $verArtigosCarrinho = $auth->createPermission('verArtigosCarrinho');
        $verArtigosCarrinho->description = 'Ver Artigos Carrinho';
        $auth->add($verArtigosCarrinho);

        //member permission
        $verHistoricoCompras = $auth->createPermission('verHistoricoCompras');
        $verHistoricoCompras->description = 'Ver Historico Compras';
        $auth->add($verHistoricoCompras);

        //member permission
        $verHistoricoVendas = $auth->createPermission('verHistoricoVendas');
        $verHistoricoVendas->description = 'Ver Historico Vendas';
        $auth->add($verHistoricoVendas);

        //member permission
        $verDetalhesVenda = $auth->createPermission('verDetalhesVenda');
        $verDetalhesVenda->description = 'Ver Detalhes Venda';
        $auth->add($verDetalhesVenda);

        //member permission
        $verDetalhesCompra = $auth->createPermission('verDetalhesCompra');
        $verDetalhesCompra->description = 'Ver Detalhes compra';
        $auth->add($verDetalhesCompra);

        //member permission
        $verArtigosFavoritos = $auth->createPermission('verArtigosFavoritos');
        $verArtigosFavoritos->description = 'Ver Artigos Favoritos';
        $auth->add($verArtigosFavoritos);

        //member permission
        $verPlanosPremium = $auth->createPermission('verPlanosPremium');
        $verPlanosPremium->description = 'Ver Plano Premium';
        $auth->add($verPlanosPremium);

        //member permission
        $verFaq = $auth->createPermission('verFaq');
        $verFaq->description = 'Ver FAQ';
        $auth->add($verFaq);

        $verCheckout = $auth->createPermission('verCheckout');
        $verCheckout->description = 'Ver Checkout';
        $auth->add($verCheckout);

        $verListaChats = $auth->createPermission('verListaChats');
        $verListaChats->description = 'Ver Lista Chats';
        $auth->add($verListaChats);

        $verChat = $auth->createPermission('verChat');
        $verChat->description = 'Ver Chat';
        $auth->add($verChat);



        //CRIAÇÃO DAS ROLES
        $admin = $auth->createRole('admin');
        $moderador = $auth->createRole('moderador');
        $membro = $auth->createRole('membro');

        $auth->add($admin);
        $auth->add($moderador);
        $auth->add($membro);



        //ASSOCIAR PERMISSÕES AO MEMBRO
        $auth->addChild($membro, $criarArtigoMarketplace);
        $auth->addChild($membro, $alterarArtigoMarketplace);
        $auth->addChild($membro, $eliminarArtigoMarketplace);
        $auth->addChild($membro, $adicionarArtigoCarrinho);
        $auth->addChild($membro, $eliminarArtigoCarrinho);
        $auth->addChild($membro, $alterarDetalhesPerfil);
        $auth->addChild($membro, $adicionarDetalhesPerfil);
        $auth->addChild($membro, $criarFaq);
        $auth->addChild($membro, $eliminarFaq);
        $auth->addChild($membro, $verProdutosLoja);
        $auth->addChild($membro, $verProdutosLojaPremium);
        $auth->addChild($membro, $verProdutosMarketplace);
        $auth->addChild($membro, $verMeuPrefil);
        $auth->addChild($membro, $verPerfilMembro);
        $auth->addChild($membro, $verDetalhesArtigoLoja);
        $auth->addChild($membro, $verDetalhesArtigoMarketplace);
        $auth->addChild($membro, $verArtigosCarrinho);
        $auth->addChild($membro, $verHistoricoCompras);
        $auth->addChild($membro, $verHistoricoVendas);
        $auth->addChild($membro, $verDetalhesVenda);
        $auth->addChild($membro, $verDetalhesCompra);
        $auth->addChild($membro, $verArtigosFavoritos);
        $auth->addChild($membro, $verPlanosPremium);
        $auth->addChild($membro, $verFaq);
        $auth->addChild($membro, $verCheckout);
        $auth->addChild($membro, $verListaChats);
        $auth->addChild($membro, $verChat);

        //ASSOCIAR PERMISSÕES AO MODERADOR
        $auth->addChild($moderador, $membro);
        $auth->addChild($moderador, $desativarMembro);
        $auth->addChild($moderador, $promoverMembro);
        $auth->addChild($moderador, $desativarArtigoMembro);

        //ASSOCIAR PERMISSÕES AO ADMIN
        $auth->addChild($admin, $moderador);
        $auth->addChild($admin, $criarArtigosLoja);
        $auth->addChild($admin, $alterarArtigosLoja);
        $auth->addChild($admin, $eliminarArtigosLoja);
        $auth->addChild($admin, $criarBannerLoja);
        $auth->addChild($admin, $alterarBannerLoja);
        $auth->addChild($admin, $alterarInformacoesMembro);
        $auth->addChild($admin, $alterarEstadoEncomendaLoja);
        $auth->addChild($admin, $verDetalhesEncomendaLoja);
        $auth->addChild($admin, $criarPlanoPremium);
        $auth->addChild($admin, $desativarPlanoPremium);

        //Marcas Backend
        $auth->addChild($admin, $verMarcasBackend);
        $auth->addChild($admin, $verDetalhesMarcasBackend);
        $auth->addChild($admin, $criarMarcasBackend);
        $auth->addChild($admin, $alterarMarcasBackend);
        $auth->addChild($admin, $eliminarMarcasBackend);

        //Estados Backend
        $auth->addChild($admin, $verEstadosBackend);
        $auth->addChild($admin, $verDetalhesEstadosBackend);
        $auth->addChild($admin, $criarEstadosBackend);
        $auth->addChild($admin, $alterarEstadosBackend);
        $auth->addChild($admin, $eliminarEstadosBackend);

        //Métodos Expedição Backend
        $auth->addChild($admin, $verMetodosExpedicaoBackend);
        $auth->addChild($admin, $verDetalhesMetodosExpedicaoBackend);
        $auth->addChild($admin, $criarMetodosExpedicaoBackend);
        $auth->addChild($admin, $alterarMetodosExpedicaoBackend);
        $auth->addChild($admin, $eliminarMetodosExpedicaoBackend);

        //Faqs Backend
        $auth->addChild($admin, $verFaqsBackend);
        $auth->addChild($admin, $verDetalhesFaqsBackend);
        $auth->addChild($admin, $criarFaqsBackend);
        $auth->addChild($admin, $alterarFaqsBackend);
        $auth->addChild($admin, $eliminarFaqsBackend);

        $auth->addChild($admin, $verTodosFavoritos);


        // ASSOCIAR AS ROLES A UTILIZADORES (ID)
        $auth->assign($admin, 1);
        $auth->assign($moderador, 2);
    }
}