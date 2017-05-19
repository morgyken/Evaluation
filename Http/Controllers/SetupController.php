<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Http\Requests\ProcedureCategoriesRequest;
use Ignite\Evaluation\Http\Requests\ProcedureRequest;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Evaluation\Entities\LabtestCategories;
use Ignite\Evaluation\Entities\PartnerInstitution;
use Ignite\Evaluation\Entities\ProcedureTemplates;
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

    public function LabCategories(Request $request) {
        if ($request->isMethod('post')) {
            try {
                $cat = new LabtestCategories;
                $cat->name = $request->name;
                $cat->save();
                flash("Category Saved");
            } catch (\Exception $ex) {
                flash("Category Saved", 'danger');
            }
            return redirect()->route('evaluation.setup.test.categories');
        }
        $this->data['cat'] = LabtestCategories::findOrNew($request->id);
        $this->data['cats'] = LabtestCategories::all();
        return view('evaluation::setup.labtest_cats', ['data' => $this->data]);
    }

    public function TestTitles(Request $request) {
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
        return view('evaluation::setup.labtest_titles', ['data' => $this->data]);
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
