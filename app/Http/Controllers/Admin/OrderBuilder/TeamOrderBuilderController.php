<?php

namespace App\Http\Controllers\Admin\OrderBuilder;

use App\Http\Controllers\Controller;
use App\Models\Work\Catalogs\WorkInstrument;
use App\Models\Work\Catalogs\WorkMaterial;
use App\Models\Work\Catalogs\WorkSkill;
use App\Models\Work\Team\TeamOrder;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Transactions\Admin\TeamOrderBuilder;
use Illuminate\Support\Facades\Input;

class TeamOrderBuilderController extends Controller
{
    public function orderDrafts()
    {

        $draftOrders = TeamOrder::where('status', 'draft')->get();

        return $this->view('admin.orders.drafts', [
            'draftOrders' => $draftOrders,
        ]);
    }

    public function createOrderDraft()
    {
        $materials = WorkMaterial::get();
        $instruments = WorkInstrument::get();
        $skills = WorkSkill::get();
        
        return $this->view('admin.orders.create', [
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
        ]);
    }
    
    public function editOrderDraft_1($id)
    {

        $orderDraft = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($id); // add condition ('status', 'draft')

        $orderMaterialsCodes = $orderDraft->materials()->select('code')->get()->lists('code')->toArray();
        $orderSkillsCodes = $orderDraft->skills()->select('code')->get()->lists('code')->toArray();
        $orderIstrumentsCodes = [];//$orderDraft->instruments()->select('code')->get()->lists('code')->toArray();

        $materials = WorkMaterial::get();
        $instruments = WorkInstrument::get();
        $skills = WorkSkill::get();

        return $this->view('admin.orders.edit_1', [
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

    public function editOrderDraftAction_1()
    {
        $data = Input::all();
        $draft_id = $data['draft_id']; 

        $orderDraft = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($draft_id); // add condition ('status', 'draft')

        // update draft-order materials
        if (isset($data['materials'])) {
            $checkedMaterialsCodes = $data['materials'];

            TeamOrderBuilder::updateCheckedMaterials($orderDraft, $checkedMaterialsCodes);
        }
        else {
            $orderDraft->materials()->delete();
        }

        // update draft-order skills
        if (isset($data['skills'])) {
            $checkedSkillsCodes = $data['skills'];

            TeamOrderBuilder::updateCheckedSkills($orderDraft, $checkedSkillsCodes);
        }
        else {
            $orderDraft->skills()->delete();
        }

        return \Redirect::route('admin_edit_orderdraft_2_page', ['id' => $orderDraft->id]);
//        return \Redirect::route('admin_edit_orderdraft_1_page', ['id' => $orderDraft->id]);
    }


    public function editOrderDraft_2($id)
    {
        $orderDraft = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($id); // add condition ('status', 'draft')

        $draftMaterials = $orderDraft->materials;
        $draftSkills = $orderDraft->skills;


        return $this->view('admin.orders.edit_2', [
            'draftMaterials' => $draftMaterials,
            'draftSkills' => $draftSkills,
            'orderDraft' => $orderDraft,
            'draftOrder' => $orderDraft,
        ]);
    }


    public function editOrderDraftAction_2()
    {
        $data = Input::all();
        $draft_id = $data['draft_id'];

        $orderDraft = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($draft_id);

        if (isset($data['order'])) {
            $orderValues = $data['order'];

            foreach ($orderValues as $field => $value) {
//                $material = TeamOrderRepository::getMaterialByCode($orderDraft, $field);
//                $material->update(['need' => $value]);
                $orderDraft->$field = $value;
            }
            $orderDraft->save();
        }

        if (isset($data['materials'])) {
            $materialsValues = $data['materials'];

            foreach ($materialsValues as $code => $value) {
                $material = TeamOrderRepository::getMaterialByCode($orderDraft, $code);
                $material->update(['need' => $value]);
            }
        }

        if (isset($data['skills'])) {
            $skillsValues = $data['skills'];

            foreach ($skillsValues as $code => $value) {
                $skill = TeamOrderRepository::getSkillByCode($orderDraft, $code);
                $skill->update(['need_times' => $value]);
            }
        }


        $orderDraft->update(['status' => 'free']);

        return \Redirect::route('admin_edit_orderdraft_2_page', ['id' => $draft_id]);
    }

    public function createTeamOrderAction() //Request $request for protocol
    {
        $data = Input::all();

        $constructor = new TeamOrderBuilder($data);

        try {
            $constructor->createOrder();
        }
        catch (\Exception $e) {
            
        }

        return \Redirect::back();
//        return \Redirect::route('admin_teamorder_create_action');
    }
}
