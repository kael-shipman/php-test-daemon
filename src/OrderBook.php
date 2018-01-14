<?php
namespace KS;

class OrderBook
{
    protected $config;
    protected $db;
    protected $activeOrders;
    protected $timer;

    public function __construct(ExchangeConfigInterface $config)
    {
        $this->config = $config;

        $dbname = $this->config->getExchangeDbName();
        $dsn = $this->config->getExchangePdoDsn();

        if (strpos($dsn, 'dbname=') !== false) {
            if ($this->getExchangeDbName()) {
                throw new ConfigException(
                    "Database name is specified in the DSN as well as in the `exchange-db-name` config. ".
                    "You must put it in one or the other, but not both."
                );
            }
        } else {
            $dsn .= ';dbname='.$this->config->getExchangeDbName();
        }

        /*
        $this->db = new \PDO(
            $dsn,
            $this->config->getExchangeDbUsername(),
            $this->config->getExchangeDbPassword(),
            $this->config->getExchangePdoOptions()
        );

        $this->activeOrders = $this->db->query("SELECT * FROM `exchange_orders` WHERE `status` = 'active'")->fetchAll(\PDO::FETCH_ASSOC);
         */

        $this->activeOrders = [
            [
                'type' => 'orders',
                'id' => 'abc123',
                'attributes' => [
                    'side' => 'buy',
                    'type' => 'market',
                    'lotSize' => 1234,
                    'priceHigh' => 2.46,
                    'priceLow' => null,
                    'referenceKey' => '12345abcde',
                ],
                'relationships' => [
                    'asset' => [
                        'type' => 'assets',
                        'id' => 'INVT001',
                    ],
                    'brokerage' => [
                        'type' => 'brokerages',
                        'id' => 'aaabbbcccddd3333',
                    ],
                ],
            ],
        ];
    }

    public function createOrder(array $data) : void
    {
        $this->activeOrders[] = $data;
    }

    public function getOrder($id) : array
    {
        foreach ($this->activeOrders as $order) {
            if ($order['id'] === $id) {
                return $order;
            }
        }

        throw new ResourceNotFoundException("Couldn't find order with id `$id`", 404);
    }
}

