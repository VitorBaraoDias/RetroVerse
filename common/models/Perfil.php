<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfils".
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $caminhofotoperfil
 * @property string|null $morada
 *
 * @property Artigos[] $artigos
 * @property Avaliacoes[] $avaliacoes
 * @property Avaliacoes[] $avaliacoes0
 * @property Chats[] $chats
 * @property Chats[] $chats0
 * @property Clientesplanos[] $clientesplanos
 * @property Cupoesutilizados[] $cupoesutilizados
 * @property Denuncias[] $denuncias
 * @property Denuncias[] $denuncias0
 * @property Favoritos[] $favoritos
 * @property User $id0
 * @property Linhavendas[] $linhavendas
 * @property Seguidores[] $seguidores
 * @property Seguidores[] $seguidores0
 * @property Vendas[] $vendas
 */
class Perfil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfils';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['saldo', 'saldopendente'], 'integer'], // Validação para os campos saldo e saldopendente
            [['descricao', 'caminhofotoperfil', 'morada'], 'string', 'max' => 150],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'caminhofotoperfil' => 'Caminho Foto Perfil',
            'morada' => 'Morada',
            'saldo' => 'Saldo', // Rótulo para saldo
            'saldopendente' => 'Saldo Pendente', // Rótulo para saldopendente
        ];
    }


    public function hasImageProfile(){

    }

    public function hasActivePremiumPlano()
    {
        return $this->getClientesplano()
            ->where(['>', 'expira', date('Y-m-d H:i:s')]) // Plano ainda ativo
            ->exists(); // Verifica se existe pelo menos um registro
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigo::class, ['idperfil' => 'id']);
    }

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['iddestinatario' => 'id']);
    }

    /**
     * Gets query for [[Avaliacoes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes0()
    {
        return $this->hasMany(Avaliacao::class, ['idremetente' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['iddestinatario' => 'id']);
    }

    /**
     * Gets query for [[Chats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chats::class, ['idremetente' => 'id']);
    }

    /**
     * Gets query for [[Clientesplanos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientesplano()
    {
        return $this->hasOne(Clientesplano::class, ['idperfil' => 'id']);
    }

    /**
     * Gets query for [[Cupoesutilizados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCupoesutilizados()
    {
        return $this->hasMany(Cupoesutilizado::class, ['idperfil' => 'id']);
    }

    /**
     * Gets query for [[Denuncias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenuncias()
    {
        return $this->hasMany(Denuncia::class, ['iddenunciado' => 'id']);
    }

    /**
     * Gets query for [[Denuncias0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenuncias0()
    {
        return $this->hasMany(Denuncia::class, ['iddenunciante' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['idperfil' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Linhavendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavenda::class, ['idvendedor' => 'id']);
    }

    /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Seguidore::class, ['idperfil' => 'id']);
    }

    /**
     * Gets query for [[Seguidores0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores0()
    {
        return $this->hasMany(Seguidore::class, ['idseguidor' => 'id']);
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Venda::class, ['idcomprador' => 'id']);
    }
}
