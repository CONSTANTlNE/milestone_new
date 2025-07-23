<?php

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
        Route::post('/change/phone', 'changePhone')->name('change.phone');
        Route::post('/confirm/otp', 'confirmOtp')->name('confirm.otp');
        route::get('/htmxspinner', 'htmxspinner')->name('htmxspinner');
        route::get('/car_models', 'getModels')->name('htmx.car_models');
    });

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



route::get('placesautocomplete', function (Request $request) {


    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://places.googleapis.com/v1/places:autocomplete?key=' . env('GOOGLE_MAPS_API_KEY'), [
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
