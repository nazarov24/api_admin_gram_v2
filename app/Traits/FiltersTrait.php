<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait FiltersTrait
{
    public function scopeFilterString($query, $column, $str_condition, $value)
    {
        if (in_array($str_condition, ["startLike", "endLike", "include", "notInclude", "notStartLike", "notEndLike"])) {
            if ($str_condition == "startLike") {
                $query->where(DB::raw("$column"), 'LIKE', $value . '%');
            } elseif ($str_condition == "endLike") {
                $query->where(DB::raw("$column"), 'LIKE', '%' . $value);
            } elseif ($str_condition == "include") {
                $query->where(DB::raw("$column"), 'LIKE', '%' . $value . '%');
            } elseif ($str_condition == "notInclude") {
                $query->where(DB::raw("$column"), 'NOT LIKE', '%' . $value . '%');
            } elseif ($str_condition == "notStartLike") {
                $query->where(DB::raw("$column"), 'NOT LIKE', $value . '%');
            } elseif ($str_condition == "notEndLike") {
                $query->where(DB::raw("$column"), 'NOT LIKE', '%' . $value);
            }
        } else if (in_array($str_condition, ["nullable", "notNullable", "inArray", "notInArray"])) {
            switch ($str_condition) {
                case "nullable":
                    $query->whereNull(DB::raw("$column"));
                    break;
                case "notNullable":
                    $query->whereNotNull(DB::raw("$column"));
                    break;
                case "inArray":
                    $value = (array)json_decode($value);
                    $query->whereIn(DB::raw("$column"), $value);
                    break;
                case "notInArray":
                    $value = (array)json_decode($value);
                    $query->whereNotIn(DB::raw("$column"), $value);
                    break;
            }
        } else {
            $condition = "=";
            switch ((string)$str_condition) {
                case "equalOrMore":
                    $condition = ">=";
                    break;
                case "equalOrLess":
                    $condition = "<=";
                    break;
                case "more":
                    $condition = ">";
                    break;
                case "less":
                    $condition = "<";
                    break;
                case "notEqual":
                    $condition = "<>";
                    break;
            }
            if ($value > 0) {
                $query->where(DB::raw("$column"), $condition, $value);
            }
        }

        return $query;
    }

    public function scopeFilterInt($query, $column, $str_condition, $value)
    {
        if (in_array($str_condition, ["nullable", "notNullable", "inArray", "notInArray"])) {
            switch ($str_condition) {
                case "nullable":
                    $query->whereNull($column);
                    break;
                case "notNullable":
                    $query->whereNotNull($column);
                    break;
                case "inArray":
                    $value = (array)json_decode($value);
                    $query->whereIn($column, $value);
                    break;
                case "notInArray":
                    $value = (array)json_decode($value);
                    $query->whereNotIn($column, $value);
                    break;
            }
        } else {
            $condition = "=";
            switch ((string)$str_condition) {
                case "equalOrMore":
                    $condition = ">=";
                    break;
                case "equalOrLess":
                    $condition = "<=";
                    break;
                case "more":
                    $condition = ">";
                    break;
                case "less":
                    $condition = "<";
                    break;
                case "notEqual":
                    $condition = "<>";
                    break;
            }
            //if ($value > 0) {
            $query->where($column, $condition, $value);
            //}
        }

        return $query;
    }

    public function scopeFilterRelationStringHas($query, $relation, $column, $str_condition, $value)
    {
        if (in_array($str_condition, ["startLike", "endLike", "include", "notInclude", "notStartLike", "notEndLike"])) {
            if ($str_condition == "startLike") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'like', "$value%");
                    }
                );
            } elseif ($str_condition == "endLike") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'LIKE', '%' . $value);
                    }
                );
            } elseif ($str_condition == "include") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'LIKE', '%' . $value . '%');
                    }
                );
            } elseif ($str_condition == "notInclude") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'NOT LIKE', '%' . $value . '%');
                    }
                );
            } elseif ($str_condition == "notStartLike") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'NOT LIKE', $value . '%');
                    }
                );
            } elseif ($str_condition == "notEndLike") {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $column) {
                        return $q->where(DB::raw("$column"), 'NOT LIKE', '%' . $value);
                    }
                );
            }
        } elseif (in_array($str_condition, ["nullable", "notNullable", "inArray", "notInArray"])) {
            switch ($str_condition) {
                case "nullable":
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNull(DB::raw("$column"));
                        }
                    );
                    break;
                case "notNullable":
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNotNull(DB::raw("$column"));
                        }
                    );
                    break;
                case "inArray":
                    $value = (array)json_decode($value);
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereIn(DB::raw("$column"), $value);
                        }
                    );
                    break;
                case "notInArray":
                    $value = (array)json_decode($value);
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNotIn(DB::raw("$column"), $value);
                        }
                    );
                    break;
            }
        } else {
            $condition = "=";
            switch ((string)$str_condition) {
                case "equalOrMore":
                    $condition = ">=";
                    break;
                case "equalOrLess":
                    $condition = "<=";
                    break;
                case "more":
                    $condition = ">";
                    break;
                case "less":
                    $condition = "<";
                    break;
                case "notEqual":
                    $condition = "<>";
                    break;
            }
            if ($value > 0) {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $condition, $column) {
                        return $q->where(DB::raw("$column"), $condition, $value);
                    }
                );
            }
        }
        return $query;
    }

    public function scopeFilterRelationIntHas($query, $relation, $column, $str_condition, $value)
    {
        if (in_array($str_condition, ["nullable", "notNullable", "inArray", "notInArray"])) {
            switch ($str_condition) {
                case "nullable":
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNull(DB::raw("$column"));
                        }
                    );
                    break;
                case "notNullable":
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNotNull(DB::raw("$column"));
                        }
                    );
                    break;
                case "inArray":
                    $value = (array)json_decode($value);
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereIn(DB::raw("$column"), $value);
                        }
                    );
                    break;
                case "notInArray":
                    $value = (array)json_decode($value);
                    $query->whereHas(
                        $relation,
                        function ($q) use ($value, $column) {
                            return $q->whereNotIn(DB::raw("$column"), $value);
                        }
                    );
                    break;
            }
        } else {
            $condition = "=";
            switch ((string)$str_condition) {
                case "equalOrMore":
                    $condition = ">=";
                    break;
                case "equalOrLess":
                    $condition = "<=";
                    break;
                case "more":
                    $condition = ">";
                    break;
                case "less":
                    $condition = "<";
                    break;
                case "notEqual":
                    $condition = "<>";
                    break;
            }
            if ($value > 0) {
                $query->whereHas(
                    $relation,
                    function ($q) use ($value, $condition, $column) {
                        return $q->where(DB::raw("$column"), $condition, $value);
                    }
                );
            }
        }
        return $query;
    }
}
