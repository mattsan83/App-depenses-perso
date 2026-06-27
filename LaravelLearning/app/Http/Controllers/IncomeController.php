<?php

namespace App\Http\Controllers;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Resources\IncomeResource;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IncomeController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $incomes = Income::with('category')->where('user_id', auth()->id());

        if ($request->query('status')) {
            $incomes->where('status', $request->query('status'));
        }

        if ($request->query('category_id')) {
            $incomes->where('category_id', $request->query('category_id'));
        }

        if ($request->query('month')) {
            $incomes->whereMonth('income_date', $request->query('month'));
        }

        if ($request->query('year')) {
            $incomes->whereYear('income_date', $request->query('year'));
        }

        if ($request->query('is_recurring') !== null) {
            $incomes->where('is_recurring', $request->boolean('is_recurring'));
        }

        $incomes->orderBy('income_date', 'desc');

        return IncomeResource::collection($incomes->paginate(10));
    }

    public function show($id)
    {
        $income = Income::with('category')->where('user_id', auth()->id())->findOrFail($id);
        $this->authorize('view', $income);
        return new IncomeResource($income);
    }

    public function store(StoreIncomeRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = $request->user()->id;

        if (!$validatedData['is_recurring']) {
            $validatedData['recurrence_type'] = null;
        }

        $income = Income::create($validatedData);

        $income->load('category');

        return new IncomeResource($income);
    }

    public function update(UpdateIncomeRequest $request, $id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $this->authorize('update', $income);
        $validatedData = $request->validated();

        if (!$validatedData['is_recurring']) {
            $validatedData['recurrence_type'] = null;
        }

        $income->update($validatedData);

        $income->load('category');

        return new IncomeResource($income);
    }

    public function destroy($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $this->authorize('delete', $income);
        $income->delete();

        return response()->json(null, 204);
    }
}