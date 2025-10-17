<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meal;
use Carbon\Carbon;

class SimulationController extends Controller
{
    /**
     * Register a meal for a user.
     * @param Request $request
     * @return JsonResponse
     */
    public function registerMeal(Request $request)
    {
       $validated =  $request->validate([
            'telegram_id' => 'required|integer|min:1',
            'meal_name' => 'required|string|max:100',
            'calories' => 'required|integer|min:0',
        ]);


        // Find or create user
        $user = User::firstOrCreate(['telegram_id' => $validated['telegram_id']]);

        // Create meal
        $meal = Meal::create([
            'user_id'   => $user->id,
            'meal_name' => $validated['meal_name'],
            'calories'  => $validated['calories'],
        ]);

        return response()->json([
            'message' => 'Meal registered successfully',
            'meal'    => $meal,
        ], 201);
    }

    /**
     * Daily Summary of meal for a user.
     * @param Request $request
     * @return JsonResponse
     */
    public function dailySummary(Request $request)
    {
        $telegram_id = $request->query('telegram_id');

        if (!$telegram_id) {
            return response()->json(['error' => 'telegram_id is required'], 400);
        }

        $user = User::where('telegram_id', $telegram_id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $today = Carbon::today();
        $meals = Meal::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->get();

        $total = $meals->sum('calories');

        return response()->json([
            'date' => $today->toDateString(),
            'total_calories' => $total,
            'meals' => $meals,
        ]);
    }

    /**
     * Weekly Stats of meal for a user.
     * @param Request $request
     * @return JsonResponse
     */
    public function weeklyStats(Request $request)
    {
        $telegram_id = $request->query('telegram_id');

        if (!$telegram_id) {
            return response()->json(['error' => 'telegram_id is required'], 400);
        }

        $user = User::where('telegram_id', $telegram_id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $meals = Meal::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get()
            ->groupBy(function ($meal) {
                return Carbon::parse($meal->created_at)->format('Y-m-d');
            });

        $weeklyStats = [];
        foreach ($meals as $date => $dailyMeals) {
            $weeklyStats[] = [
                'date' => $date,
                'total_calories' => $dailyMeals->sum('calories'),
                'meals' => $dailyMeals->values(),
            ];
        }

        return response()->json([
            'user' => $user->telegram_id,
            'weekly_stats' => $weeklyStats,
        ]);
    }
}
