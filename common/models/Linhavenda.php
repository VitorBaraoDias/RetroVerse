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
 * @property int|null $idestadoencomenda
 *
 * @property Artigos $idartigo0
 * @property Estadoencomendas $idestadoencomenda0
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
            [['idvenda', 'idartigo', 'idvendedor', 'idestadoencomenda'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['idvenda'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::class, 'targetAttribute' => ['idvenda' => 'id']],
            [['idvendedor'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idvendedor' => 'id']],
            [['idestadoencomenda'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoencomenda::class, 'targetAttribute' => ['idestadoencomenda' => 'id']],
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
            'idestadoencomenda' => 'Idestadoencomenda',
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
     * Gets query for [[Idestadoencomenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdestadoencomenda0()
    {
        return $this->hasOne(Estadoencomenda::class, ['id' => 'idestadoencomenda']);
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
    public function getAvaliacao()
    {
        return $this->hasOne(Avaliacao::class, ['idlinhavenda' => 'id']);
    }
    public static function getVendasMensaisPorTipoArtigo($tipoArtigo)
    {
        // Consulta SQL para contar as vendas por mês
        $salesData = Yii::$app->db->createCommand('
    SELECT YEAR(a.datacriacao) AS ano, MONTH(a.datacriacao) AS mes, COUNT(*) AS quantidade_vendas
    FROM linhavendas l
    INNER JOIN artigos a ON l.idartigo = a.id
    WHERE a.tipoartigo = :tipoArtigo
    GROUP BY ano, mes
    ORDER BY ano, mes
')
            ->bindValue(':tipoArtigo', $tipoArtigo)  // Vincula o parâmetro :tipoArtigo
            ->queryAll();  // Executa a consulta e retorna os resultados


        // Inicializando o array de vendas mensais (1 a 12)
        $salesArray = array_fill(1, 12, 0);  // Preencher com 0 para todos os meses

        // Preencher o array com os dados retornados
        foreach ($salesData as $sale) {
            $month = $sale['mes'];
            $salesArray[$month] = $sale['quantidade_vendas'];
        }

        // Retornar as vendas mensais (de 1 a 12)

        return array_values($salesArray);
    }
    public static function getMarcasMaisVendidas()
    {
        // Consulta SQL para contar as vendas por marca (artigo)
        $salesData = Yii::$app->db->createCommand('
        SELECT a.idmarca, m.nome AS marca, COUNT(*) AS quantidade_vendas
        FROM linhavendas lv
        INNER JOIN artigos a ON lv.idartigo = a.id
        INNER JOIN marcas m ON a.idmarca = m.id
        GROUP BY a.idmarca
        ORDER BY quantidade_vendas DESC
    ')
            ->queryAll();  // Executa a consulta e retorna os resultados

        // Extrair os dados em arrays separados para as marcas e as quantidades de vendas
        $marcas = [];
        $quantidadeVendas = [];

        foreach ($salesData as $sale) {
            $marcas[] = $sale['marca'];  // Nome da marca
            $quantidadeVendas[] = $sale['quantidade_vendas'];  // Quantidade de vendas
        }

        // Retornar os dados como arrays
        return [
            'marcas' => $marcas,
            'quantidade_vendas' => $quantidadeVendas,
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $myJSON = "Your item {$this->idartigo0->nome} from {$this->idartigo0->idmarca0->nome} was sold for {$this->idartigo0->getPriceWithProposalIfExist()}€ to @{$this->idvenda0->comprador->user->username}!";
            $topic = "notificacoes/vendas/{$this->idvendedor}";
            $this->FazPublishNoMosquitto($topic, $myJSON);
        }
    }

    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = Yii::$app->user->identity->username;
        $password = "";
        $client_id = Yii::$app->user->identity ? Yii::$app->user->identity->id : 'guest';
        $mqtt = new \Bluerhinos\phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
        else { file_put_contents("debug.output","Time out!"); }
    }

}
