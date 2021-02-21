<?php declare(strict_types=1);
namespace App\Tests\Unit;

use \Aura\SqlQuery\QueryFactory;
use PHPUnit\Framework\TestCase;
use App\Classes\Transaction;
use App\Models\Roaster;

class TransactionsTest extends TestCase
{
    /** @test */
    public function it_generates_proper_transaction_info_for_a_trade(): void
    {
        //test Scenario
        //Given I have an array that contains players
        //When I submit a list of players
        //And I submit a transaction description
        //Then I should get a one-line transaction generated

        //Arrange
        $expected = 'Trades Moe, Larry, Curly to TEST';
        $tradePartner = 'TEST';
        $tradeComment = 'Trade TESTMORE 01/01';
       //Data contains compound IDs of <trade partner 1>_<player_id>
        $data = ['team1_1', 'team1_2', 'team1_3'];
        $playerIds = [1, 2, 3];
        $rm = $this->prophesize(Roaster::class);
      //Mocking the getById method and its return value
        $rm->getById($playerIds[0])
            ->willReturn(
                ['ibl_team' => 'TEST',
                'display_name' => 'Moe']);
        $rm->getById($playerIds[1])
            ->willReturn(['ibl_team' => 'TEST',
                    'display_name' => 'Larry']);
        $rm->getById($playerIds[2])
            ->willReturn([ 'ibl_team' => 'TEST',
                    'display_name' => 'Curly']);


        //Create our updatePlayerTeam test spies
        $rm->updatePlayerTeam($tradePartner, $playerIds[0], $tradeComment)->shouldBeCalled();
        $rm->updatePlayerTeam($tradePartner, $playerIds[1], $tradeComment)->shouldBeCalled();
        $rm->updatePlayerTeam($tradePartner, $playerIds[2], $tradeComment)->shouldBeCalled();

        //test spies for makeInactive
        $rm->makeInactive($playerIds[0])->shouldBeCalled();
        $rm->makeInactive($playerIds[1])->shouldBeCalled();
        $rm->makeInactive($playerIds[2])->shouldBeCalled();


        $tm = new Transaction($rm->reveal());
        $tm->transactionDate = '01/01';

        //Act
        $response = $tm->generateTradeLogEntry($data, $tradePartner);
        //Assert
        $this->assertEquals($expected, $response);
    }
}

