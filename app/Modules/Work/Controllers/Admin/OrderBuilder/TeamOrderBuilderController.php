<?php

namespace App\Modules\Work\Controllers\Admin\OrderBuilder;

use App\Commands\Work\OrderBuilder\CreateEmptyTeamOrderCommand;
use App\Commands\Work\OrderBuilder\DeleteTeamOrderDraftCommand;
use App\Commands\Work\OrderBuilder\ReCheckMaterialsCommand;
use App\Commands\Work\OrderBuilder\ReCheckSkillsCommand;
use App\Commands\Work\OrderBuilder\SettingMaterialsValuesCommand;
use App\Commands\Work\OrderBuilder\SettingOrderDataCommand;
use App\Commands\Work\OrderBuilder\SettingSkillsValuesCommand;
use App\Http\Controllers\Controller;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use Illuminate\Support\Facades\Input;

class TeamOrderBuilderController extends Controller
{
    /** @var TeamOrderRepositoryObj */
    protected $teamOrderRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
        
        parent::__construct();
    }

    public function orderDrafts()
    {
        $draftOrders = $this->teamOrderRepo->getOrdersDrafts();

        return $this->view('admin.orders.drafts', [
            'draftOrders' => $draftOrders,
        ]);
    }

    public function createOrderDraft()
    {
        $cmd = new CreateEmptyTeamOrderCommand($this->teamOrderRepo);

        $draft = $cmd->createEmptyTeamOrder();

        return \Redirect::route('teamorder_draft_select_requires_page', ['id' => $draft->id]);
    }


    public function selectRequirements($id)
    {
        $orderDraft = $this->teamOrderRepo->findOrderDraft($id);

        $orderMaterialsCodes = $orderDraft->getMaterialsCodes();

        $orderSkillsCodes = $orderDraft->getSkillsCodes();
        $orderIstrumentsCodes = [];

        $materials = Material::get();
        $instruments = Instrument::get();
        $skills = Skill::get();

        return $this->view('admin.orders.select_requires', [
            'draft' => $orderDraft,
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
            'orderMaterialsCodes' => $orderMaterialsCodes,
            'orderSkillsCodes' => $orderSkillsCodes,
            'orderIstrumentsCodes' => $orderIstrumentsCodes,
            'orderDraft' => $orderDraft,
        ]);
    }

    public function setRequirements ()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $orderDraft = $this->teamOrderRepo->findOrderDraft($draft_id);

        // update/re-check draft-order materials
        if (isset($data['materials'])) {

            $checkedMaterialsCodes = $data['materials'];

            $cmd = new ReCheckMaterialsCommand($this->teamOrderRepo);
            
            $cmd->reCheckMaterials($orderDraft, $checkedMaterialsCodes);
        }
        else 
        {
            $this->teamOrderRepo->deleteOrderMaterials($orderDraft);
        }

        // update/re-check draft-order skills
        if (isset($data['skills'])) {
            
            $checkedSkillsCodes = $data['skills'];

            $cmd = new ReCheckSkillsCommand(/*$this->teamOrderRepo*/);

            $cmd->reCheckSkills($orderDraft, $checkedSkillsCodes);
        }
        else 
        {
            $this->teamOrderRepo->deleteOrderSkills($orderDraft);
        }

        return \Redirect::route('teamorder_draft_setting_page', ['id' => $orderDraft->id]);
    }


    public function settingValues($id)
    {
        $orderDraft = $this->teamOrderRepo->findOrderDraft($id);

        $draftMaterials = $orderDraft->materials;
        $draftSkills = $orderDraft->skills;
        
        $skills = Skill::get();

        return $this->view('admin.orders.setting_values', [
            'draftMaterials' => $draftMaterials,
            'draftSkills' => $draftSkills,
            'orderDraft' => $orderDraft,
            'draftOrder' => $orderDraft,
            
            'skills' => $skills,
        ]);
    }


    // commands-mutator-entity
    
    public function fillValues()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $orderDraft = $this->teamOrderRepo->findOrderDraft($draft_id);

        if (isset($data['order'])) {

            $cmd = new SettingOrderDataCommand();
            $cmd->fillOrderData($orderDraft, $data['order']);

        }

        if (isset($data['materials'])) {

            $cmd = new SettingMaterialsValuesCommand();
            $cmd->fillMaterialValues($orderDraft, $data['materials']);

        }

        if (isset($data['skills'])) {
            
            $cmd = new SettingSkillsValuesCommand();
            $cmd->fillSkillsValues($orderDraft, $data['skills']);

        }

        return \Redirect::route('teamorder_draft_main_page', ['id' => $draft_id]);
    }

    public function mainTeamOrderDraft($id)
    {
        $orderDraft = $this->teamOrderRepo->findOrderDraft($id);
        
        $materials = $orderDraft->materials;
        $skills = $orderDraft->skills;

        return $this->view('admin.orders.main', [
            'orderDraft' => $orderDraft,
            'materials' => $materials,
            'skills' => $skills,
        ]);
    }

    
    public function publish()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $orderDraft = $this->teamOrderRepo->findOrderDraft($draft_id);

        $orderDraft->publish();

        return \Redirect::route('admin_orderdrafts_page');
    }

    // how delete aggregate correct ?
    public function deleteDraft()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $cmd = new DeleteTeamOrderDraftCommand($this->teamOrderRepo);
        $cmd->deleteTeamOrder($draft_id);

        return \Redirect::route('admin_orderdrafts_page');
    }
}
