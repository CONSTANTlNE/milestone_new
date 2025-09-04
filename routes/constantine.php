<?php

use App\Http\Controllers\Frontend\Quotationb2bController;
use App\Http\Controllers\Frontend\QuotationController;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;

// Frontend
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localizeValidations', 'localize', 'localeSessionRedirect', 'localizationRedirect'],
        'as' => 'frontend.'
    ], function()
{
    Route::controller(QuotationController::class)->group(function () {
        Route::post('/send/otp', 'sendOtp')->name('send.otp');
        Route::post('/send/otp/business', 'sendOtpBusiness')->name('send.otp.business');
        Route::post('/change/phone', 'changePhone')->name('change.phone');
        Route::post('/change/phone/business', 'changePhoneBusiness')->name('change.phone.business');
        Route::post('/confirm/otp', 'confirmOtp')->name('confirm.otp');
        Route::post('/confirm/otp/business', 'confirmOtpBusiness')->name('confirm.otp.business');
        route::get('/htmxspinner', 'htmxspinner')->name('htmxspinner');
        route::get('/car_models', 'getModels')->name('htmx.car_models');
    });
    Route::controller(Quotationb2bController::class)->group(function () {
        Route::post('/b2b/confirm/otp', 'confirmOtp')->name('b2b.confirm.otp');
        route::post('/b2b/quotation/store', 'storeB2bquotation')->name('b2b.quotation.store');;
    });

    // for seeding cars
    route::get('/uploadcars', function () {
        $filePath     = storage_path('app/car_data.json');
        $jsonContents = file_get_contents($filePath);
        $data         = json_decode($jsonContents, true); // Use `true` to get an associative array

//    dd($data['brands']);
        foreach ($data['brands'] as $brand => $models) {
            $newBrand       = new CarBrand();
            $newBrand->name = $brand;
            $newBrand->save();

            foreach ($models as $model) {
                $newModel               = new  CarModel();
                $newModel->name         = $model;
                $newModel->car_brand_id = $newBrand->id;
                $newModel->save();
            }
        }

        return 'done';
    });
});



route::post('placesautocomplete', function (Request $request) {


    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://places.googleapis.com/v1/places:autocomplete?key=' . config('milestone.google_map_api_key'), [
        'input' => $request->input('address'),
        // Searches only in USA
        'locationRestriction' => [
            'rectangle' => [
                'low' => [ 'latitude' => 24.396308, 'longitude' => -125.0 ],  // Southwest corner (Hawaii/California)
                'high' => [ 'latitude' => 49.384358, 'longitude' => -66.93457 ] // Northeast corner (Maine)
            ]
        ],
        'sessionToken' => Str::uuid()->toString(),
    ]);


    return response()->json($response->json());

})->name('autocomplete');

route::post('verify-turnstile', function (Request $request) {

    $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
        'secret'   => env('CLOUDFLARE_SECRET_KEY'), // Your Turnstile secret key
        'response' => $request->input('cf_token'), // The token returned from Turnstile
    ]);

    $result = $response->json();

    if ($result['success']) {
        $cars = CarBrand::all();
        return view('components.frontend.htmx.turnstile_success_business_quotation',compact('cars'));
    } else {
        return 'Fuck off bot';
    }
})->name('turnstile.verify');
