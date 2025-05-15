<?php

namespace App\Http\Controllers;

use DB;
use Helper;
use Multitenant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Quiz;
use App\Events\Quiz\ViewQuiz;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = \App('menu');
        $data = Helper::pageTemplate($menu);

        $quiz_model = Multitenant::getModel('Quiz');
        $quizzes = $quiz_model::with(['covers', 'info' => function ($query) {
            $query->where('language_id', Helper::languageId());
        }])->orderBy('created_at', 'desc')->paginate(20);

        return view('site.page.' . $data['type']['name'] . '.' . $data['template']['name'], ['data' => $quizzes]);
    }

    /**
     * [show description]
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($slug)
    {
        echo 'show';
    }

    /**
     * [single description]
     * @param  [type]
     * @return [type]
     */
    public function single(Request $request, $id)
    {
        /**
         * Find Quiz or throw exception
         */
        $quiz = Multitenant::getModel('Quiz');
        $quiz = $quiz::with([
            'questions' => function ($query) {
                $query->with([
                    'info' => function ($query) {
                        $query->where('language_id', Helper::languageId());
                    },
                    'answers' => function ($query) {
                        $query->with(['info' => function ($query) {
                            $query->where('language_id', Helper::languageId());
                        }]);
                    },
                ]);
            },
            'levels' => function($query) {
                $query->with(['info' => function ($query) {
                    $query->where('language_id', Helper::languageId());
                }]);
            },
            'info' => function ($query) {
                $query->where('language_id', Helper::languageId());
            }
        ])->findOrFail($id);

        $translations = [
            'read_fact_meter' => trans(\App('language')->current->abbr.'.read-fact-meter'),
        ];
        event(new ViewQuiz($quiz));
        view()->share('metaTitle', $quiz->info->title);

        return view('site.page.quiz.quiz', ['quiz' => $quiz, 'translations' => collect($translations)]);
    }

    /**
     * [showCompletedQuiz description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function showCompletedQuiz($id)
    {
        $model = Multitenant::getModel('QuizCompleteHistory');
        $quiz_result = $model::where('uuid', $id)->first();
        
        $quiz = Multitenant::getModel('Quiz');
        $quiz = $quiz::with([
            'questions' => function ($query) use ($quiz_result) {
                $query->with([
                    'info' => function ($query) use ($quiz_result){
                        $query->where('language_id', $quiz_result->meta['language_id']);
                    },
                    'answers' => function ($query) use ($quiz_result) {
                        $query->with(['info' => function ($query) use ($quiz_result) {
                            $query->where('language_id', $quiz_result->meta['language_id']);
                        }]);
                    },
                ]);
            },
            'levels' => function($query) use ($quiz_result) {
                $query->with(['info' => function ($query) use ($quiz_result) {
                    $query->where('language_id', $quiz_result->meta['language_id']);
                }]);
            },
            'info' => function ($query) use ($quiz_result) {
                $query->where('language_id', $quiz_result->meta['language_id']);
            }
        ])->with('covers')->findOrFail($quiz_result->quiz_id);

        $meta_title = $quiz->info->title;

        if (isset($quiz_result->meta['result']['level']['text'])) {
            $meta_title .= ' - ' . trans(\App('language')->current->abbr.'.my-quiz-status-prefix') .' '. $quiz_result->meta['result']['level']['text'];
            view()->share('metaDescription', $meta_title);
        }

        view()->share('metaTitle', $meta_title);
        if (isset($quiz->covers[0]->url)) {
            view()->share('shareImage', $quiz->covers[0]->url);
        }

        return view('site.page.quiz.quiz_result', ['quiz' => $quiz, 'result' => $quiz_result]);
    }

    /**
     * [saveQuiz description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveQuiz(Request $request)
    {
        $quiz = Multitenant::getModel('Quiz');
        $quiz = $quiz::with([
            'questions' => function ($query) {
                $query->with([
                    'info' => function ($query) {
                        $query->where('language_id', Helper::languageId());
                    },
                    'answers' => function ($query) {
                        $query->with(['info' => function ($query) {
                            $query->where('language_id', Helper::languageId());
                        }]);
                    },
                ]);
            },
            'levels' => function($query) {
                $query->with(['info' => function ($query) {
                    $query->where('language_id', Helper::languageId());
                }]);
            },
            'info' => function ($query) {
                $query->where('language_id', Helper::languageId());
            }
        ])->findOrFail($request->id);

        if (!is_null($quiz)) {
            $model = Multitenant::getModel('QuizCompleteHistory');
            $model = new $model;
            $model->uuid     = Str::uuid()->toString();
            $model->quiz_id  = $request->id;
            $model->meta     = [
                'language_id' => Helper::languageId(),
                'data'        => $quiz->toArray(),
                'result'      => ['done' => $request->done, 'level' => array_first($request->level), 'id' => $request->id]
            ];
            $model->save();
            return response()->json(['id'=> $model->uuid]);
        }
    }
}
