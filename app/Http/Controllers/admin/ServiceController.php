<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Locale;
use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ServiceController extends Controller
{


    public function index()
    {
        $services = Service::get();

        return view('frontend.services.services', compact('services'));
    }

    public function serviceSingle(Request $request,$locale,$slug){

        $service=Service::where('slug',$slug)
            ->with('features','faqs')
            ->first();

        if(!$service){
            return back();
        }

        $services=Service::all();

        return view('frontend.services.service_single',compact('service','services'));

    }

    public function createService(Request $request)
    {
        $locales = Locale::where('status', 1)->pluck('code');

        return view('admin.services.admin_create_service', compact('locales'));
    }

    public function storeService(Request $request)
    {
        $locales    = Locale::where('status', 1)->get();
        $mainlocale = Locale::first();


        DB::transaction(function () use ($request, $locales, $mainlocale) {
            $newService = new Service();

            foreach ($locales as $index => $locale) {
                $newService->setTranslation('name', $locale->abbr, $request->input('service_name_'.$locale->abbr));
                $newService->setTranslation('short_description', $locale->abbr,
                    $request->input('short_description_'.$locale->abbr));
                $newService->setTranslation('description', $locale->abbr,
                    $request->input('description_'.$locale->abbr));
                $newService->save();
            }


            // ===========  add features  =====================
            $features = $request->input("service_feature_name_{$mainlocale->abbr}");

            $featureModels = []; // Hold created feature models to update later

            // ✅ STEP 1: Create FEATUREs in the main locale
            if (is_array($features)) {
                foreach ($features as $index => $feature) {
                    $serviceFeature             = new ServiceFeature();
                    $serviceFeature->service_id = $newService->id;
                    $serviceFeature->setTranslation('name', $mainlocale->abbr, $feature);
                    $serviceFeature->save();

                    $featureModels[$index] = $serviceFeature;
                }
            }
            // ✅ STEP 2: Add translations for other locales
            foreach ($locales as $locale) {
                if ($locale->abbr === $mainlocale->abbr) {
                    continue; // Skip main locale, already handled
                }

                $translatedFeatures = $request->input("service_feature_name_{$locale->abbr}");

                if (is_array($translatedFeatures)) {
                    foreach ($translatedFeatures as $index => $translatedName) {
                        if (isset($featureModels[$index])) {
                            $featureModels[$index]->setTranslation('name', $locale->abbr, $translatedName);
                            $featureModels[$index]->save(); // Save updated translations
                        }
                    }
                }
            }


            // ==================== add faqs  ===========================

            $faqModels        = [];
            $mainFaqQuestions = $request->input("faq_question_{$mainlocale->abbr}");
            $mainFaqAnswers   = $request->input("faq_answer_{$mainlocale->abbr}");

            // ✅ STEP 1: Create FAQs in the main locale
            if (is_array($mainFaqQuestions) && is_array($mainFaqAnswers)) {
                foreach ($mainFaqQuestions as $index => $question) {
                    $newFaq             = new Faq();
                    $newFaq->service_id = $newService->id;

                    $newFaq->setTranslation('question', $mainlocale->abbr, $question);
                    $newFaq->setTranslation('answer', $mainlocale->abbr, $mainFaqAnswers[$index] ?? '');

                    $newFaq->save();

                    $faqModels[$index] = $newFaq; // Save to update with other locales
                }
            }

            // ✅ STEP 2: Add translations for other locales
            foreach ($locales as $locale) {
                if ($locale->abbr === $mainlocale->abbr) {
                    continue; // Already processed above
                }

                $questions = $request->input("faq_question_{$locale->abbr}");
                $answers   = $request->input("faq_answer_{$locale->abbr}");

                if (is_array($questions) && is_array($answers)) {
                    foreach ($questions as $index => $translatedQuestion) {
                        if (isset($faqModels[$index])) {
                            $faqModels[$index]->setTranslation('question', $locale->abbr, $translatedQuestion);
                            $faqModels[$index]->setTranslation('answer', $locale->abbr, $answers[$index] ?? '');
                            $faqModels[$index]->save();
                        }
                    }
                }
            }


        });

        return back()->with('success', 'Service added successfully');
    }

    public function adminAllService()
    {
        $services = Service::with('media')->get();
        $locales  = Locale::all();

        return view('admin.services.admin_services_index', compact('services', 'locales'));
    }

    public function editService(Request $request, $locale, $id)
    {
        $locales = Locale::where('status', 1)->pluck('code');
        $service = Locale::find($id);

//        dd($service);
        return view('admin.services.admin_edit_service', compact('service', 'locales'));
    }

    public function updateService(Request $request)
    {
        $service = Service::where('id', $request->service_id)
            ->with('faqs', 'features')->first();

//        dd($service);

        $locales    = Locale::where('active', 1)->get();
        $mainlocale = Locale::first();


        DB::transaction(function () use ($request, $locales, $mainlocale, $service) {

            foreach ($locales as $index => $locale) {
                $service->setTranslation('name', $locale->abbr, $request->input('service_name_'.$locale->abbr));
                $service->setTranslation('short_description', $locale->abbr,
                    $request->input('short_description_'.$locale->abbr));
                $service->setTranslation('description', $locale->abbr, $request->input('description_'.$locale->abbr));
                $service->save();
            }

//            first delete all features and faqs

            foreach ($service->features as $oldfeature) {
                $oldfeature->delete();
            }

            foreach ($service->faqs as $oldfaq) {
                $oldfaq->delete();
            }


            // ===========  add features  =====================
            $features = $request->input("service_feature_name_{$mainlocale->abbr}");

            $featureModels = []; // Hold created feature models to update later

            // ✅ STEP 1: Create FEATUREs in the main locale
            if (is_array($features)) {
                foreach ($features as $index => $feature) {
                    $serviceFeature             = new ServiceFeature();
                    $serviceFeature->service_id = $service->id;
                    $serviceFeature->setTranslation('name', $mainlocale->abbr, $feature);
                    $serviceFeature->save();

                    $featureModels[$index] = $serviceFeature;
                }
            }
            // ✅ STEP 2: Add translations for other locales
            foreach ($locales as $locale) {
                if ($locale->abbr === $mainlocale->abbr) {
                    continue; // Skip main locale, already handled
                }

                $translatedFeatures = $request->input("service_feature_name_{$locale->abbr}");

                if (is_array($translatedFeatures)) {
                    foreach ($translatedFeatures as $index => $translatedName) {
                        if (isset($featureModels[$index])) {
                            $featureModels[$index]->setTranslation('name', $locale->abbr, $translatedName);
                            $featureModels[$index]->save(); // Save updated translations
                        }
                    }
                }
            }


            // ==================== add faqs  ===========================

            $faqModels        = [];
            $mainFaqQuestions = $request->input("faq_question_{$mainlocale->abbr}");
            $mainFaqAnswers   = $request->input("faq_answer_{$mainlocale->abbr}");

            // ✅ STEP 1: Create FAQs in the main locale
            if (is_array($mainFaqQuestions) && is_array($mainFaqAnswers)) {
                foreach ($mainFaqQuestions as $index => $question) {
                    $newFaq             = new Faq();
                    $newFaq->service_id = $service->id;

                    $newFaq->setTranslation('question', $mainlocale->abbr, $question);
                    $newFaq->setTranslation('answer', $mainlocale->abbr, $mainFaqAnswers[$index] ?? '');

                    $newFaq->save();

                    $faqModels[$index] = $newFaq; // Save to update with other locales
                }
            }

            // ✅ STEP 2: Add translations for other locales
            foreach ($locales as $locale) {
                if ($locale->abbr === $mainlocale->abbr) {
                    continue; // Already processed above
                }

                $questions = $request->input("faq_question_{$locale->abbr}");
                $answers   = $request->input("faq_answer_{$locale->abbr}");

                if (is_array($questions) && is_array($answers)) {
                    foreach ($questions as $index => $translatedQuestion) {
                        if (isset($faqModels[$index])) {
                            $faqModels[$index]->setTranslation('question', $locale->abbr, $translatedQuestion);
                            $faqModels[$index]->setTranslation('answer', $locale->abbr, $answers[$index] ?? '');
                            $faqModels[$index]->save();
                        }
                    }
                }
            }
        });


        return back()->with('success', 'Service updated successfully');
    }

    public function deleteService(Request $request) {

        $service=Service::with('media')
            ->find($request->service_id);

        foreach ($service->media as $media) {
            $media->delete();
        }

        $service->delete();

        return back()->with('success', 'Service deleted successfully');

    }

    public function getServiceHtmx(Request $request)
    {
        $service = Service::where('id', $request->service_id)->first();
        $locales = Locale::get();

        if ($request->data_request == 'short_description') {
            return view('admin.htmx.get_short_descriptions', compact('service', 'locales'));
        }

        if ($request->data_request == 'long_description') {
            return view('admin.htmx.get_long_descriptions', compact('service', 'locales'));
        }

        if ($request->data_request == 'service_images') {
            $index = $request->index;

            return view('admin.htmx.get_service_images', compact('service', 'locales', 'index'));
        }

        if ($request->data_request == 'service_features') {
            return view('admin.htmx.get_service_features', compact('service', 'locales'));
        }

        if ($request->data_request == 'service_faqs') {
        }
    }




}
