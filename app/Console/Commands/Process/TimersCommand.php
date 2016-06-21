<?php

namespace App\Console\Commands\Process;

use App\Domain\AuctionActions;
use App\Domain\Process\EmploymentResultCalculator;
use App\Models\Macro\Resources;
use App\Models\Macro\Timer;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TimersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:timers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiredTimers = Timer::where(DB::raw('TIMESTAMPDIFF(SECOND, now(), process_timers.date_time)'), '<', 0)
            ->select('id', 'user_id', 'kind', 'people_count')
            ->get();

        foreach ($expiredTimers as $timer) {
            try {

                $res = Resources::find($timer->user_id);

                // ставка за 1 рабочего + учет времени todo
//                $resValue = (2 * (int) $timer->people_count);
                $resValue = EmploymentResultCalculator::calculateFoodObtain($timer->people_count, 2);
                switch($timer->kind) {
                    case 'obtain_food':
                        $res->food += $resValue;
                        break;
                    case 'obtain_tree':
                        $res->tree += $resValue;
                        break;
                    case 'obtain_water':
                        $res->water += $resValue;
                        break;

                    default:
                        break;
                }
                DB::beginTransaction();

                $res->free_people += $timer->people_count;

                $res->save();
                $timer->delete();
            }
            catch (Exception $e) {
                DB::rollback();
            }
            DB::commit();
        }

    }
}
