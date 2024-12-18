<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artigos".
 *
 * @property int $id
 * @property string $datacriacao
 * @property string $nome
 * @property string $descricao
 * @property float $precoanuncio
 * @property int $idcomissao
 * @property int $idestado
 * @property int $idmarca
 * @property int $idcategoria
 * @property int $idtamanho
 * @property int $idperfil
 * @property string $tipoartigo
 * @property int $ativo
 *
 * @property Artigospremium $artigospremium
 * @property Chats[] $chats
 * @property Denuncias[] $denuncias
 * @property Favoritos[] $favoritos
 * @property Fotosartigos[] $fotosartigos
 * @property Categoriaartigos $idcategoria0
 * @property Comissoes $idcomissao0
 * @property Estados $idestado0
 * @property Marcas $idmarca0
 * @property Perfils $idperfil0
 * @property Tamanhos $idtamanho0
 * @property Linhascarrinhos[] $linhascarrinhos
 * @property Linhavendas[] $linhavendas
 */
class Artigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'precoanuncio', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'tipoartigo', 'ativo'], 'required'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil'], 'integer'],
            [['precoanuncio'], 'number'],
            [['ativo'], 'boolean'],

            [['idcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriaartigo::class, 'targetAttribute' => ['idcategoria' => 'id']],
            [['idestado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::class, 'targetAttribute' => ['idestado' => 'id']],
            [['idmarca'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::class, 'targetAttribute' => ['idmarca' => 'id']],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idperfil' => 'id']],
            [['idtamanho'], 'exist', 'skipOnError' => true, 'targetClass' => Tamanho::class, 'targetAttribute' => ['idtamanho' => 'id']],
            [['idcomissao'], 'exist', 'skipOnError' => true, 'targetClass' => Comissao::class, 'targetAttribute' => ['idcomissao' => 'id']],
            [['datacriacao'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datacriacao' => 'Datacriacao',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'precoanuncio' => 'Precoanuncio',
            'idcomissao' => 'Idcomissao',
            'idestado' => 'Idestado',
            'idmarca' => 'Idmarca',
            'idcategoria' => 'Idcategoria',
            'idtamanho' => 'Idtamanho',
            'idperfil' => 'Idperfil',
            'tipoartigo' => 'Tipoartigo',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Artigospremium]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigospremium()
    {
        return $this->hasOne(Artigospremium::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Denuncias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenuncias()
    {
        return $this->hasMany(Denuncia::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Fotosartigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFotosartigos()
    {
        return $this->hasMany(Fotosartigo::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Idcategoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdcategoria0()
    {
        return $this->hasOne(Categoriaartigo::class, ['id' => 'idcategoria']);
    }

    /**
     * Gets query for [[Idcomissao0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomissao0()
    {
        return $this->hasOne(Comissao::class, ['id' => 'idcomissao']);
    }

    /**
     * Gets query for [[Idestado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdestado0()
    {
        return $this->hasOne(Estado::class, ['id' => 'idestado']);
    }

    /**
     * Gets query for [[Idmarca0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdmarca0()
    {
        return $this->hasOne(Marca::class, ['id' => 'idmarca']);
    }

    /**
     * Gets query for [[Idperfil0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdperfil0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idperfil']);
    }

    /**
     * Gets query for [[Idtamanho0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdtamanho0()
    {
        return $this->hasOne(Tamanho::class, ['id' => 'idtamanho']);
    }

    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinhos()
    {
        return $this->hasMany(Linhascarrinho::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Linhavendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavenda::class, ['idartigo' => 'id']);
    }



    public function getPrecoComComissao()
    {
        // Obter a comissão associada ao artigo
        $comissao = $this->idcomissao0 ? $this->idcomissao0->comissao : 0;

        // Calcular o preço com a comissão
        $precoComComissao = $this->precoanuncio * (1 + ($comissao / 100));

        return round($precoComComissao, 2);
    }
    public function getPrecoComComissaoFormatado()
    {
        // Chama o método de preço com comissão e formata para o padrão Euro
        return '€ ' . number_format($this->getPrecoComComissao(), 2, ',', '.');
    }
}
