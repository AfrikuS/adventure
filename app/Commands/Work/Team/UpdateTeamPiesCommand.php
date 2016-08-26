<?php

namespace App\Commands\Work\Team;

use App\Models\Work\Team\TeamRewardPie;
use App\Repositories\Work\PrivateTeamRepository;
use Illuminate\Support\Collection;

class UpdateTeamPiesCommand
{
    /** @var  PrivateTeamRepository */
    private $teamRepo;

    public function __construct(PrivateTeamRepository $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    public function updateTeamPies($team_id)
    {
        $teamWithPartners = $this->teamRepo->findTeamWithPartnersById($team_id);

        /** @var  Collection $partners */
        $partners = $teamWithPartners->partners;
        $partners_ids = $partners->map(function ($partner) {
            return $partner->id;
        })->toArray();
        
        $piePercentAverage = (int) 100 / $partners->count();

//        $pies = TeamRewardPie::where('team_id', $team_id)->get();

//        $pies->search(function ($pie, $key) use ($partners_ids) {
//            return in_array($pie->worker_id, $partners_ids);
//        });

        foreach ($partners as $partner) {
            $pie = TeamRewardPie::where('team_id', $team_id)->where('worker_id', $partner->id)->first();
            
            if ($pie !== null) {
                $pie->update([
                    'amount_percent' => $piePercentAverage,
                ]);
            }
            else {
                TeamRewardPie::create([
                    'team_id' => $team_id,
                    'worker_id' => $partner->id,
                    'amount_percent' => $piePercentAverage,
                ]);
            }
        }

    }
}
