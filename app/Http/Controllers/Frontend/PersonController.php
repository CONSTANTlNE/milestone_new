<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Person;
use App\Models\Verdict;
use DB;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request, $lang)
    {
//        $persons = $query->where('language_id', Helper::languageId());
//            $query->with('covers');
//            if (!is_null($request->search)) {
//                $query->where(DB::raw('CONCAT_WS(" ", name, surname)'), 'LIKE', '%'.$request->search.'%');
//            } else {
//                if (!is_null($request->l)) {
//                    $query->where('surname', 'LIKE', $request->l.'%');
//                }
//            }
//        })->paginate(30);
//
//        $unsorted_data = $persons->count() ? $persons->toArray() : [];
//        if (isset($unsorted_data['data'])) {
//            $unsorted_data = $unsorted_data['data'];
//            usort($unsorted_data, function ($a, $b) {
//                return $a['info']['name'] <=> $b['info']['name'];
//            });
//        }


        $persons = Person::whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->when($request->has('search'), function ($query) use ($lang, $request) {
                $keyword = $request->search;
                $query->where(function ($query) use ($keyword, $lang) {
                    $query->where('title->' . $lang, 'like', '%' . $keyword . '%');
                });
            })
            ->where('status', 1)
            ->where('type', 1)
            ->with('images')
            ->orderByDesc(
                Blog::select('created_at')
                    ->join('article_persons', 'articles.id', '==', 'article_persons.article_id') // Explicit join to the pivot table
                    ->whereColumn('article_persons.person_id', 'persons.id') // Ensure the pivot table correctly matches the person
                    ->latest('created_at') // Use the latest article's updated_at field
                    ->take(1) // Consider only the most recent article
            )
            ->orderBy('id', 'desc')
            ->paginate(30);


        return view('frontend.persons.index', compact('persons'));
    }

    public function show($lang, $id)
    {
        $person = Person::findOrFail($id);
            //->with('images','articles', 'articles.verdict')

        $pArticles = $person->articles();

        $verdictIds = $pArticles->pluck('verdict_id')->unique();

        // Fetch the corresponding verdicts with their titles
        $verdicts = Verdict::whereIn('id', $verdictIds)
            ->orderBy('id', 'ASC')
            ->select('id','color','title','colorCode')
            ->get()
            ->keyBy('id');

        $verdictCounts = $pArticles->pluck('verdict_id')->countBy();
        $total = $pArticles->count();

        $personArticles = $person->articles()
            ->whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(12);

        return view('frontend.persons.show', compact('person', 'verdicts', 'personArticles', 'total', 'verdictCounts'));
    }

    /**
     * [single description]
     * @param  [type]
     * @return [type]
     */
    public function single($lang, $id)
    {
        $person = Person::findOrFail($id);
            //->with('images','articles', 'articles.verdict')

        $personArticles = $person->articles()->whereJsonContains('option_id', "2")->where('status', 1)->paginate(10);

//        $person = $model->with('info.covers')->withAndHas('info', function ($query) use ($slug) {
//            $query->where('language_id', \App('language')->current->id);
//            $query->where('slug', $slug);
//        })->first();

        if (is_null($person)) {
            abort(404);
        }
        return view('frontend.persons.promise', compact('person', 'personArticles'));
    }
}
