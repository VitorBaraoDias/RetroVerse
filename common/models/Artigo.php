<?php

namespace common\models;

use app\models\Categoriaartigos;
use app\models\Comissoes;
use app\models\Estados;
use app\models\Marcas;
use app\models\Perfils;
use app\models\Tamanhos;

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
            [['nome', 'descricao', 'precoanuncio', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'tipoartigo', 'ativo'], 'required'],
            [['nome', 'descricao', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'ativo'], 'integer'],
            [['precoanuncio'], 'number'],
            [['tipoartigo'], 'string', 'max' => 30],
            [['idcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriaartigos::class, 'targetAttribute' => ['idcategoria' => 'id']],
            [['idestado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['idestado' => 'id']],
            [['idmarca'], 'exist', 'skipOnError' => true, 'targetClass' => Marcas::class, 'targetAttribute' => ['idmarca' => 'id']],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['idperfil' => 'id']],
            [['idtamanho'], 'exist', 'skipOnError' => true, 'targetClass' => Tamanhos::class, 'targetAttribute' => ['idtamanho' => 'id']],
            [['idcomissao'], 'exist', 'skipOnError' => true, 'targetClass' => Comissoes::class, 'targetAttribute' => ['idcomissao' => 'id']],
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
}
