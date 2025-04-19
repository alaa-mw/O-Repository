<?php

namespace App\Http\Controllers;

use App\Models\ShoeColors;
use App\Http\Requests\StoreShoeColorsRequest;
use App\Http\Requests\UpdateShoeColorsRequest;
use App\Models\ActivityLog;
use App\Models\Color;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoeColorsController extends Controller
{

    public function getColorsOfShoe(Request $request)
    {

        $shoe = Shoe::with(['shoeColors.color'])->find($request->id);
        // Loads two levels of relationships:
        // First level: shoeColors() - the hasMany relationship you defined in your Shoe model
        // Second level: color - the belongsTo relationship from ShoeColors to Color

        if (!$shoe || $shoe->shoeColors->isEmpty()) {
            return response()->json([
                'message' => 'This shoe has no colors yet!',
                'data' => []
            ], 404);
        }

        // Transform the data to include color details
        $colors = $shoe->shoeColors;

        return response()->json([
            'data' => $colors
        ], 200);
    }


    public function produce(Request $request)
    {
        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'items' => 'required|array|min:1',
            'items.*.color_id' => 'required|exists:colors,id',
            'items.*.avaliable_amount' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $shoe = Shoe::findOrFail($request->shoe_id);
            $results = [];

            foreach ($request->items as $item) {
                $color = Color::findOrFail($item['color_id']);

                // Find or create the shoe-color combination
                $shoeColor = ShoeColors::firstOrCreate(
                    [
                        'shoe_id' => $request->shoe_id,
                        'color_id' => $item['color_id']
                    ],
                    [
                        'avaliable_amount' => 0,
                        'sold_amount' => 0,
                        'total_amount' => 0
                    ]
                );

                // Update the available amount
                $shoeColor->avaliable_amount += $item['avaliable_amount'];
                $shoeColor->total_amount = $shoeColor->avaliable_amount + $shoeColor->sold_amount;
                $shoeColor->save();

                // Log the activity
                $this->createActivityLog('production', $shoeColor, $item['avaliable_amount']);

                $results[] = $shoeColor;
            }

            DB::commit();

            return response()->json([
                'message' => 'Production recorded successfully',
                'data' => $results
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error processing production: ' . $exception->getMessage(),
            ], 500);
        }
    }

    public function sale(Request $request)
    {
        //shoe_id
        //color_id
        //sold_amount

        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'items' => 'required|array|min:1',
            'items.*.color_id' => 'required|exists:colors,id',
            'items.*.sold_amount' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $shoe = Shoe::findOrFail($request->shoe_id);
            $results = [];

            foreach ($request->items as $item) {
                $color = Color::findOrFail($item['color_id']);

                // Find the shoe-color combination
                $shoeColor = ShoeColors::where([
                    'shoe_id' => $request->shoe_id,
                    'color_id' => $item['color_id']
                ])->firstOrFail();

                // Check sufficient stock
                if ($shoeColor->avaliable_amount < $item['sold_amount']) {
                    throw new \Exception("Insufficient available stock for color {$item['color_id']}");
                }

                // Update amounts
                $shoeColor->sold_amount += $item['sold_amount'];
                $shoeColor->avaliable_amount -= $item['sold_amount'];
                $shoeColor->total_amount = $shoeColor->avaliable_amount + $shoeColor->sold_amount;
                $shoeColor->save();

                // Log the activity
                $this->createActivityLog('sale', $shoeColor, $item['sold_amount']);

                $results[] = $shoeColor;
            }

            DB::commit();

            return response()->json([
                'message' => 'Sale recorded successfully',
                'data' => $results
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();

            $statusCode = str_contains($exception->getMessage(), 'Insufficient available stock')
                ? 400
                : 500;

            return response()->json([
                'message' => 'Error processing sale: ' . $exception->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoeColorsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoeColors $shoeColors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoeColors $shoeColors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoeColorsRequest $request, ShoeColors $shoeColors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoeColors $shoeColors)
    {
        //
    }
}
