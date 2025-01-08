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

        //SIDEBAR BO
        $verAbaStoreBackend = $auth->createPermission('verAbaStoreBackend');
        $verAbaStoreBackend->description = 'Ver Aba Store Backend';
        $auth->add($verAbaStoreBackend);

        $verAbaGeneralBackend = $auth->createPermission('verAbaGeneralBackend');
        $verAbaGeneralBackend->description = 'Ver Aba General Backend';
        $auth->add($verAbaGeneralBackend);
        //SIDEBAR BO


        //SITE CONTROLLER BO
        $verDashboardCompletaBackend = $auth->createPermission('verDashboardCompletaBackend');
        $verDashboardCompletaBackend->description = 'Ver Dashboard Backend';
        $auth->add($verDashboardCompletaBackend);

        $getInformacoesVendasBackend = $auth->createPermission('getInformacoesVendasBackend');
        $getInformacoesVendasBackend->description = 'Get Informacoes das Vendas Marketplace/Loja Backend';
        $auth->add($getInformacoesVendasBackend);

        $getInformacoesDenunciasBackend = $auth->createPermission('getInformacoesDenunciasBackend');
        $getInformacoesDenunciasBackend->description = 'Get Informacoes das Denuncias Backend';
        $auth->add($getInformacoesDenunciasBackend);
        //SITE CONTROLLER BO

        //ARTIGOS PREMIUM BO
        $criarArtigoPremiumBackend = $auth->createPermission('criarArtigoPremiumBackend');
        $criarArtigoPremiumBackend->description = 'Criar Artigo Premium Backend';
        $auth->add($criarArtigoPremiumBackend);

        $eliminarArtigoPremiumBackend = $auth->createPermission('eliminarArtigoPremiumBackend');
        $eliminarArtigoPremiumBackend->description = 'Eliminar Artigo Premium Backend';
        $auth->add($eliminarArtigoPremiumBackend);
        //ARTIGOS PREMIUM BO


        //LINHAVENDA BO
        $verEncomendasLojaBackend = $auth->createPermission('verEncomendasLojaBackend');
        $verEncomendasLojaBackend->description = 'Ver Encomendas Loja Backend';
        $auth->add($verEncomendasLojaBackend);

        $confirmarEnvioEncomendasLojaBackend = $auth->createPermission('confirmarEnvioEncomendasLojaBackend');
        $confirmarEnvioEncomendasLojaBackend->description = 'Confirmar Envio Encomendas Loja Backend';
        $auth->add($confirmarEnvioEncomendasLojaBackend);

        $gerarReportEncomendasLojaBackend = $auth->createPermission('gerarReportEncomendasLojaBackend');
        $gerarReportEncomendasLojaBackend->description = 'Gerar Report Encomendas Loja Backend';
        $auth->add($gerarReportEncomendasLojaBackend);
        //LINHAVENDA BO


        ///ARTIGO CONTROLLER BO
        $criarArtigosLojaBackEnd = $auth->createPermission('criarArtigosLojaBackend');
        $criarArtigosLojaBackEnd->description = 'Criar artigos loja Backend';
        $auth->add($criarArtigosLojaBackEnd);

        $verDetalhesArtigosLojaBackEnd = $auth->createPermission('verDetalhesArtigosLojaBackend');
        $verDetalhesArtigosLojaBackEnd->description = 'Ver detalhes artigos loja Backend';
        $auth->add($verDetalhesArtigosLojaBackEnd);

        $verArtigosLojaBackEnd = $auth->createPermission('verArtigosLojaBackend');
        $verArtigosLojaBackEnd->description = 'Ver artigos loja Backend';
        $auth->add($verArtigosLojaBackEnd);

        $alterarArtigosLojaBackEnd = $auth->createPermission('alterarArtigosLojaBackend');
        $alterarArtigosLojaBackEnd->description = 'Alterar artigos loja Backend';
        $auth->add($alterarArtigosLojaBackEnd);

        $eliminarArtigosLojaBackEnd = $auth->createPermission('eliminarArtigosLojaBackend');
        $eliminarArtigosLojaBackEnd->description = 'Eliminar artigos loja Backend';
        $auth->add($eliminarArtigosLojaBackEnd);
        ///ARTIGO CONTROLLER BO

        //IvaController BO
        $criarIvaLojaBackEnd = $auth->createPermission('criarIvaLojaBackend');
        $criarIvaLojaBackEnd->description = 'Criar iva loja Backend';
        $auth->add($criarIvaLojaBackEnd);

        $verDetalhesAIvaLojaBackEnd = $auth->createPermission('verDetalhesIvaLojaBackend');
        $verDetalhesAIvaLojaBackEnd->description = 'Ver detalhes iva loja Backend';
        $auth->add($verDetalhesAIvaLojaBackEnd);

        $verIvaLojaBackEnd = $auth->createPermission('verIvaLojaBackend');
        $verIvaLojaBackEnd->description = 'Ver iva loja Backend';
        $auth->add($verIvaLojaBackEnd);

        $alterarIvaLojaBackEnd = $auth->createPermission('alterarIvaLojaBackend');
        $alterarIvaLojaBackEnd->description = 'Alterar Iva loja Backend';
        $auth->add($alterarIvaLojaBackEnd);

        $eliminarIvaLojaBackEnd = $auth->createPermission('eliminarIvaLojaBackend');
        $eliminarIvaLojaBackEnd->description = 'Eliminar iva loja Backend';
        $auth->add($eliminarIvaLojaBackEnd);
        //IvaController BO

        //ComissaoController BO
        $criarComissaoLojaBackEnd = $auth->createPermission('criarComissaoLojaBackend');
        $criarComissaoLojaBackEnd->description = 'Criar Comissao BackEnd';
        $auth->add($criarComissaoLojaBackEnd);

        $verDetalhesComissaoLojaBackEnd = $auth->createPermission('verDetalhesComissaoLojaBackend');
        $verDetalhesComissaoLojaBackEnd->description = 'Ver detalhes Comissao  BackEnd';
        $auth->add($verDetalhesComissaoLojaBackEnd);

        $verComissaoLojaBackEnd = $auth->createPermission('verComissaoLojaBackend');
        $verComissaoLojaBackEnd->description = 'Ver Comissao BackEnd';
        $auth->add($verComissaoLojaBackEnd);

        $alterarComissaoLojaBackEnd = $auth->createPermission('alterarComissaoLojaBackend');
        $alterarComissaoLojaBackEnd->description = 'Alterar Comissao BackEnd';
        $auth->add($alterarComissaoLojaBackEnd);

        $eliminarComissaoLojaBackEnd = $auth->createPermission('eliminarComissaoLojaBackend');
        $eliminarComissaoLojaBackEnd->description = 'Eliminar Comissao BackEnd';
        $auth->add($eliminarComissaoLojaBackEnd);
        //ComissaoCotrollar BO

        //BannerCotrollar BO
        $criarBannerLoja = $auth->createPermission('criarBannerLojaBackend');
        $criarBannerLoja->description = 'Criar banner loja';
        $auth->add($criarBannerLoja);

        $verDetalhesBannerLojaBackEnd = $auth->createPermission('verDetalhesBannerLojaBackend');
        $verDetalhesBannerLojaBackEnd->description = 'Ver detalhes Banner  BackEnd';
        $auth->add($verDetalhesBannerLojaBackEnd);

        $verBannerLojaBackEnd = $auth->createPermission('verBannerLojaBackend');
        $verBannerLojaBackEnd->description = 'Ver Banner BackEnd';
        $auth->add($verBannerLojaBackEnd);

        $alterarBannerLojaBackend = $auth->createPermission('alterarBannerLojaBackend');
        $alterarBannerLojaBackend->description = 'Alterar banner loja';
        $auth->add($alterarBannerLojaBackend);

        $eliminarBannerLojaBackend = $auth->createPermission('eliminarBannerLojaBackend');
        $eliminarBannerLojaBackend->description = 'Eliminar banner loja';
        $auth->add($eliminarBannerLojaBackend);
        //BannerCotrollar BO

        //FotoartigoCotrollar BO
        $criarFotoArtigoLojaBackend = $auth->createPermission('criarfotoArtigoLojaBackend');
        $criarFotoArtigoLojaBackend->description = 'Criar foto artigo loja backend';
        $auth->add($criarFotoArtigoLojaBackend);

        $eliminarFotoArtigoLojaBackend = $auth->createPermission('eliminarfotoArtigoLojaBackend');
        $eliminarFotoArtigoLojaBackend->description = 'Eliminar foto artigo loja backend';
        $auth->add($eliminarFotoArtigoLojaBackend);
        //BannerCotrollar BO

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

        $alterarFaqLoja = $auth->createPermission('alterarFaqLoja');
        $alterarFaqLoja->description = 'Alterar FAQ loja';
        $auth->add($alterarFaqLoja);

        $eliminarFaqLoja = $auth->createPermission('eliminarFaqLoja');
        $eliminarFaqLoja->description = 'Eliminar FAQ loja';
        $auth->add($eliminarFaqLoja);

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

        //PlanoController BO

        $verPlanosPremiumBackend = $auth->createPermission('verPlanosPremiumBackend');
        $verPlanosPremiumBackend->description = 'Ver Planos Premium';
        $auth->add($verPlanosPremiumBackend);

        $verDetalhePlanoPremiumBackend = $auth->createPermission('verDetalhePlanoPremiumBackend');
        $verDetalhePlanoPremiumBackend->description = 'Ver detalhe Plano Premium';
        $auth->add($verDetalhePlanoPremiumBackend);

        $criarPlanoPremiumBackend = $auth->createPermission('criarPlanoPremiumBackend');
        $criarPlanoPremiumBackend->description = 'Criar Plano Premium';
        $auth->add($criarPlanoPremiumBackend);

        $alterarPlanoPremiumBackend = $auth->createPermission('alterarPlanoPremiumBackend');
        $alterarPlanoPremiumBackend->description = 'Alterar Plano Premium';
        $auth->add($alterarPlanoPremiumBackend);

        $eliminarPlanoPremiumBackend = $auth->createPermission('eliminarPlanoPremiumBackend');
        $eliminarPlanoPremiumBackend->description = 'Eliminar Plano Premium';
        $auth->add($eliminarPlanoPremiumBackend);
        //PlanoController BO

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


        //CategoriaArtigoController BO
        $verCategoriasBackend = $auth->createPermission('verCategoriaBackend');
        $verCategoriasBackend->description = 'Ver Categorias';
        $auth->add($verCategoriasBackend);

        $verDetalhesCategoriasBackend = $auth->createPermission('verDetalhesCategoriaBackend');
        $verDetalhesCategoriasBackend->description = 'Ver detalhes categoria';
        $auth->add($verDetalhesCategoriasBackend);

        $criarCategoriasBackend = $auth->createPermission('criarCategoriasBackend');
        $criarCategoriasBackend->description = 'Criar categorias';
        $auth->add($criarCategoriasBackend);

        $alterarCategoriasBackend = $auth->createPermission('alterarCategoriasBackend');
        $alterarCategoriasBackend->description = 'Alterar categorias';
        $auth->add($alterarCategoriasBackend);

        $eliminarCategoriasBackend = $auth->createPermission('eliminarCategoriasBackend');
        $eliminarCategoriasBackend->description = 'Eliminar categorias';
        $auth->add($eliminarCategoriasBackend);
        //CategoriaArtigoController BO


        //TamanhoControllerBO
        $verTamanhosBackend = $auth->createPermission('verTamanhoBackend');
        $verTamanhosBackend->description = 'Ver tamanhos';
        $auth->add($verTamanhosBackend);

        $verDetalhesTamanhosBackend = $auth->createPermission('verDetalhesTamanhoBackend');
        $verDetalhesTamanhosBackend->description = 'Ver detalhe tamanho';
        $auth->add($verDetalhesTamanhosBackend);

        $criarTamanhosBackend = $auth->createPermission('criarTamanhoBackend');
        $criarTamanhosBackend->description = 'Criar tamanhos';
        $auth->add($criarTamanhosBackend);

        $alterarTamanhosBackend = $auth->createPermission('alterarTamanhosBackend');
        $alterarTamanhosBackend->description = 'Alterar tamanhos';
        $auth->add($alterarTamanhosBackend);

        $eliminarTamanhosBackend = $auth->createPermission('eliminarTamanhosBackend');
        $eliminarTamanhosBackend->description = 'Eliminar tamanhos';
        $auth->add($eliminarTamanhosBackend);
        //TamanhoControllerBO


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


        //DENUNCIA CONTROLLER BO
        $verDenunciaBackend = $auth->createPermission('verDenunciaBackend');
        $verDenunciaBackend->description = 'Ver Denuncia Backend';
        $auth->add($verDenunciaBackend);

        $verDetalhesDenunciaBackend = $auth->createPermission('verDetalhesDenunciaBackend');
        $verDetalhesDenunciaBackend->description = 'Ver Detalhes Denuncia Backend';
        $auth->add($verDetalhesDenunciaBackend);

        $banirMembroBackend = $auth->createPermission('banirMembroBackend');
        $banirMembroBackend->description = 'Banir membro Backend';
        $auth->add($banirMembroBackend);

        $marcarDenunciaResolvidaBackend = $auth->createPermission('marcarDenunciaResolvidaBackend');
        $marcarDenunciaResolvidaBackend->description = 'Marcar Denuncia Resolvida Backend';
        $auth->add($marcarDenunciaResolvidaBackend);
        //DENUNCIA CONTROLLER BO

        //ArtigoController FO
        $verProdutosCollectionFrontend = $auth->createPermission('verProdutosCollectionFrontend');
        $verProdutosCollectionFrontend->description = 'Ver coleção de produtos';
        $auth->add($verProdutosCollectionFrontend);

        $verDetalheProdutoFrontend = $auth->createPermission('verDetalheProdutoFrontend');
        $verDetalheProdutoFrontend->description = 'Ver detalhes do produto';
        $auth->add($verDetalheProdutoFrontend);

        $criarArtigoMarketplaceFrontend = $auth->createPermission('criarArtigoMarketplaceFrontend');
        $criarArtigoMarketplaceFrontend->description = 'Criar Artigo Marketplace';
        $auth->add($criarArtigoMarketplaceFrontend);

        $alterarArtigoMarketplaceFrontend = $auth->createPermission('alterarArtigoMarketplaceFrontend');
        $alterarArtigoMarketplaceFrontend->description = 'Alterar Artigo Marketplace';
        $auth->add($alterarArtigoMarketplaceFrontend);

        $eliminarArtigoMarketplaceFrontend = $auth->createPermission('eliminarArtigoMarketplaceFrontend');
        $eliminarArtigoMarketplaceFrontend->description = 'Eliminar Artigo Marketplace';
        $auth->add($eliminarArtigoMarketplaceFrontend);
        //ArtigoController FO


        //CARRINHOCONTROLLER FO
        $verCarrinhoFrontend = $auth->createPermission('verCarrinhoFrontend');
        $verCarrinhoFrontend->description = 'Ver Carrinho Frontend';
        $auth->add($verCarrinhoFrontend);

        $criarCarrinhoFrontend = $auth->createPermission('criarCarrinhoFrontend');
        $criarCarrinhoFrontend->description = 'Criar Carrinho Frontend';
        $auth->add($criarCarrinhoFrontend);
        //CARRINHOCONTROLLER FO


        //CHATCONTROLLER FO
        $verChatFrontend = $auth->createPermission('verChatFrontend');
        $verChatFrontend->description = 'Ver Chat Frontend';
        $auth->add($verChatFrontend);

        $verDetalhesChatFrontend = $auth->createPermission('verDetalhesChatFrontend');
        $verDetalhesChatFrontend->description = 'Ver Detalhes Chat Frontend';
        $auth->add($verDetalhesChatFrontend);

        $criarChatFrontend = $auth->createPermission('criarChatFrontend');
        $criarChatFrontend->description = 'Criar Chat Frontend';
        $auth->add($criarChatFrontend);
        //CHATCONTROLLER FO

        //FOTOARTIGOCONTROLLER FO
        $criarFotoartigoFrontend = $auth->createPermission('criarFotoartigoFrontend');
        $criarFotoartigoFrontend->description = 'Criar Fotoartigo Frontend';
        $auth->add($criarFotoartigoFrontend);

        $alterarFotoartigoFrontend = $auth->createPermission('alterarFotoartigoFrontend');
        $alterarFotoartigoFrontend->description = 'Alterar Fotoartigo Frontend';
        $auth->add($alterarFotoartigoFrontend);

        $eliminarFotoartigoFrontend = $auth->createPermission('eliminarFotoartigoFrontend');
        $eliminarFotoartigoFrontend->description = 'Eliminar Fotoartigo Frontend';
        $auth->add($eliminarFotoartigoFrontend);
        //FOTOARTIGOCONTROLLER FO

        //LINHASCARRINHOCONTROLLER FO
        $eliminarLinhacarrinhoFrontend = $auth->createPermission('eliminarLinhacarrinhoFrontend');
        $eliminarLinhacarrinhoFrontend->description = 'Eliminar Linhacarrinho Frontend';
        $auth->add($eliminarLinhacarrinhoFrontend);
        //LINHASCARRINHOCONTROLLER FO

        //LINHASVENDACONTROLLER FO
        $verLinhavendaFrontend = $auth->createPermission('verLinhavendaFrontend');
        $verLinhavendaFrontend->description = 'Ver Linhavenda Frontend';
        $auth->add($verLinhavendaFrontend);

        $criarLinhavendaFrontend = $auth->createPermission('criarLinhavendaFrontend');
        $criarLinhavendaFrontend->description = 'Criar Linhavenda Frontend';
        $auth->add($criarLinhavendaFrontend);

        $confirmarEnvioEncomendaFrontend = $auth->createPermission('confirmarEnvioEncomendaFrontend');
        $confirmarEnvioEncomendaFrontend->description = 'Confirmar Envio Encomenda Frontend';
        $auth->add($confirmarEnvioEncomendaFrontend);

        $confirmarRecebimentoEncomendaFrontend = $auth->createPermission('confirmarRecebimentoEncomendaFrontend');
        $confirmarRecebimentoEncomendaFrontend->description = 'Confirmar Recebimento Encomenda Frontend';
        $auth->add($confirmarRecebimentoEncomendaFrontend);
        //LINHASVENDACONTROLLER FO

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


        //VIEW PERMISSIONS
        // member permission
        $verMeuPrefil = $auth->createPermission('verMeuPrefil');
        $verMeuPrefil->description = 'Ver o Meu Perfil';
        $auth->add($verMeuPrefil);

        // member permission
        $verPerfilMembro = $auth->createPermission('verPerfilMembro');
        $verPerfilMembro->description = 'Ver Perfil Membro';
        $auth->add($verPerfilMembro);

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
        //ARTIGOCONTROLLER FO
        $auth->addChild($membro, $criarArtigoMarketplaceFrontend);
        $auth->addChild($membro, $alterarArtigoMarketplaceFrontend);
        $auth->addChild($membro, $eliminarArtigoMarketplaceFrontend);
        //ARTIGOCONTROLLER FO

        //CARRINHOCONTROLLER FO
        $auth->addChild($membro, $verCarrinhoFrontend);
        $auth->addChild($membro, $criarCarrinhoFrontend);
        //CARRINHOCONTROLLER FO

        //CHATCONTROLLER FO
        $auth->addChild($membro, $verChatFrontend);
        $auth->addChild($membro, $verDetalhesChatFrontend);
        $auth->addChild($membro, $criarChatFrontend);
        //CHATCONTROLLER FO

        //FOTOARTIGOCONTROLLER FO
        $auth->addChild($membro, $criarFotoartigoFrontend);
        $auth->addChild($membro, $alterarFotoartigoFrontend);
        $auth->addChild($membro, $eliminarFotoartigoFrontend);
        //FOTOARTIGOCONTROLLER FO

        //LINHASCARRINHOCONTROLLER FO
        $auth->addChild($membro, $eliminarLinhacarrinhoFrontend);
        //LINHASCARRINHOCONTROLLER FO

        //LINHASVENDACONTROLLER FO
        $auth->addChild($membro, $verLinhavendaFrontend);
        $auth->addChild($membro, $criarLinhavendaFrontend);
        $auth->addChild($membro, $confirmarEnvioEncomendaFrontend);
        $auth->addChild($membro, $confirmarRecebimentoEncomendaFrontend);
        //LINHASVENDACONTROLLER FO

        $auth->addChild($membro, $adicionarArtigoCarrinho);
        $auth->addChild($membro, $eliminarArtigoCarrinho);
        $auth->addChild($membro, $alterarDetalhesPerfil);
        $auth->addChild($membro, $adicionarDetalhesPerfil);
        $auth->addChild($membro, $verMeuPrefil);
        $auth->addChild($membro, $verPerfilMembro);
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


        //DENUNCIA CONTROLLER BO
        $auth->addChild($moderador, $verDenunciaBackend);
        $auth->addChild($moderador, $verDetalhesDenunciaBackend);
        $auth->addChild($moderador, $banirMembroBackend);
        $auth->addChild($moderador, $marcarDenunciaResolvidaBackend);
        //DENUNCIA CONTROLLER BO


        //ASSOCIAR PERMISSÕES AO ADMIN
        $auth->addChild($admin, $moderador);

        //SITE CONTROLLER BO
        $auth->addChild($admin, $verDashboardCompletaBackend);
        $auth->addChild($admin, $getInformacoesVendasBackend);
        $auth->addChild($admin, $getInformacoesDenunciasBackend);
        $auth->addChild($moderador, $getInformacoesDenunciasBackend);
        //SITE CONTROLLER BO

        //ARTIGOS PREMIUM BO
        $auth->addChild($admin, $criarArtigoPremiumBackend);
        $auth->addChild($admin, $eliminarArtigoPremiumBackend);
        //ARTIGOS PREMIUM BO

        //LINHAVENDA BO
        $auth->addChild($admin, $verEncomendasLojaBackend);
        $auth->addChild($admin, $confirmarEnvioEncomendasLojaBackend);
        $auth->addChild($admin, $gerarReportEncomendasLojaBackend);
        //LINHAVENDA BO

        //SIDEBAR BO
        $auth->addChild($admin, $verAbaStoreBackend);
        $auth->addChild($admin, $verAbaGeneralBackend);
        //SIDEBAR BO


        //ArtigoController Bo
        $auth->addChild($admin, $criarArtigosLojaBackEnd);
        $auth->addChild($admin, $verArtigosLojaBackEnd);
        $auth->addChild($admin, $verDetalhesArtigosLojaBackEnd);
        $auth->addChild($admin, $alterarArtigosLojaBackEnd);
        $auth->addChild($admin, $eliminarArtigosLojaBackEnd);
        //ArtigoController BO

        //BannerController BO
        $auth->addChild($admin, $criarBannerLoja);
        $auth->addChild($admin, $verBannerLojaBackEnd);
        $auth->addChild($admin, $verDetalhesBannerLojaBackEnd);
        $auth->addChild($admin, $alterarBannerLojaBackend);
        $auth->addChild($admin, $eliminarBannerLojaBackend);
        //BannerController BO


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
        //Estados Backend


        //Métodos Expedição Backend
        $auth->addChild($admin, $verMetodosExpedicaoBackend);
        $auth->addChild($admin, $verDetalhesMetodosExpedicaoBackend);
        $auth->addChild($admin, $criarMetodosExpedicaoBackend);
        $auth->addChild($admin, $alterarMetodosExpedicaoBackend);
        $auth->addChild($admin, $eliminarMetodosExpedicaoBackend);
        //Métodos Expedição Backend


        //Faqs Backend
        $auth->addChild($admin, $verFaqsBackend);
        $auth->addChild($admin, $verDetalhesFaqsBackend);
        $auth->addChild($admin, $criarFaqsBackend);
        $auth->addChild($admin, $alterarFaqsBackend);
        $auth->addChild($admin, $eliminarFaqsBackend);
        //Faqs Backend


        //PlanoController Bo
        $auth->addChild($admin, $verPlanosPremiumBackend);
        $auth->addChild($admin, $verDetalhePlanoPremiumBackend);
        $auth->addChild($admin, $criarPlanoPremiumBackend);
        $auth->addChild($admin, $alterarPlanoPremiumBackend);
        $auth->addChild($admin, $eliminarPlanoPremiumBackend);
        //PlanoController Bo


        //TamanhoController BO
        $auth->addChild($admin, $verTamanhosBackend);
        $auth->addChild($admin, $verDetalhesTamanhosBackend);
        $auth->addChild($admin, $criarTamanhosBackend);
        $auth->addChild($admin, $alterarTamanhosBackend);
        $auth->addChild($admin, $eliminarTamanhosBackend);
        //TamanhoController BO

        //CategoriaController BO
        $auth->addChild($admin, $verCategoriasBackend);
        $auth->addChild($admin, $verDetalhesCategoriasBackend);
        $auth->addChild($admin, $criarCategoriasBackend);
        $auth->addChild($admin, $alterarCategoriasBackend);
        $auth->addChild($admin, $eliminarCategoriasBackend);
        //CategoriaController BO

        //ComissaoController BO
        $auth->addChild($admin, $verComissaoLojaBackEnd);
        $auth->addChild($admin, $verDetalhesComissaoLojaBackEnd);
        $auth->addChild($admin, $criarComissaoLojaBackEnd);
        $auth->addChild($admin, $alterarComissaoLojaBackEnd);
        $auth->addChild($admin, $eliminarComissaoLojaBackEnd);
        //ComissaoController BO

        //IvaController BO
        $auth->addChild($admin, $verIvaLojaBackEnd);
        $auth->addChild($admin, $verDetalhesAIvaLojaBackEnd);
        $auth->addChild($admin, $criarIvaLojaBackEnd);
        $auth->addChild($admin, $alterarIvaLojaBackEnd);
        $auth->addChild($admin, $eliminarIvaLojaBackEnd);
        //IvaController BO

        //FotoArtigoLojaController BO
        $auth->addChild($admin, $criarFotoArtigoLojaBackend);
        $auth->addChild($admin, $eliminarFotoArtigoLojaBackend);
        //FotoArtigoLojaController BO


        $auth->addChild($admin, $verTodosFavoritos);


        // ASSOCIAR AS ROLES A UTILIZADORES (ID)
        $auth->assign($admin, 1);
        $auth->assign($moderador, 2);
        $auth->assign($membro, 21);
        $auth->assign($membro, 20);
    }
}