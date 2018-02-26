<?php

namespace App\Http\Controllers\Admin;

use App\Ordinance;
use App\Question;
use App\Questionnaire;
use App\Resolution;
use App\Value;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use URL;

class FormsController extends Controller
{

    const ALL = 'ALL',
        RESOLUTIONS = 'resolutions',
        ORDINANCES = 'ordinances',
        ME = 'ME';

    /**
     * Index page for Forms - Listing of all available forms
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('forms.index', [
            'questionnaires' => Questionnaire::all(),
            'flag' => FormsController::ALL
        ]);
    }

    public function create(Request $request)
    {
        Session::flash('redirect_url', URL::previous());

        if ($request->flag === 'ordinances' && $request->ordinance_id) {
            return view('forms.create', [
                'flag' => 'ordinances',
                'ordinance_id' => $request->ordinance_id,
                'ordinance_json' => Ordinance::find($request->ordinance_id)->toJson(),
            ]);
        } elseif ($request->flag === 'resolutions' && $request->resolution_id) {
//            dd($request->flag, $request->resolution_id);
            return view('forms.create', [
                'flag' => 'resolutions',
                'resolution_id' => $request->resolution_id,
                'resolution_json' => Resolution::find($request->resolution_id)->toJson(),
            ]);
        } else {
            abort(404);
        }
        return view('forms.create');
    }

    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {
            // Json object passed by the view
            $questionnaire_object = json_decode($request->input('json-values'));
            // dd($questionnaire_object);
            $questionnaire = new Questionnaire();
            $questionnaire->name = $questionnaire_object->name;
            $questionnaire->description = $questionnaire_object->description;
            if ($questionnaire_object->associatedOrdinance) {
                $questionnaire->ordinance_id = $questionnaire_object->associatedOrdinance->id;
            } elseif ($questionnaire_object->associatedResolution) {
                $questionnaire->resolution_id = $questionnaire_object->associatedResolution->id;
            } else {
                dd('Invalid Request...');
            }
            $questionnaire->saveOrFail();
            foreach ($questionnaire_object->questions as $q) {
                $new_question = new Question();
                $new_question->question = $q->question;
                $new_question->required = $q->required ? 1 : 0;
                $new_question->type = $q->type;
                $new_question->questionnaire_id = $questionnaire->id;

                $new_question->saveOrFail();
                // If type is checkbox/radio
                if ($q->type === 'radio' || $q->type === 'checkbox' || $q->type === 'conditional') {
                    // For each of the values
                    foreach ($q->values as $v) {
                        $new_val = new Value();
                        $new_val->value = $v->value;
                        $new_val->question_id = $new_question->id;
                        $new_val->saveOrFail();
                        $new_question->values()->save($new_val);
                    }
                }
                $questionnaire->questions()->save($new_question);
            }
        });
        return redirect($request->session()->get('redirect_url'));


    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
//        DB::transaction(function () use ($id) {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire_json = new \stdClass();
        $questionnaire_json->name = $questionnaire->name;
        $questionnaire_json->description = $questionnaire->description;
        $questionnaire_json->questions = [];
        $temp = [];
        foreach ($questionnaire->questions as $q) {
            $temp_question = new \stdClass();
            $temp_question->question = $q->question;
            $temp_question->required = ($q->required === 1 ? true : false);
            $temp_question->type = $q->type;
            $temp_question->values = [];
            if ($temp_question->type === 'checkbox' || $temp_question->type === 'radio') {
                foreach ($q->values as $v) {
                    $vc = new \stdClass();
                    $vc->value = $v->value;
                    $temp_question->values[] = $vc;
                }
            }
            $temp[] = $temp_question;
        }
        $questionnaire_json->questions = $temp;
        return view('forms.show', [
            'questionnaire' => $questionnaire,
            'questionnaire_json' => json_encode($questionnaire_json),
            'type' => FormsController::ME,
        ]);
//        });
    }

    public function edit($id)
    {
        Session::flash('redirect_url', URL::previous());
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire_json = new \stdClass();
        $questionnaire_json->name = $questionnaire->name;
        $questionnaire_json->description = $questionnaire->description;
        $questionnaire_json->questions = [];
        $temp = [];
        if ($questionnaire->ordinance_id) {
            $questionnaire_json->associatedOrdinance = Ordinance::find($questionnaire->ordinance_id);
        } else if ($questionnaire->resolution_id) {
            $questionnaire_json->associatedResolution = Resolution::find($questionnaire->resolution_id);
        } else {
            abort(404);
        }

        foreach ($questionnaire->questions as $q) {
            $temp_question = new \stdClass();
            $temp_question->question = $q->question;
            $temp_question->required = ($q->required === 1 ? true : false);
            $temp_question->type = $q->type;
            $temp_question->values = [];
            if ($temp_question->type === 'checkbox' || $temp_question->type === 'radio' || 'conditional') {
                foreach ($q->values as $v) {
                    $vc = new \stdClass();
                    $vc->value = $v->value;
                    $temp_question->values[] = $vc;
                }
            }
            $temp[] = $temp_question;
        }
        $questionnaire_json->questions = $temp;
//            dd(json_encode($questionnaire_json));
//            return response()->json($questionnaire_json);
        return view('forms.edit', [
            'questionnaire' => $questionnaire,
            'questionnaire_json' => json_encode($questionnaire_json),
            'type' => FormsController::ME,
        ]);
    }

    public function update(Request $request, $id, Response $response)
    {

        // TODO: Refactor, add validation
        DB::transaction(function () use ($id, $request, $response) {

            // Json object passed by the view
            $questionnaire_object = json_decode($request->input('json-values'));
            // dd($questionnaire_object);
            $questionnaire = Questionnaire::findOrFail($id);
            if ($questionnaire->ordinance_id) {
                $redirect_url = '/admin/ordinances/' . $questionnaire->ordinance_id;
            } else if ($questionnaire->resolution_id) {
                $redirect_url = '/admin/resolutions/' . $questionnaire->resolution_id;
            } else {
                abort(404);
            }
            $questionnaire->name = $questionnaire_object->name;
            $questionnaire->description = $questionnaire_object->description;
            $questionnaire->saveOrFail();

            /* Delete questions and values*/
            foreach ($questionnaire->questions as $q) {
                foreach ($q->values as $v) {
                    $v->delete();
                }
                $q->delete();
            }
            foreach ($questionnaire_object->questions as $q) {
                $new_question = new Question();
                $new_question->question = $q->question;
                $new_question->required = $q->required ? 1 : 0;
                $new_question->type = $q->type;
                $new_question->questionnaire_id = $questionnaire->id;
                $new_question->saveOrFail();
                // If type is checkbox/radio
                if ($q->type === 'radio' || $q->type === 'checkbox' || $q->type === 'conditional') {
                    // For each of the values
                    foreach ($q->values as $v) {
                        $new_val = new Value();
                        $new_val->value = $v->value;
                        $new_val->question_id = $new_question->id;
                        $new_val->saveOrFail();
                        $new_question->values()->save($new_val);
                    }
                }
                $questionnaire->questions()->save($new_question);
            }
        });
        Session::flash('flash_message', 'Edit Success!');
        return redirect($request->session()->get('redirect_url'));


    }

    public function destroy($id)
    {
        $questions = Questionnaire::find($id)->questions;
        foreach ($questions as $question) {
            $values = $question->values;
            foreach ($values as $value) {
                $value->delete();
            }
            $question->delete();
        }
        Questionnaire::destroy($id);

        return back();
    }

    public function acceptResponses($id)
    {
        $questionnaire = Questionnaire::find($id);
        $questionnaire->isAccepting = 1;
        $questionnaire->save();
        return back();
    }

    public function declineResponses($id)
    {
        $questionnaire = Questionnaire::find($id);
        $questionnaire->isAccepting = 0;
        $questionnaire->save();
        return back();
    }

    public function acceptSuggestions($id, $flag)
    {

        if($flag === "ordinances"){
            $ordinance = Ordinance::find($id);
            $ordinance->is_accepting = 1;
            $ordinance->save();
        }else{
            $resolution = Resolution::find($id);
            $resolution->is_accepting = 1;
            $resolution->save();
        }
        return back();
    }

    public function declineSuggestions($id, $flag)
    {
        if($flag === "ordinances"){
            $ordinance = Ordinance::find($id);
            $ordinance->is_accepting = 0;
            $ordinance->save();
        }else{
            $resolution = Resolution::find($id);
            $resolution->is_accepting = 0;
            $resolution->save();
        }
        return back();
    }


    function ordinancesIndex(Request $request)
    {
        $limit = 5;
        $colName = $request->colName;
        $order = $request->order;

        // Check if there is a provided column to be sorted
        if (!$colName) {
            $colName = 'created_at';
        }

        // Check if there is a provided order
        if (!$order) {
            $order = 'desc';
        }

        if ($request->q) {
            $q = $request->q;
            $ordinances = Ordinance::where(function ($query) use ($q) {
                $query->where('keywords', 'LIKE', '%' . $q . '%')
                    ->orWhere('number', 'LIKE', '%' . $q . '%')
                    ->orWhere('series', 'LIKE', '%' . $q . '%')
                    ->orWhere('title', 'LIKE', '%' . $q . '%');
            })->where(function ($query) {
                    $query->where('is_monitoring', 1);
            });
        } else {
            $ordinances = Ordinance::where('is_monitoring', 1);
        }
        // Filtering by columns
        if ($request->has('col-number') || $request->has('col-series') || $request->has('col-title') || $request->has('col-keywords')) {
            $ordinances = $ordinances->where('number', 'LIKE', '%' . $request->input('col-number') . '%')
                ->where('keywords', 'LIKE', '%' . $request->input('col-keywords') . '%')
                ->where('series', 'LIKE', '%' . $request->input('col-series') . '%')
                ->where('title', 'LIKE', '%' . $request->input('col-title') . '%');
        }
        if($request->status == 'monitored'){
            $ordinances = $ordinances->where('is_monitored','=',1);
        }else{
            $ordinances = $ordinances->where('is_monitored','=',0);
        }
        // Implement filtering / sorting
        $ordinances = $ordinances->orderBy($colName, $order);

        // Paginate with filters
        $ordinances = $ordinances->paginate($limit)->appends($request->all());



        return view('admin.ordinances.index', [
            'ordinances' => $ordinances,
            'type' => FormsController::ME,
        ]);
    }

    function resolutionsIndex(Request $request)
    {
        $limit = 5;
        $colName = $request->colName;
        $order = $request->order;

        // Check if there is a provided column to be sorted
        if (!$colName) {
            $colName = 'created_at';
        }

        // Check if there is a provided order
        if (!$order) {
            $order = 'desc';
        }

        if ($request->q) {
            $q = $request->q;
            $resolutions = Resolution::where(function ($query) use ($q) {
                $query->where('keywords', 'LIKE', '%' . $q . '%')
                    ->orWhere('number', 'LIKE', '%' . $q . '%')
                    ->orWhere('series', 'LIKE', '%' . $q . '%')
                    ->orWhere('title', 'LIKE', '%' . $q . '%');
            })->where(function ($query) {
                $query->where('is_monitoring', 1);
            });
        } else {
            $resolutions = Resolution::where('is_monitoring', 1);
        }

        // Filtering by columns
        if ($request->has('col-number') || $request->has('col-series') || $request->has('col-title') || $request->has('col-keywords')) {
            $resolutions = $resolutions->where('number', 'LIKE', '%' . $request->input('col-number') . '%')
                ->where('keywords', 'LIKE', '%' . $request->input('col-keywords') . '%')
                ->where('series', 'LIKE', '%' . $request->input('col-series') . '%')
                ->where('title', 'LIKE', '%' . $request->input('col-title') . '%');
        }
        if($request->status == 'monitored'){
            $resolutions = $resolutions->where('is_monitored','=',1);
        }else{
            $resolutions = $resolutions->where('is_monitored','=',0);
        }
        // Implement filtering / sorting
        $resolutions = $resolutions->orderBy($colName, $order);

        // Paginate with filters
        $resolutions = $resolutions->paginate($limit)->appends($request->all());

        return view('admin.resolutions.index', [
            'resolutions' => $resolutions,
            'type' => FormsController::ME,
        ]);
    }

}
