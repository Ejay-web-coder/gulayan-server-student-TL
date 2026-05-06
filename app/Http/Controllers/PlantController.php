<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //TODO : implement load all the records
    //TODO : implement pagination when loading all the records
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //TODO: implement save record functionality
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantModel $plantController)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantModel $plant)
  {
    try {
      // Validate the incoming request data
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variety' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'required|date',
        'seedling_count' => 'required|integer|min:0',
        'batch_name' => 'required|string|max:255',
        'starting_fund' => 'required|numeric|min:0',
        'seedling_source' => 'required|string|max:255'
      ]);

      // Update the plant record with validated data
      $plant->update($validated);

      return response()->json([
        'message' => 'Plant record updated successfully',
        'data' => $plant
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error updating plant record',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    try {
      // Store plant info for response before deletion
      $plantName = $plant->name;
      
      // Delete the plant record
      $plant->delete();

      return response()->json([
        'message' => "Plant record '{$plantName}' deleted successfully",
        'status' => 'success'
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error deleting plant record',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
