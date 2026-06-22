<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = $request->user();

        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $monthlyIncome = $user->incomes()->whereMonth('income_date', $month)->whereYear('income_date', $year)->where('status', 'received')->sum('amount');
        
        $monthlyExpenses = $user->expenses()->whereMonth('expense_date', $month)->whereYear('expense_date', $year)->where('status', 'paid')->sum('amount');
        
        $netBalance = $monthlyIncome - $monthlyExpenses;

        $upcomingExpenses = $user->expenses()->where('expense_date', '>', now())->orderBy('expense_date')->get();
        $upcomingIncomes = $user->incomes()->where('income_date', '>', now())->orderBy('income_date')->get();

        $expensesByCategory = $user->expenses()
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'paid')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return response()->json([
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpenses' => $monthlyExpenses,
            'netBalance' => $netBalance,
            'upcomingExpenses' => $upcomingExpenses,
            'upcomingIncomes' => $upcomingIncomes,
            'expensesByCategory' => $expensesByCategory,
        ]);
    }

}
