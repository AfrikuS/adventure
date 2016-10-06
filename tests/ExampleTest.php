<?php

use App\Modules\Oil\Actions\Equipment\OilPumpUpgradeAction;
use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Persistence\Dao\EquipmentsDao;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/sign_in')
             ->see('Sign In Page');

        $this->assertTrue(true);
        $this->assertPageLoaded('/sign_in');
    }

    public function testOilPumpUpgrade()
    {
        $hero_id = 8;

        $oilPumpStub = new stdClass();
        $oilPumpStub->hero_id = 8;
        $oilPumpStub->level = 1;


        $handMock = $this->mock(EquipmentsDao::class);
//        $handMock = $this->getMockBuilder(EquipmentsDao::class);
//        $handMock->setMethods(['get_last_card'])
//            ->getMock();


//        $handStub = $this->createMock(EquipmentsDao::class);
        $handMock->shouldReceive('findOilPumpBy')->with($hero_id)->once()->andReturn($oilPumpStub);
//        $handMock->method('findOilPumpBy')->willReturn($oilPumpStub);
        $handMock->shouldReceive('updatePump')->once()->andReturn(true);




//        $oilPump = new OilPump($oilPumpStub);
//        $oilPump->upgradeLevel();


//        $this->assertEquals(7, $oilPump->level);

        $action = new OilPumpUpgradeAction();
        $action->upgrade($hero_id);
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }
}
