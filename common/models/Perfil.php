<?php

namespace common\models;

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
            [['saldo', 'saldopendente'], 'double'],
            [['descricao', 'caminhofotoperfil', 'morada', 'nome', 'codigopostal', 'pais', 'cidade'], 'string', 'max' => 150],
            [['codigopostal'], 'match', 'pattern' => '/^\d{4}-\d{3}$/', 'message' => 'The postcode must be in the format 1234-567.'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
            [['banido'], 'boolean'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['updateProfile'] = ['descricao', 'caminhofotoperfil', 'morada', 'nome', 'codigopostal', 'pais', 'cidade'];
        return $scenarios;
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
            'saldo' => 'Saldo',
            'saldopendente' => 'Saldo Pendente',
            'banido' => 'Ban',
            'nome' => 'Nome',
            'codigopostal' => 'Código Postal',
            'pais' => 'País',
            'cidade' => 'Cidade',
        ];
    }


    public function hasImageProfile(){

    }

    public function hasActivePremiumPlano()
    {
        return $this->getClientesplano()
            ->where(['>', 'expira', date('Y-m-d H:i:s')])
            ->exists();
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
        return $this->hasMany(Listachats::class, ['iddestinatario' => 'id']);
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
    public function getCountRates()
    {
        return $this->getAvaliacoes()->count();
    }
    public function getAvgRates()
    {
        $average = $this->getAvaliacoes()->average('escala');
        // Se não houver avaliações, retorna 0, caso contrário, arredonda para 2 casas decimais
        return $average === null ? 0 : round($average, 2);
    }
    public function getMensagempropostas()
    {
        return $this->hasMany(Mensagemproposta::class, ['iduser' => 'id']);
    }



}
