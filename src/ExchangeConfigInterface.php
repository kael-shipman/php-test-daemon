<?php
namespace KS;

interface ExchangeConfigInterface extends \KS\BaseConfigInterface
{
    public function getExchangePdoDsn() : string;
    public function getExchangePdoOptions() : array;
    public function getExchangeDbName() : string;
    public function getExchangeDbUsername() : ?string;
    public function getExchangeDbPassword() : ?string;
}

