<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterService
{

    public function applyFilters($query, Request $request, array $filters): Builder
    {
        foreach ($filters as $filterKey => $data) {
            $value = $request->input("filter_{$filterKey}");
            $condition = $request->input("filter_{$filterKey}_condition");

            $from = $request->input("filter_from_{$filterKey}");
            $to = $request->input("filter_to_{$filterKey}");

            if (is_null($value) && !in_array($condition, ['nullable', 'notNullable']) && is_null($from) && is_null($to)) {
                continue;
            }

            if (isset($data['relation'])) {
                match ($data['type']) {
                    'integer' => $query = $query->FilterRelationIntHas($data['relation'], $data['column'], $condition, $value),
                    'string' => $query = $query->FilterRelationStringHas($data['relation'], $data['column'], $condition, $value),
                    default => null,
                };
            } elseif ($data['type'] === 'range') {
                $query = $query->where(function ($q) use ($filterKey, $from, $to) {
                    if ($from) {
                        $q->where($filterKey, '>=', Carbon::parse($from)->format('Y-m-d'));
                    }
                    if ($to) {
                        $q->where($filterKey, '<=', Carbon::parse($to)->format('Y-m-d'));
                    }
                });
            } else {
                match ($data['type']) {
                    'integer' => $query = $query->FilterInt($filterKey, $condition, $value),
                    'string' => $query = $query->FilterString($filterKey, $condition, $value),
                    'boolean' => $query = $query->FilterBoolean($filterKey, $condition, $value),
                    default => null,
                };
            }
        }

        return $query;
    }

}
