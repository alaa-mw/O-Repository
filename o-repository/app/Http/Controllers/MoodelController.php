<?php

namespace App\Http\Controllers;

use App\Models\Moodel;
use App\Http\Requests\StoreMoodelRequest;
use App\Http\Requests\UpdateMoodelRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MoodelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moodels = Moodel::get();

        return response()->json([
            'data' => $moodels
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        try {
            $request->validate([
                'model_number' => 'required|unique:moodels,model_number|numeric',
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $new_model = Moodel::create([
                'model_number' => $request['model_number'],
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('ModelImage'), $image_name);
                $new_model->image = 'ModelImage/' . $image_name;
                $new_model->save();
            }

            return response()->json([
                'message' => 'model created successfully',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating model: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMoodelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Moodel $moodel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Moodel $moodel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMoodelRequest $request, Moodel $moodel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Moodel $moodel)
    {
        //
    }
}
