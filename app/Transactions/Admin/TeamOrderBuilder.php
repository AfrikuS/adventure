<?php

namespace App\Transactions\Admin;

use App\Models\Work\Catalogs\WorkMaterial;
use App\Models\Work\Catalogs\WorkSkill;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Repositories\Work\CatalogsRepository;

class TeamOrderBuilder
{
    private $materialsIds;
    private $skillsIds;
    private $instrumentsIds;

    /**
     * OrderConstructor constructor.
     * @param $data
     */
    public function __construct(array $data)
    {
//        $this->requestData = $requestData;

        $this->materialsIds =  isset($data['materials']) ? $data['materials'] : [];
        $this->skillsIds =  isset($data['skills']) ? $data['skills'] : [];
        $this->instrumentsIds =  isset($data['instruments']) ? $data['instruments'] : [];
    }

    public function createOrder()
    {
        \DB::transaction(function ()  {
            $order = $this->createSimpleOrder();
            
            if (count($this->materialsIds) > 0) {
                $materials = WorkMaterial::whereIn('id', $this->materialsIds)->get();
                
                $materials->each(function ($material, $key) use ($order) {
                    $this->createMaterial($order, $material->code, 8);
                });
            }
            
            if (count($this->skillsIds) > 0) {
                $materials = WorkSkill::whereIn('id', $this->skillsIds)->get();
                
                $materials->each(function ($skill, $key) use ($order) {
                    $this->createSkill($order, $skill->code, 8);
                });
            }
        });
    }

    private function createSimpleOrder()
    {
        $desc = 'order_desc';
        return TeamOrder::create([
            'desc' => $desc,
            'kind_work' => 'not populated',
            'price' => rand(74, 90),
            'acceptor_team_id' => null,
            'status' => 'draft' // accept -> user_id
        ]);
    }

    public function createMaterial(TeamOrder $order, string $code, $need)
    {
        TeamOrderMaterial::create([
            'teamorder_id' => $order->id,
            'code' => $code,
            'need' => $need,
            'stock' => 0,
        ]);
    }

    public function createSkill(TeamOrder $order, string $code, $need_stock)
    {
        TeamOrderSkill::create([
            'teamorder_id' => $order->id,
            'code' => $code,
            'need' => $need_stock,
            'stock' => 0,
        ]);
    }

    public static function updateCheckedMaterials(TeamOrder $orderDraft, array $checkedMaterialsCodes)
    {
        \DB::transaction(function () use ($orderDraft, $checkedMaterialsCodes) {
            $orderMaterialsCodes = $orderDraft->materials()->select('code')->get()->lists('code')->toArray();

            // удялить те, к-ые есть в старом но нет в новом
            $deleteMaterialsCodes = array_diff($orderMaterialsCodes, $checkedMaterialsCodes);
            if (count($deleteMaterialsCodes) > 0) {

                $orderDraft->materials()->whereIn('code', $deleteMaterialsCodes)->delete();
            }

            foreach ($checkedMaterialsCodes as $checkedCode) {
                if (!in_array($checkedCode, $orderMaterialsCodes)) {

                    // add checked to order_materials
                    $checkedMaterial = CatalogsRepository::createTeamOrderMaterial($orderDraft, $checkedCode);
                    $orderDraft->materials->push($checkedMaterial);
                }
            }

        });
    }
    public static function updateCheckedSkills(TeamOrder $orderDraft, array $checkedSkillsCodes)
    {
        \DB::transaction(function () use ($orderDraft, $checkedSkillsCodes) {
            $orderSkillsCodes = $orderDraft->skills()->select('code')->get()->lists('code')->toArray();

            // удялить те, к-ые есть в старом но нет в новом
            $deleteSkillsCodes = array_diff($orderSkillsCodes, $checkedSkillsCodes);
            if (count($deleteSkillsCodes) > 0) {

                $orderDraft->skills()->whereIn('code', $deleteSkillsCodes)->delete();
            }

            foreach ($checkedSkillsCodes as $checkedCode) {
                if (!in_array($checkedCode, $orderSkillsCodes)) {

                    // add checked to order_skills
                    $checkedSkill = CatalogsRepository::createTeamOrderSkill($orderDraft, $checkedCode);
                    $orderDraft->skills->push($checkedSkill);
                }
            }

        });
    }

}
