<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();


        // add "verCurso" permission
        $verCurso = $auth->createPermission('verCurso');
        $verCurso->description = 'Ver curso';
        $auth->add($verCurso);

        // add "pesquisarCurso" permission
        $pesquisarCurso = $auth->createPermission('pesquisarCurso');
        $pesquisarCurso->description = 'Pesquisar curso';
        $auth->add($pesquisarCurso);

        // add "criarCurso" permission
        $criarCurso = $auth->createPermission('criarCurso');
        $criarCurso->description = 'Criar curso';
        $auth->add($criarCurso);

        // add "editarCurso" permission
        $editarCurso = $auth->createPermission('editarCurso');
        $editarCurso->description = 'Editar Curso';
        $auth->add($editarCurso);

        // add "apagarCurso" permission
        $apagarCurso = $auth->createPermission('apagarCurso');
        $apagarCurso->description = 'Apagar Curso';
        $auth->add($apagarCurso);

        // add "inscreverEmCurso" permission
        $inscreverEmCurso = $auth->createPermission('inscreverEmCurso');
        $inscreverEmCurso->description = 'Inscrever em Curso';
        $auth->add($inscreverEmCurso);

        // add "marcarCursoFavorito" permission
        $marcarCursoFavorito = $auth->createPermission('marcarCursoFavorito');
        $marcarCursoFavorito->description = 'Marcar Curso como Favorito';
        $auth->add($marcarCursoFavorito);

        // add "avaliarCurso" permission
        $avaliarCurso = $auth->createPermission('avaliarCurso');
        $avaliarCurso->description = 'Avaliar Curso';
        $auth->add($avaliarCurso);

        // add "comentarCurso" permission
        $comentarCurso = $auth->createPermission('comentarCurso');
        $comentarCurso->description = 'Comentar Curso';
        $auth->add($comentarCurso);

        // add "comprarCurso" permission
        $comprarCurso = $auth->createPermission('comprarCurso');
        $comprarCurso->description = 'Comprar Curso';
        $auth->add($comprarCurso);

        // add "adicionarCursoCarrinho" permission
        $adicionarCursoCarrinho = $auth->createPermission('adicionarCursoCarrinho');
        $adicionarCursoCarrinho->description = 'Adicionar Curso ao Carrinho';
        $auth->add($adicionarCursoCarrinho);

        // add "retirarCursoCarrinho" permission
        $retirarCursoCarrinho = $auth->createPermission('retirarCursoCarrinho');
        $retirarCursoCarrinho->description = 'Retirar Curso do Carrinho';
        $auth->add($retirarCursoCarrinho);

        // add "verFatura" permission
        $verFatura = $auth->createPermission('verFatura');
        $verFatura->description = 'Ver Fatura';
        $auth->add($verFatura);

        // add "emitirFatura" permission
        $emitirFatura = $auth->createPermission('emitirFatura');
        $emitirFatura->description = 'Emitir Fatura';
        $auth->add($emitirFatura);

        // add "editarFatura" permission
        $editarFatura = $auth->createPermission('editarFatura');
        $editarFatura->description = 'Editar Fatura';
        $auth->add($editarFatura);

        // add "apagarFatura" permission
        $apagarFatura = $auth->createPermission('apagarFatura');
        $apagarFatura->description = 'Apagar Fatura';
        $auth->add($apagarFatura);

        // add "historicoDeCompras" permission
        $historicoDeCompras = $auth->createPermission('historicoDeCompras');
        $historicoDeCompras->description = 'Historico De Compras';
        $auth->add($historicoDeCompras);

        // add "verQuestionario" permission
        $verQuestionario = $auth->createPermission('verQuestionario');
        $verQuestionario->description = 'Ver Questionario';
        $auth->add($verQuestionario);

        // add "participarQuestionario" permission
        $participarQuestionario = $auth->createPermission('participarQuestionario');
        $participarQuestionario->description = 'Participar no Questionario';
        $auth->add($participarQuestionario);

        // add "criarQuestionario" permission
        $criarQuestionario = $auth->createPermission('criarQuestionario');
        $criarQuestionario->description = 'Criar Questionario';
        $auth->add($criarQuestionario);

        // add "editarQuestionario" permission
        $editarQuestionario = $auth->createPermission('editarQuestionario');
        $editarQuestionario->description = 'Editar Questionario';
        $auth->add($editarQuestionario);

        // add "apagarQuestionario" permission
        $apagarQuestionario = $auth->createPermission('apagarQuestionario');
        $apagarQuestionario->description = 'Apagar Questionario';
        $auth->add($apagarQuestionario);

        // add "verVideo" permission
        $verVideo = $auth->createPermission('verVideo');
        $verVideo->description = 'Ver Vídeo';
        $auth->add($verVideo);

        // add "criarVideo" permission
        $criarVideo = $auth->createPermission('criarVideo');
        $criarVideo->description = 'Criar Video';
        $auth->add($criarVideo);

        // add "editarVideo" permission
        $editarVideo = $auth->createPermission('editarVideo');
        $editarVideo->description = 'Editar Video';
        $auth->add($editarVideo);

        // add "apagarVideo" permission
        $apagarVideo = $auth->createPermission('apagarVideo');
        $apagarVideo->description = 'Apagar Video';
        $auth->add($apagarVideo);

        // add "criarNota" permission
        $criarNota = $auth->createPermission('criarNota');
        $criarNota->description = 'Criar Nota';
        $auth->add($criarNota);

        // add "editarNota" permission
        $editarNota = $auth->createPermission('editarNota');
        $editarNota->description = 'Editar Nota';
        $auth->add($editarNota);

        // add "apagarNota" permission
        $apagarNota = $auth->createPermission('apagarNota');
        $apagarNota->description = 'Apagar Nota';
        $auth->add($apagarNota);

        // add "criarConta" permission
        $criarConta = $auth->createPermission('criarConta');
        $criarConta->description = 'Criar Conta';
        $auth->add($criarConta);

        // add "recuperarPassword" permission
        $recuperarPassword = $auth->createPermission('recuperarPassword');
        $recuperarPassword->description = 'Recuperar Password';
        $auth->add($recuperarPassword);

        // add "verHistoricoRendimento" permission
        $verHistoricoRendimento = $auth->createPermission('verHistoricoRendimento');
        $verHistoricoRendimento->description = 'Ver Historico Rendimento';
        $auth->add($verHistoricoRendimento);

        // add "banirUtilizador" permission
        $banirUtilizador = $auth->createPermission('banirUtilizador');
        $banirUtilizador->description = 'Banir Utilizador';
        $auth->add($banirUtilizador);

        // add "personalizarPaginaInicial" permission
        $personalizarPaginaInicial = $auth->createPermission('personalizarPaginaInicial');
        $personalizarPaginaInicial->description = 'Personalizar Pagina Inicial';
        $auth->add($personalizarPaginaInicial);

        // add "reembolsar" permission
        $reembolsar = $auth->createPermission('reembolsar');
        $reembolsar->description = 'Reembolsar Curso';
        $auth->add($reembolsar);


        // add "admin" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $verCurso);
        $auth->addChild($admin, $pesquisarCurso);
        $auth->addChild($admin, $apagarCurso);
        $auth->addChild($admin, $verQuestionario);
        $auth->addChild($admin, $apagarQuestionario);
        $auth->addChild($admin, $verVideo);
        $auth->addChild($admin, $apagarVideo);
        $auth->addChild($admin, $apagarNota);
        $auth->addChild($admin, $banirUtilizador);
        $auth->addChild($admin, $personalizarPaginaInicial);
        $auth->addChild($admin, $reembolsar);

        // add "estudante" role
        $estudante = $auth->createRole('estudante');
        $auth->add($estudante);
        $auth->addChild($estudante, $verCurso);
        $auth->addChild($estudante, $pesquisarCurso);
        $auth->addChild($estudante, $inscreverEmCurso);
        $auth->addChild($estudante, $marcarCursoFavorito);
        $auth->addChild($estudante, $avaliarCurso);
        $auth->addChild($estudante, $comentarCurso);
        $auth->addChild($estudante, $comprarCurso);
        $auth->addChild($estudante, $adicionarCursoCarrinho);
        $auth->addChild($estudante, $retirarCursoCarrinho);
        $auth->addChild($estudante, $verFatura);
        $auth->addChild($estudante, $historicoDeCompras);
        $auth->addChild($estudante, $verQuestionario);
        $auth->addChild($estudante, $participarQuestionario);
        $auth->addChild($estudante, $verVideo);
        $auth->addChild($estudante, $criarNota);
        $auth->addChild($estudante, $editarNota);
        $auth->addChild($estudante, $apagarNota);


        // add "instrutor" role
        $instrutor = $auth->createRole('instrutor');
        $auth->add($instrutor);
        $auth->addChild($instrutor, $criarCurso);
        $auth->addChild($instrutor, $editarCurso);
        $auth->addChild($instrutor, $apagarCurso);
        $auth->addChild($instrutor, $criarQuestionario);
        $auth->addChild($instrutor, $editarQuestionario);
        $auth->addChild($instrutor, $apagarQuestionario);
        $auth->addChild($instrutor, $criarVideo);
        $auth->addChild($instrutor, $editarVideo);
        $auth->addChild($instrutor, $apagarVideo);
        $auth->addChild($instrutor, $verHistoricoRendimento);
        $auth->addChild($instrutor, $estudante);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 8);
    }
}