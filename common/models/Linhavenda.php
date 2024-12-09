<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhavendas".
 *
 * @property int $id
 * @property int $idvenda
 * @property int $idartigo
 * @property int $idvendedor
 *
 * @property Artigos $idartigo0
 * @property Vendas $idvenda0
 * @property Perfils $idvendedor0
 */
class Linhavenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhavendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idvenda', 'idartigo', 'idvendedor'], 'required'],
            [['idvenda', 'idartigo', 'idvendedor'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['idvenda'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::class, 'targetAttribute' => ['idvenda' => 'id']],
            [['idvendedor'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idvendedor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idvenda' => 'Idvenda',
            'idartigo' => 'Idartigo',
            'idvendedor' => 'Idvendedor',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdartigo0()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }

    /**
     * Gets query for [[Idvenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdvenda0()
    {
        return $this->hasOne(Venda::class, ['id' => 'idvenda']);
    }

    /**
     * Gets query for [[Idvendedor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdvendedor0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idvendedor']);
    }
}
