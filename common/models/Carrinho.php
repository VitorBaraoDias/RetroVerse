<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property int $iduser
 *
 * @property Linhascarrinhos[] $linhascarrinhos
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser'], 'required'],
            [['iduser'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iduser' => 'Iduser',
        ];
    }

    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinhos()
    {
        return $this->hasMany(Linhascarrinho::class, ['idcarrinho' => 'id']);
    }

    public function getTotalVenda()
    {
        $linhasCarrinho = $this->getLinhascarrinhos()->all(); // Obtém todas as linhas do carrinho
        $totalVenda = 0;

        foreach ($linhasCarrinho as $linha) {
            $artigo = $linha->artigo;

            if ($artigo->tipoartigo === 'MARKETPLACE' && $artigo->idcomissao0) {
                // Aplica a comissão ao preço se o artigo for do tipo MARKETPLACE
                $precoComComissao = round($artigo->precoanuncio * (1 + $artigo->idcomissao0->comissao / 100), 2);
                $totalVenda += $precoComComissao;
            } else {
                // Sem comissão, apenas soma o preço normal
                $totalVenda += $artigo->precoanuncio;
            }
        }

        return $totalVenda;
    }

    public function ifExistsCart()
    {
        return $this !== null && $this->getLinhascarrinhos()->exists();
    }
}
