<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarPriceController extends Controller
{
    public function predict(Request $request)
    {
        // Load the model (replace with your actual loading logic)
        $model = unserialize(file_get_contents('"C:\Users\wissam_T\PycharmProjects\pythonProject1\car_price_model.pkl"'));

        // Preprocess input data (replace with your preprocessing logic)
        $input_data = [
            'make' => $request->input('make'),
            'year'
        ];

        // Make prediction
        $prediction = $model->predict(np.array([input_data]))[0];

        return response()->json(['predicted_price' => $prediction]);
    }
}
