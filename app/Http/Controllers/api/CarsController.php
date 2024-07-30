<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;

class CarsController extends Controller
{

    //addCar method -> post ->in middleware
    public function addCar(Request $request): JsonResponse
    {
        //validation
        $request -> validate([

            "brand" => "required",
            "gas_Or_petrol" => "required",
            "Driven_distance" => "required",

        ]);

        $newCar = new Car();

        $newCar->user_id = auth()->user()->id;
        $newCar->brand = $request->brand;
        $newCar->gas_Or_petrol = $request->gas_Or_petrol;
        $newCar->Driven_distance = $request->Driven_distance;

        $newCar->save();

        //response
        return response()->json([

            "status"=> 1,
            "msg"=>"Car added successfully !"
        ]);
    }

    //updateCar method -> post ->in middleware
    public function updateCar(Request $request , $car_id): JsonResponse
    {
        //get owner id
        $user_id = auth()->user()->id;

        //check if car exists
        if(Car::where([
            "user_id" => $user_id ,
            "id" => $car_id
        ]) -> exists()){

            //get car with matching id
            $car = Car::find($car_id);

            //update car data
            $car->brand = isset($request->brand) ? $request->brand : $car->brand;
            $car->gas_Or_petrol = isset($request->gas_Or_petrol) ? $request->gas_Or_petrol : $car->gas_Or_petrol;
            $car->Driven_distance = isset($request->Driven_distance) ? $request->Driven_distance : $car->Driven_distance;

            $car->save();

            return response()->json([

                "status"=>1,
                "msg"=>" car updated !! ",

            ]);
        }else{

            return response()->json([

                "status"=>false ,
                "msg"=>"owner car doesn't exist "

            ]);
        }

    }

    //delete method -> get ->in middleware
    public function deleteCar($car_id): JsonResponse
    {
        $user_id = auth()->user()->id;

        if(Car::where([
            "user_id" => $user_id ,
            "id" => $car_id
        ]) -> exists()){

            $car = Car::find($car_id);

            $car->delete();

            return response()->json([

                "status"=>1,
                "msg"=>" car deleted !! ",

            ]);
        }else{

            //response if it doesn't exist
            return response()->json([

                "status"=>false ,
                "msg"=>"owner car doesn't exist "

            ]);
        }
    }

    //listUserCar method -> get ->in middleware
    public function listUserCar(): JsonResponse
    {
        //get id's of all the owners
        $user_id = auth()->user()->id;

        //find id's that match the cars
        $cars = User::find($user_id)->cars;

        //response
        return response()->json([

            "status"=>1,
            "msg"=>"User's cars ",
            "data"=>$cars

        ]);
    }

    //searchForCar method -> get ->out of middleware
    public function searchForCar($brand)
    {
        if(Car::where('brand', 'like', "%{$brand}%")
            ->exists()){
            return Car::where('brand', 'like', "%{$brand}%")->get();

        }else{

            return response()->json([
                "status" => false ,
                "msg" => "car doesn't exist ..."
            ]);

        }


    }

}
