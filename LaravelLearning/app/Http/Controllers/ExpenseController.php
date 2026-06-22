<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('category')->where('user_id', auth()->id());

        if ($request->query('status')) {
            $expenses->where('status', $request->query('status'));
        }

        if ($request->query('category_id')) {
            $expenses->where('category_id', $request->query('category_id'));
        }

        if ($request->query('month')) {
            $expenses->whereMonth('expense_date', $request->query('month'));
        }

        if ($request->query('year')) {
            $expenses->whereYear('expense_date', $request->query('year'));
        }

        $expenses->orderBy('expense_date', 'desc');

        return ExpenseResource::collection($expenses->paginate(10));
    }


    public function store(StoreExpenseRequest $request)
        {
            $validatedData = $request->validated();

            $validatedData['user_id'] = $request->user()->id;
    
            $expense = Expense::create($validatedData);

            $expense->load('category');

            return new ExpenseResource($expense);
        }
    
        
        public function show(string $id)
        {
            $expense = Expense::with('category')->where('user_id', auth()->id())->findOrFail($id);
            $this->authorize('view', $expense);
            return new ExpenseResource($expense);
        }
    


        public function update(UpdateExpenseRequest $request, string $id)
        {
            $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
            $this->authorize('update', $expense);
            $validatedData = $request->validated();


            $expense->update($validatedData);

            $expense->load('category');

            return new ExpenseResource($expense);
        }
    
        
        public function destroy(string $id)
        {
            $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
            $this->authorize('delete', $expense);
            $expense->delete();

            return response()->json(null, 204);
        }
}
