<?php
namespace KS;

class ExchangeConfig extends SocketDaemonConfig implements ExchangeConfigInterface
{
    public function getExchangePdoDsn() : string
    {
        return $this->get('exchange-pdo-dsn');
    }
    public function getExchangePdoOptions() : array
    {
        return $this->get('exchange-pdo-options');
    }

    public function getExchangeDbName() : string
    {
        return $this->get('exchange-db-name');
    }

    public function getExchangeDbUsername() : ?string
    {
        return $this->get('exchange-db-username');
    }

    public function getExchangeDbPassword() : ?string
    {
        return $this->get('exchange-db-password');
    }
}

