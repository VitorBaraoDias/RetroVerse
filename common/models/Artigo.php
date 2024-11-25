<?php

namespace common\models;

use common\models\Categoriaartigo;
use common\models\Comissao;
use common\models\Estado;
use common\models\Marca;
use common\models\Perfil;
use common\models\Tamanho;

/**
 * This is the model class for table "Artigos".
 *
 * @property int $id
 * @property int $nome
 * @property int $descricao
 * @property float $precoanuncio
 * @property int $idcomissao
 * @property int $idestado
 * @property int $idmarca
 * @property int $idcategoria
 * @property int $idtamanho
 * @property int $idperfil
 * @property string $tipoartigo
 * @property int $ativo
 */
class Artigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Artigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Campos obrigatórios
            [['nome', 'descricao', 'precoanuncio', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'tipoartigo', 'ativo'], 'required'],

            // Validação de tipo
            [['nome', 'descricao'], 'string', 'max' => 255], // Limite de caracteres para campos VARCHAR
            [['idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil'], 'integer'],
            [['precoanuncio'], 'number'],
            [['ativo'], 'boolean'],

            // Validação para tipoartigo
            [['tipoartigo'], 'in', 'range' => ['MARKETPLACE', 'Loja'], 'message' => 'O tipo de artigo deve ser "MARKETPLACE" ou "Loja".'],

            // Validação de existência nas tabelas relacionadas
            [['idcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriaartigo::class, 'targetAttribute' => ['idcategoria' => 'id']],
            [['idestado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::class, 'targetAttribute' => ['idestado' => 'id']],
            [['idmarca'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::class, 'targetAttribute' => ['idmarca' => 'id']],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idperfil' => 'id']],
            [['idtamanho'], 'exist', 'skipOnError' => true, 'targetClass' => Tamanho::class, 'targetAttribute' => ['idtamanho' => 'id']],
            [['idcomissao'], 'exist', 'skipOnError' => true, 'targetClass' => Comissao::class, 'targetAttribute' => ['idcomissao' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
        return $this->hasMany(Denuncias::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Fotosartigo::class, ['idartigo' => 'id']);
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
        return $this->hasMany(Linhascarrinhos::class, ['idartigo' => 'id']);
    }

    /**
     * Gets query for [[Linhavendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavendas::class, ['idartigo' => 'id']);
    }
}
