<?php

declare(strict_types=1);

namespace App\DTO;

class DealDTO
{
    public string $dealName;
    public string $dealStage;
    public string $closingDate;
    public string $accountName;

    /**
     * @return string
     */
    public function getDealName(): string
    {
        return $this->dealName;
    }

    /**
     * @param string $dealName
     */
    public function setDealName(string $dealName): void
    {
        $this->dealName = $dealName;
    }

    /**
     * @return string
     */
    public function getDealStage(): string
    {
        return $this->dealStage;
    }

    /**
     * @param string $dealStage
     */
    public function setDealStage(string $dealStage): void
    {
        $this->dealStage = $dealStage;
    }

    /**
     * @return string
     */
    public function getClosingDate(): string
    {
        return $this->closingDate;
    }

    /**
     * @param string $closingDate
     */
    public function setClosingDate(string $closingDate): void
    {
        $this->closingDate = $closingDate;
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return $this->accountName;
    }

    /**
     * @param string $accountName
     */
    public function setAccountName(string $accountName): void
    {
        $this->accountName = $accountName;
    }

}
