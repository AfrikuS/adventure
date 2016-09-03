<?php

namespace App\Modules\Work\Controllers\Admin\OrderBuilder;

use App\Modules\Core\Http\Controller;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Modules\Work\Commands\Admin\OrderBuilder\ClearMaterialsAction;
use App\Modules\Work\Commands\Admin\OrderBuilder\CreateOrderDraftAction;
use App\Modules\Work\Commands\Admin\OrderBuilder\PublishOrderAction;
use App\Modules\Work\Commands\Admin\OrderBuilder\ReCheckMaterialsCommand;
use App\Modules\Work\Commands\Admin\OrderBuilder\ReCheckSkillsCommand;
use App\Modules\Work\Commands\Admin\OrderBuilder\SettingMaterialsValuesCommand;
use App\Modules\Work\Commands\Admin\OrderBuilder\SettingOrderDataAction;
use App\Modules\Work\Commands\Order\DeleteOrderAction;
use App\Modules\Work\Persistence\Repositories\Order\OrderDraftsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;

class TeamOrderBuilderController extends Controller
{
    /** @var OrderDraftsRepo */
    protected $draftsRepo;

    public function __construct(OrderDraftsRepo $draftsRepo)
    {
        $this->draftsRepo = $draftsRepo;
        
        parent::__construct();
    }

    public function orderDrafts()
    {
        $draftOrders = $this->draftsRepo->get();

        return $this->view('work.admin.draft_list', [
            'draftOrders' => $draftOrders,
        ]);
    }

    public function createOrderDraft()
    {
        $cmd = new CreateOrderDraftAction();

        $draft_id = $cmd->createEmptyTeamOrder();

        return \Redirect::route('teamorder_draft_select_requires_page', ['id' => $draft_id]);
    }

    public function selectRequirements($id)
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');

        $orderDraft = $ordersRepo->findOrderWithMaterialsById($id);

        $orderMaterialsCodes = $orderDraft->materials->getCodes();

//        $orderSkillsCodes = $orderDraft->getSkillsCodes();
        $orderIstrumentsCodes = [];

        $materials = Material::get();
        $instruments = Instrument::get();
        $skills = Skill::get();

        return $this->view('work.admin.order_draft.select_requires', [
            'draft' => $orderDraft,
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
            'orderMaterialsCodes' => $orderMaterialsCodes,
            'orderSkillsCodes' => [], //$orderSkillsCodes,
            'orderIstrumentsCodes' => $orderIstrumentsCodes,
            'orderDraft' => $orderDraft,
        ]);
    }

    public function setRequirements ()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];
        

        if (isset($data['materials'])) { // default = []

            $checkedMaterialsCodes = $data['materials'];

            $cmd = new ReCheckMaterialsCommand();
            
            $cmd->reCheckMaterials($draft_id, $checkedMaterialsCodes);
        }
        else 
        {
            $clearMaterials = new ClearMaterialsAction();
            
            $clearMaterials->clearMaterials($draft_id);
        }

/*        // update/re-check draft-order skills
        if (isset($data['skills'])) {
            
            $checkedSkillsCodes = $data['skills'];

            $cmd = new ReCheckSkillsCommand();
        
            $cmd->reCheckSkills($draft_id, $checkedSkillsCodes);
        }
        else 
        {
            $this->draftsRepo->deleteOrderSkills($draft_id);
        }*/

        return \Redirect::route('teamorder_draft_setting_page', ['id' => $draft_id]);
    }


    public function settingValues($id)
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');

        $orderDraft = $ordersRepo->findOrderWithMaterialsById($id);

        $draftMaterials = $orderDraft->materials->materials;
//        $draftSkills = $orderDraft->skills;
        
        $skills = Skill::get();

        return $this->view('work.admin.order_draft.setting_values', [
            'draftMaterials' => $draftMaterials,
            'draftSkills' => [], //$draftSkills,
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

//        $orderDraft = $this->draftsRepo->find($draft_id);

        if (isset($data['order'])) {

            $cmd = new SettingOrderDataAction();
            
            $cmd->fillOrderData($draft_id, $data['order']);

        }

        if (isset($data['materials'])) {
//
            $cmd = new SettingMaterialsValuesCommand();

            $cmd->fillMaterialValues($draft_id, $data['materials']);

        }

/*        if (isset($data['skills'])) {
            
            $cmd = new SettingSkillsValuesCommand();
            $cmd->fillSkillsValues($orderDraft, $data['skills']);

        }*/

        return \Redirect::route('teamorder_draft_main_page', ['id' => $draft_id]);
    }

    public function mainTeamOrderDraft($id)
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');

        $orderDraft = $ordersRepo->findOrderWithMaterialsById($id);
        
        $materials = $orderDraft->materials->materials;
//        $skills = $orderDraft->skills;

        return $this->view('work.admin.order_draft.main', [
            'orderDraft' => $orderDraft,
            'materials' => $materials,
            'skills' => [],//$skills,
        ]);
    }
    
    public function publish()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];


        $publishOrder = new PublishOrderAction();

        try {

            $publishOrder->publish($draft_id);

        }
        catch (StateException $e) {

        }


        return \Redirect::route('admin_orderdrafts_page');
    }

    public function deleteDraft()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $cmd = new DeleteOrderAction();

        $cmd->deleteOrder($draft_id);


        return \Redirect::route('admin_orderdrafts_page');
    }
}
