<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Http\Requests\StoreShoeRequest;
use App\Http\Requests\UpdateShoeRequest;
use App\Models\Moodel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShoeController extends Controller
{

    public function getShoesOfModel(Request $request)
    {
        $shoes = Shoe::where('model_id', $request->id)->get();

        if ($shoes == null) {
            return response()->json([
                'message' => 'no shoes yet!',
                'data' => $shoes
            ], 400);
        }

        return response()->json([
            'data' => $shoes,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $request->validate([
            'model_id' => 'required|exists:moodels,id',
            'shoe_number' => 'required|numeric',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        try {
            $model = Moodel::findOrFail($request->model_id);

            $new_shoe = Shoe::create([
                'model_id' => $model->id,
                'shoe_number' => $request->shoe_number,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('ShoeImage'), $image_name);
                $new_shoe->image = 'ShoeImage/' . $image_name;
                $new_shoe->save();
            }

            return response()->json([
                'message' => 'Shoe added successfully',
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Model not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating shoe: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Shoe $shoe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shoe $shoe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoeRequest $request, Shoe $shoe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shoe $shoe)
    {
        //
    }
}
