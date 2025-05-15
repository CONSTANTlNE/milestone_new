<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Models\Media;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Mail;
use Spatie\Searchable\Search;
class HomeController extends Controller
{
    public $email = '';
    public $subject = '';
    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
//        $lang = app()->getLocale();
//        $factInMedias = $this->getMediaByStatusAndLang($lang, 3);
//        $factPapers = $this->getArticlesByStatusLangAndOption($lang, "4", 4);
//        $promises = $this->getArticlesByStatusLangAndOption($lang, "2", 3);
//        $sliders = $this->getArticlesByStatusLangAndOption($lang, "3", 5);

        return view('frontend.welcome');
    }
    public function under()
    {
        return view('under');
    }
    private function getMediaByStatusAndLang($lang, $limit)
    {
        return Media::where('title->'.$lang, '!=', '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    private function getArticlesByStatusLangAndOption($lang, $optionId, $limit)
    {
        return Article::where('slug->'.$lang, '!=', '')
            ->where('status', 1)
            ->whereJsonContains('option_id', $optionId)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function results(Request $request)
    {
//        $searchResults = "";
//        if (!empty($request->search)) {
//            $searchResults = (new Search())
//                ->registerModel(Article::class, 'title')
//                ->limitAspectResults(20)
//                ->search($request->search)
//                ->sortByDesc(fn($result) => $result->searchable->created_at);
//        }
//        $keyword = $request->input('page_id');
//        $query = $request->input('search');
//        if (!empty($keyword) && $keyword == 2) {
//            $searchResults = (new Search())
//                ->registerModel(Person::class, ['title', 'slug', 'image', 'id', 'created_at'])
//                ->search($query)
//                ->take(10);
//        }else if (!empty($keyword) && $keyword == 3){
//            $searchResults = (new Search())
//                ->registerModel(User::class, ['title', 'slug', 'image', 'id', 'created_at'])
//                ->limitAspectResults(20)
//                ->search($query);
//        }else{
//
//            $searchs = (new Search())
//                ->registerModel(Article::class, ['title', 'slug', 'id', 'created_at'])
//                ->search($query);
//        }
        // Sort by similarity buckets
        $searchResults = "";
        if (!empty($request->search) && $request->page_id == 2) {
            $searchResults = Person::search($request->search)->where('status', 1)->take(30)->paginate(10);
        }else if(!empty($request->search) && $request->page_id == 3){
            $searchResults = User::search($request->search)->where('status', 1)->take(30)->paginate(10);
        }else{
            $searchResults = Article::search($request->search)->where('status', 1)->take(30)->paginate(10);
        }


//        $searchResults = $searchs->sortByDesc(function ($result) use ($query) {
//            $title = strtolower($result->searchable->title);
//            $searchQuery = strtolower($query);
//
//            $percentage = similar_text($searchQuery, $title);
//            // Build sorting priority combining similarity and created_at timestamp
//            $priority = 0;
//
//            if ($percentage > 95) {
//                $priority = 300; // Exact match priority
//            } elseif ($percentage > 80) {
//                $priority = 200; // High match priority
//            } elseif ($percentage > 50) {
//                $priority = 100; // Medium match priority
//            }
//
//            return $priority * 1000000000000 + $result->searchable->created_at->timestamp;
//            // Combine priority with timestamp weight
//        });


//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//        $perPage = 10;
//        $searchResults = new LengthAwarePaginator(
//            $searchResults->forPage($currentPage, $perPage),
//            $searchResults->count(),
//            $perPage,
//            $currentPage,
//            ['path' => $request->url(), 'query' => $request->query()]
//        );

        return view('frontend.search', compact('searchResults'));
    }

    public function mailSend(Request $request)
    {
        $data['fullname'] = $request->input('fullname');
        $data['email'] = $request->input('email');
        $data['text'] = $request->input('text');

        $this->email = 'info@factcheck.ge';
        $this->subject = $request->input('subject');

        Mail::send('form.mail', ['data' => $data], function ($message) {
            $message->from('noreply@factcheck.ge', 'factcheck.ge');
            $message->subject($this->subject);
            $message->to($this->email);
        });

        return response(['message' => __('message-sent-text')], 200)->header('Content-Type', 'application/json');
    }

    public function factSend(Request $request)
    {
        $data['fullname'] = $request->input('fullname');
        $data['email'] = $request->input('email');
        $data['source'] = $request->input('source');
        $data['fact'] = $request->input('fact');

        $this->email = 'info@factcheck.ge';

        $this->subject = __('verify-your-fact');

        Mail::send('form.fact', ['data' => $data], function ($message) {
            $message->from('noreply@grass.org.ge', 'grass.org.ge');
            $message->subject($this->subject);
            $message->to('info@factcheck.ge');
        });

        return response(['message' => __('message-sent-text')], 200)->header('Content-Type', 'application/json');
    }
}
