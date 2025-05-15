<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Person;
use Illuminate\Http\Request;
use DB;
class DatabaseController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $years = DB::table('datas')
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $statements = Person::where('status', 1)
            ->where('type', 3)
            ->get();

        $selectedYear = $request->year;
        $selectedStatement = $request->statement;
        $qs = $request->queryString;
        $factInDatabases = Data::where('title->'.$locale, "!=", '')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('frontend.articles.database', compact('factInDatabases', 'years', 'statements', 'selectedYear', 'selectedStatement', 'qs'));
    }
}
