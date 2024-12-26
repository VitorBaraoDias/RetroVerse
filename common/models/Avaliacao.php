<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacoes".
 *
 * @property int $id
 * @property int $descricao
 * @property string $escala
 * @property int $idremetente
 * @property int $iddestinatario
 * @property int $idlinhavenda
 *
 * @property Perfils $iddestinatario0
 * @property Linhavendas $idlinhavenda0
 * @property Perfils $idremetente0
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'escala', 'idremetente', 'iddestinatario', 'idlinhavenda'], 'required'],
            [['descricao', 'idremetente', 'iddestinatario', 'idlinhavenda'], 'integer'],
            [['escala'], 'string', 'max' => 30],
            [['iddestinatario'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['iddestinatario' => 'id']],
            [['idremetente'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['idremetente' => 'id']],
            [['idlinhavenda'], 'exist', 'skipOnError' => true, 'targetClass' => Linhavendas::class, 'targetAttribute' => ['idlinhavenda' => 'id']],
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
            'escala' => 'Escala',
            'idremetente' => 'Idremetente',
            'iddestinatario' => 'Iddestinatario',
            'idlinhavenda' => 'Idlinhavenda',
        ];
    }

    /**
     * Gets query for [[Iddestinatario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIddestinatario0()
    {
        return $this->hasOne(Perfils::class, ['id' => 'iddestinatario']);
    }

    /**
     * Gets query for [[Idlinhavenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdlinhavenda0()
    {
        return $this->hasOne(Linhavendas::class, ['id' => 'idlinhavenda']);
    }

    /**
     * Gets query for [[Idremetente0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdremetente0()
    {
        return $this->hasOne(Perfils::class, ['id' => 'idremetente']);
    }
}
