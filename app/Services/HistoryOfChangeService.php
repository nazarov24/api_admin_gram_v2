<?php

namespace App\Services;

use App\Models\Histories\BlockUpdate;
use App\Models\Histories\HistoryOfChange;
use Facade\FlareClient\Http\Response;

class HistoryOfChangeService
{
    public function set_change($model)
    {
        $is_dirty_old = [];
        foreach ($model->getDirty() as $attribute => $value) {
            $original = $model->getOriginal($attribute);
            $is_dirty_old[$attribute] = $original;
        }
        $this->create_history($model, $is_dirty_old);
        BlockUpdate::where('url', request()->url())->delete();
    }

    public function set_create($model)
    {
        $this->create_history($model, $model->toArray());
    }

    private function create_history($model, $data)
    {
        HistoryOfChange::create([
            'url' => request()->url(),
            'employee_id' => auth()->id(),
            'is_dirty_old' => json_encode($data, true),
            'model_type' => get_class($model),
            'model_id' => $model->id,
        ]);
    }
}