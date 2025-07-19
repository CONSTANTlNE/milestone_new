<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Media;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Mail;
use Spatie\Searchable\Search;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        // Uncomment and modify as needed for your specific requirements
        // $lang = app()->getLocale();
        // $factInMedias = $this->getMediaByStatusAndLang($lang, 3);
        // $factPapers = $this->getArticlesByStatusLangAndOption($lang, "4", 4);
        // $promises = $this->getArticlesByStatusLangAndOption($lang, "2", 3);
        // $sliders = $this->getArticlesByStatusLangAndOption($lang, "3", 5);

        return view('frontend.welcome');
    }

    /**
     * Show under construction page.
     */
    public function under(): View
    {
        return view('under');
    }

    /**
     * Get media by status and language.
     */
    private function getMediaByStatusAndLang(string $lang, int $limit)
    {
        return Media::where('title->' . $lang, '!=', '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Get articles by status, language and option.
     */
    private function getArticlesByStatusLangAndOption(string $lang, string $optionId, int $limit)
    {
        return Blog::where('slug->' . $lang, '!=', '')
            ->where('status', 1)
            ->whereJsonContains('option_id', $optionId)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Search results page.
     */
    public function results(Request $request): View
    {
        $searchResults = null;

        if (!empty($request->search)) {
            if ($request->page_id == 2) {
                $searchResults = Person::search($request->search)
                    ->where('status', 1)
                    ->take(30)
                    ->paginate(10);
            } elseif ($request->page_id == 3) {
                $searchResults = User::search($request->search)
                    ->where('status', 1)
                    ->take(30)
                    ->paginate(10);
            } else {
                $searchResults = Blog::search($request->search)
                    ->where('status', 1)
                    ->take(30)
                    ->paginate(10);
            }
        }

        return view('frontend.search', compact('searchResults'));
    }

    /**
     * Send contact form email.
     */
    public function mailSend(Request $request): JsonResponse
    {
        $data = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'text' => $request->input('text')
        ];

        $email = 'info@factcheck.ge';
        $subject = $request->input('subject');

        return $this->executeOperation(function () use ($data, $email, $subject) {
            Mail::send('form.mail', ['data' => $data], function ($message) use ($email, $subject) {
                $message->from('noreply@factcheck.ge', 'factcheck.ge');
                $message->subject($subject);
                $message->to($email);
            });

            return response()->json([
                'message' => __('message-sent-text')
            ], 200)->header('Content-Type', 'application/json');
        }, 'Contact Form Email');
    }

    /**
     * Send fact verification email.
     */
    public function factSend(Request $request): JsonResponse
    {
        $data = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'source' => $request->input('source'),
            'fact' => $request->input('fact')
        ];

        $email = 'info@factcheck.ge';
        $subject = __('verify-your-fact');

        return $this->executeOperation(function () use ($data, $email, $subject) {
            Mail::send('form.fact', ['data' => $data], function ($message) use ($email, $subject) {
                $message->from('noreply@grass.org.ge', 'grass.org.ge');
                $message->subject($subject);
                $message->to($email);
            });

            return response()->json([
                'message' => __('message-sent-text')
            ], 200)->header('Content-Type', 'application/json');
        }, 'Fact Verification Email');
    }
}
