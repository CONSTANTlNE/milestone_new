<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FaqController extends Controller
{
    public function allFaqs() {
        $faqs = Faq::where('service_id',null)->get();
        $locales = Locale::where('status', 1)->pluck('code');
        return view('admin.faqs.admin_faqs_index', compact('faqs', 'locales'));
    }

    public function storeFaq(Request $request) {

//        dd($request->all());

        $locales    = Locale::where('status', 1)->get();
        $mainlocale = Locale::first();

            $newFaq = new Faq();

            foreach ($locales as $index => $locale) {
                $request->validate([
                    'question_' . $mainlocale->abbr => 'required|string',
                ], [
                    'question_' . $mainlocale->abbr . '.required' => 'Question in ' . $mainlocale->abbr . ' must be filled',
                ]);

                $newFaq->setTranslation('question', $locale->abbr, $request->input('question_'.$locale->abbr));
                $newFaq->setTranslation('answer', $locale->abbr,
                    $request->input('answer_'.$locale->abbr));
                $newFaq->save();
            }

        return back()->with('success', 'FAQ added successfully');
    }

    public function editFaq($locale,$id) {

        $faq=Faq::find($id);
        if(!$faq) {
            return back()->with('error', 'FAQ not found');
        }
        $locales = Locale::where('status', 1)->pluck('code');
        return view('admin.faqs.admin_faqs_edit', compact('faq', 'locales'));

    }

    public function updateFaq(Request $request) {

        $locales    = Locale::where('status', 1)->get();
        $mainlocale = Locale::first();

        $faq=Faq::where('id', $request->faq_id)->first();

        if(!$faq) {
            return back()->with('error', 'FAQ not found');
        }

        foreach ($locales as $index => $locale) {
            $request->validate([
                'question_' . $mainlocale->abbr => 'required|string',
            ], [
                'question_' . $mainlocale->abbr . '.required' => 'Question in ' . $mainlocale->abbr . ' must be filled',
            ]);

            $faq->setTranslation('question', $locale->abbr, $request->input('question_'.$locale->abbr));
            $faq->setTranslation('answer', $locale->abbr,
                $request->input('answer_'.$locale->abbr));
            $faq->save();
        }

        return to_route('faqs.all')->with('success', 'FAQ updated successfully');
    }

    public function deleteFaq(Request $request) {

        $faq=Faq::where('id', $request->faq_id)->first();

        if(!$faq) {
            return back()->with('error', 'FAQ not found');
        }

        $faq->delete();

        return back()->with('success', 'FAQ deleted successfully');

    }

}
