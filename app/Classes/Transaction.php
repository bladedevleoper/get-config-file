<?php

namespace App\Classes;

use App\Models\Roaster;

class Transaction
{
    protected Roaster $roasterModel;
    public $transactionDate;
    public function __construct(Roaster $roasterModel)
    {
        $this->roasterModel = $roasterModel;
        //can override this in our tests, so making the date testable
        $this->transactionDate = date('m/y');
    }

    public function generateTradeLogEntry($data, $tradePartner): string
    {
        $tradedPlayers = [];

        foreach ($data as $playerInfo) {
            //a form of destructoring an array and assign its values within php
            [$tmp, $playerId] = explode('_', $playerInfo);
            $playerInfo = $this->roasterModel->getById($playerId);
            $comment = "Trade {$tradePartner} {$this->transactionDate}";

            if ($playerInfo['ibl_team'] !== $tradePartner) {
                $tradedPlayers[] = trim($playerInfo['display_name']);
                $this->roasterModel
                    ->updatePlayerTeam($tradePartner, $playerId, $comment);
                $this->roasterModel->makeInactive($playerId);
            }
        }

        return 'Trades ' . implode(', ', $tradedPlayers) . ' to ' . $tradePartner;
    }
}
