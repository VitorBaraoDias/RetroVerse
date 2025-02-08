<?php

namespace common\models;

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
            [['iduser'], 'unique'],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['iduser' => 'id']],
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
        $userId = $this->iduser;
        $linhasCarrinho = $this->getLinhascarrinhos()->all();
        $totalVenda = 0;


        $perfil = Perfil::findOne(['id' => $userId]);


        $isPremium = $perfil && $perfil->hasActivePremiumPlano();


        foreach ($linhasCarrinho as $linha) {
            $artigo = $linha->artigo;

            if ($artigo->tipoartigo === 'MARKETPLACE' && $artigo->idcomissao0) {
                if ($isPremium) {
                    $totalVenda += $artigo->getPriceWithProposalIfExist();
                } else {
                    $precoComComissao = $artigo->getPriceWithCommissionOrProposal();
                    $totalVenda += $precoComComissao;
                }
            } else {

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
