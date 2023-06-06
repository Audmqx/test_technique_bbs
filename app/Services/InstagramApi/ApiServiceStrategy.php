<?php

namespace App\Services\InstagramApi;

use App\Contracts\InstagramApiStrategyInterface;

class ApiServiceStrategy
{
    private $strategy;

    public function setStrategy(InstagramApiStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function execute()
    {
        return $this->strategy->execute();
    }
}