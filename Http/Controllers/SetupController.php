<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\AgeGroup;
use Ignite\Evaluation\Entities\CriticalValues;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\RangeType;
use Ignite\Evaluation\Entities\ReferenceRange;
use Ignite\Evaluation\Entities\SampleCollectionMethods;
use Ignite\Evaluation\Entities\SampleType;
use Ignite\Evaluation\Http\Requests\ProcedureCategoriesRequest;
use Ignite\Evaluation\Http\Requests\ProcedureRequest;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Evaluation\Entities\LabtestCategories;
use Ignite\Evaluation\Entities\PartnerInstitution;
use Ignite\Evaluation\Entities\Additives;
use Ignite\Evaluation\Entities\Remarks;
use Ignite\Evaluation\Entities\Unit;
use Ignite\Evaluation\Entities\Formula;
use Illuminate\Http\Request;

class SetupController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * SetupController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
    }

    public function save_procedure(ProcedureRequest $request) {
        if ($this->evaluationRepository->add_procedure()) {
            flash()->success('Procedure saved');
        } else {
            flash('Could not save that one', 'danger');
        }
        return redirect()->route('evaluation.setup.procedures');
    }

    public function procedures($id = null) {
        $this->data['procedure'] = Procedures::findOrNew($id);
        $this->data['procedures'] = Procedures::all();
        $this->data['lab_categories'] = LabtestCategories::all();
        $this->data['titles'] = \Ignite\Evaluation\Entities\HaemogramTitle::all();
        return view('evaluation::setup.procedures', ['data' => $this->data]);
    }

    public function Templates(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->SaveTemplate($request);
        }
        $this->data['procedure'] = Procedures::findOrNew($request->procedure);
        $this->data['procedures'] = Procedures::all();
        return view('evaluation::setup.templates', ['data' => $this->data]);
    }

    public function LabCategories(Request $request) {
        if ($request->isMethod('post')) {
            $cat = LabtestCategories::findOrNew($request->id);
            $cat->name = $request->name;
            $cat->save();
            flash("Category Saved");
            return redirect()->route('evaluation.setup.test.categories');
        }
        $this->data['cat'] = LabtestCategories::findOrNew($request->id);
        $this->data['cats'] = LabtestCategories::all();
        return view('evaluation::setup.labtest_cats', ['data' => $this->data]);
    }

    public function TestTitles(Request $request) {
        if ($request->isMethod('post')) {
            $tit = \Ignite\Evaluation\Entities\HaemogramTitle::findOrNew($request->id);
            $tit->name = $request->name;
            $tit->procedure = $request->procedure;
            if (is_int($request->sort_order)) {
                $tit->sort_order = $request->sort_order;
            }
            $tit->save();
            flash("Category Saved");
            return back(); //->route('evaluation.setup.test.titles');
        }
        $this->data['tit'] = \Ignite\Evaluation\Entities\HaemogramTitle::findOrNew($request->id);
        $this->data['tits'] = \Ignite\Evaluation\Entities\HaemogramTitle::all();
        return view('evaluation::setup.labtest_titles', ['data' => $this->data]);
    }

    public function SampleTypes(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->SaveSampleType($request);
        }
        $this->data['type'] = SampleType::findOrNew($request->id);
        $this->data['types'] = SampleType::all();
        return view('evaluation::setup.sample_types', ['data' => $this->data]);
    }

    public function ManageRanges(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_range($request);
        }
        $this->data['range'] = ReferenceRange::findOrNew($request->id);
        $this->data['ranges'] = ReferenceRange::all();
        return view('evaluation::setup.ranges', ['data' => $this->data]);
    }

    public function CriticalValues(Request $request){
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_critical_values($request);
        }
        $this->data['item'] = CriticalValues::findOrNew($request->id);
        $this->data['items'] = CriticalValues::all();
        return view('evaluation::setup.critical_values', ['data' => $this->data]);
    }

    public function ManageUnits(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_unit($request);
        }
        $this->data['type'] = Unit::findOrNew($request->id);
        $this->data['types'] = Unit::all();
        return view('evaluation::setup.units', ['data' => $this->data]);
    }

    public function ManageAdditives(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_additives($request);
        }
        $this->data['additive'] = Additives::findOrNew($request->id);
        $this->data['additives'] = Additives::all();
        return view('evaluation::setup.additives', ['data' => $this->data]);
    }

    public function ManageRemarks(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_remarks($request);
        }
        $this->data['remark'] = Remarks::findOrNew($request->id);
        $this->data['remarks'] = Remarks::all();
        return view('evaluation::setup.remarks', ['data' => $this->data]);
    }

    public function ManageFormulae(Request $request) {
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_formula($request);
        }
        $this->data['item'] = Formula::findOrNew($request->id);
        $this->data['items'] = Formula::all();
        return view('evaluation::setup.formula', ['data' => $this->data]);
    }

    public function SampleCollectionMethods(Request $request) {
        //Addition of result templates per procedure
        if ($request->isMethod('post')) {
            $this->evaluationRepository->save_collection_method($request);
        }
        $this->data['type'] = SampleCollectionMethods::findOrNew($request->id);
        $this->data['types'] = SampleCollectionMethods::all();
        return view('evaluation::setup.collection_methods', ['data' => $this->data]);
    }

    public function LabSamples(Request $request) {
        if ($request->isMethod('post')) {
            try {
                $tit = new \Ignite\Evaluation\Entities\HaemogramTitle();
                $tit->name = $request->name;
                $tit->procedure = $request->procedure;
                if (is_int($request->sort_order)) {
                    $tit->sort_order = $request->sort_order;
                }
                $tit->save();
                flash("Category Saved");
            } catch (\Exception $e) {
                flash("Error saving data, ensure all required fields were entered", 'danger');
            }
            return back(); //->route('evaluation.setup.test.titles');
        }
        $this->data['tit'] = \Ignite\Evaluation\Entities\HaemogramTitle::findOrNew($request->id);
        $this->data['tits'] = \Ignite\Evaluation\Entities\HaemogramTitle::all();
        return view('evaluation::setup.samples', ['data' => $this->data]);
    }

    public function ProcedureCategoryTemplates(Request $request) {
        //Addition of result templates per Category
        if ($request->isMethod('post')) {
            $this->evaluationRepository->SavePCTemplate($request);
        }
        $this->data['category'] = ProcedureCategories::findOrNew($request->category);
        $this->data['categories'] = ProcedureCategories::all();
        return view('evaluation::setup.templates_cat', ['data' => $this->data]);
    }

    public function save_procedure_cat(ProcedureCategoriesRequest $request) {
        if ($this->evaluationRepository->add_procedure_category()) {
            flash()->success('Procedure category saved');
        } else {
            flash('There was an error', 'danger');
        }
        return redirect()->route('evaluation.setup.procedure_cat');
    }

    public function procedure_cat($id = null) {
        $this->data['categories'] = ProcedureCategories::all();
        $this->data['model'] = ProcedureCategories::findOrNew($id);
        return view('evaluation::setup.procedure_cat', ['data' => $this->data]);
    }

    public function age_groups(Request $request){
        if($request->isMethod('post')){
            $existing = mconfig('evaluation.options.age_groups');
            foreach ($existing as $key=>$value){
                AgeGroup::updateOrCreate(['code'=>$key],['name'=>$value]);
            }
            $code = $this->get_age_group_code($request);
            AgeGroup::updateOrCreate($request->id?['id'=>$request->id]:['code'=>$code],
                [
                 'name'=>!isset($request->name)?$this->get_age_group_name($request):$request->name,
                 'code'=>$code
                ]);
        }
        $this->data['groups'] = AgeGroup::all();
        $this->data['item'] = AgeGroup::findOrNew($request->id);
        return view('evaluation::setup.age_groups', ['data' => $this->data]);
    }

    public function get_age_group_code(Request $request){
        if($request->type == 'general'){
            return snake_case($request->general);
        }elseif ($request->type == 'range'){
            return $request->lower.'-'.$request->upper.$request->age_in;//ie 5-10y
        }elseif ($request->type == 'less_greater'){
            return $request->lg_type.$request->lg_value.$request->age_in;//ie >10y
        }else{
            dd("Unknown type");
        }
    }

    public function get_age_group_name(Request $request)
    {
        $age_in = mconfig('evaluation.options.age_in');
        if($request->type == 'general'){
            return ucwords($request->general);
        }elseif ($request->type == 'range'){
            return $request->lower.'-'.$request->upper.''.$age_in[$request->age_in];//ie 5-10y
        }elseif ($request->type == 'less_greater'){
            return $request->lg_type.$request->lg_value.''.$age_in[$request->age_in];//ie lg value
        }else{
            dd("Unknown type");
        }
    }

    public function range_types(Request $request){
        if($request->isMethod('post')){
            $existing = mconfig('evaluation.options.lp_flags');
            foreach ($existing as $key=>$value){
                RangeType::updateOrCreate(['code'=>$key],['name'=>$value]);
            }
            RangeType::updateOrCreate($request->id?['id'=>$request->id]:['code'=>snake_case($request->name)],
                ['name'=>$request->name,
                    'code'=>snake_case($request->name)]);
        }
        $this->data['types'] = RangeType::all();
        $this->data['item'] = RangeType::findOrNew($request->id);
        return view('evaluation::setup.range_types', ['data' => $this->data]);
    }

    public function save_subprocedure(ProcedureRequest $request) {
        if ($this->evaluationRepository->add_procedure()) {
            flash()->success('Procedure saved');
        } else {
            flash('Could not save that one', 'danger');
        }
        return redirect()->route('evaluation.setup.procedures');
    }

    public function subprocedures($id = null) {
        $this->data['procedure'] = Procedures::findOrNew($id);
        $this->data['procedures'] = Procedures::all();
        return view('evaluation::setup.subprocedures', ['data' => $this->data]);
    }

    /*
      public function SavePartnerInstitution(Request $request) {
      if ($this->evaluationRepository->SavePartnerInstitution()) {
      flash("Patner Institution Saved");
      return redirect()->route('evaluation.setup.partners');
      }
      } */

    public function ManagePartnerInstitutions(Request $request) {
        if ($request->isMethod('post')) {
            $this->evaluationRepository->SavePartnerInstitution();
            flash("Patner Institution Saved");
            return redirect()->route('evaluation.setup.partners');
        } else {
            $this->data['partner'] = PartnerInstitution::findOrNew($request->id);
            return view('evaluation::setup.manage_partners', ['data' => $this->data]);
        }
    }

    public function partnerInstitutions($id = null) {
        $this->data['partner'] = PartnerInstitution::findOrNew($id);
        $this->data['partners'] = PartnerInstitution::all();
        return view('evaluation::setup.lab_partners', ['data' => $this->data]);
    }

    public function temp() {
        $labs = \Ignite\Evaluation\Entities\Temp::all();
        foreach ($labs as $item) {
            /* $p = Procedures::whereName($item->parent)->get()->first();
              if (isset($p)) {
              $item->parent = $p->id;
              $item->save();
              } */
            if (preg_match("/\[\"/", $item->lab_result_type)) {
                echo $item->lab_result_type . '<br/>';
                $item->lab_result_type = 'select';
            }
            $item->save();
        }
    }

}
