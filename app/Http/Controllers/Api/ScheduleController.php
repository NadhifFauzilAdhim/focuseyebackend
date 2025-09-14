<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import a class to generate UUID
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class ScheduleController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the user's schedules.
     */
    public function index(Request $request)
    {
        // Add manual authorization in each method that needs it
        $this->authorize('viewAny', Schedule::class);
        $schedules = $request->user()->schedules()->with('details')->latest()->get();
        return response()->json($schedules);
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $this->authorize('create', Schedule::class);
        $validatedData = $request->validated();

        // Use a database transaction to maintain data integrity.
        // If any part fails, the entire operation will be rolled back.
        $schedule = DB::transaction(function () use ($validatedData, $request) {
            $schedule = $request->user()->schedules()->create([
                'uuid' => Str::uuid(), // Generate and add UUID here
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
            ]);

            if (!empty($validatedData['details'])) {
                $schedule->details()->createMany($validatedData['details']);
            }
            
            return $schedule;
        });

        $schedule->load('details');

        return response()->json($schedule, Response::HTTP_CREATED);
    }

    /**
     * Display the specified schedule.
     */
    public function show(Request $request, string $uuid)
    {
        try {
            // Find the schedule by its UUID, ensuring it belongs to the authenticated user
            $schedule = $request->user()->schedules()->where('uuid', $uuid)->firstOrFail();
            
            $this->authorize('view', $schedule);
            $schedule->load('details');
            return response()->json($schedule);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'status' => '404',
                'message' => 'Schedule not found or you do not have permission to view it.'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(UpdateScheduleRequest $request, string $uuid)
    {
        try {
            // Find the schedule by its UUID, ensuring it belongs to the authenticated user
            $schedule = $request->user()->schedules()->where('uuid', $uuid)->firstOrFail();
            
            $this->authorize('update', $schedule);
            $validatedData = $request->validated();
    
            DB::transaction(function () use ($validatedData, $schedule) {
                // Update the main schedule details
                $schedule->update([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'] ?? null,
                ]);
    
                $schedule->details()->delete();
    
                if (!empty($validatedData['details'])) {
                    $schedule->details()->createMany($validatedData['details']);
                }
            });
    
            $schedule->load('details');
    
            return response()->json($schedule);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Schedule not found or you do not have permission to update it.'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Request $request, string $uuid)
    {
        try {
            // Find the schedule by its UUID, ensuring it belongs to the authenticated user
            $schedule = $request->user()->schedules()->where('uuid', $uuid)->firstOrFail();
    
            $this->authorize('delete', $schedule);
            $schedule->delete();
            return response()->json([
                'success' => true,
                'status' => '200',
                'message' => 'Schedule deleted successfully'
            ], Response::HTTP_OK);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'status' => '404',
                'message' => 'Schedule not found or you do not have permission to delete it.'
            ]);
        }
    }
}

