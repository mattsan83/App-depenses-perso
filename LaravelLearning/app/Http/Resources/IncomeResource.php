<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'category_id' => $this->category_id,
        'title' => $this->title,
        'description' => $this->description,
        'amount' => $this->amount,
        'date' => $this->income_date,
        'status' => $this->status,
        'is_recurring' => $this->is_recurring,
        'recurrence_type' => $this->recurrence_type,
        'category' => [
            'id' => $this->category?->id,
            'name' => $this->category?->name,
            'color' => $this->category?->color,
            ],
    ];
    }
}
