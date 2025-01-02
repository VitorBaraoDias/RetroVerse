<?php

namespace common\models;

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
            [['idremetente', 'iddestinatario', 'idlinhavenda'], 'integer'],
            [['escala'], 'integer', 'min' => 1, 'max' => 5, 'message' => 'The scale should be from 0 to 5!'],
            [['iddestinatario'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['iddestinatario' => 'id']],
            [['idremetente'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idremetente' => 'id']],
            [['idlinhavenda'], 'exist', 'skipOnError' => true, 'targetClass' => Linhavenda::class, 'targetAttribute' => ['idlinhavenda' => 'id']],
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
    public function getDistinatarrio()
    {
        return $this->hasOne(Perfil::class, ['id' => 'iddestinatario']);
    }

    /**
     * Gets query for [[Idlinhavenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavenda()
    {
        return $this->hasOne(Linhavenda::class, ['id' => 'idlinhavenda']);
    }

    /**
     * Gets query for [[Idremetente0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemetente()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idremetente']);
    }
}
