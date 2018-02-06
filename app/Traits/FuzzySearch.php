<?php

namespace App\Traits;

trait FuzzySearch
{

    public function scopeSearchLike($query, $keyword, $fields = ['name'])
    {
        return $query->where(function ($query) use ($keyword, $fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', "%{$keyword}%");
            }
        });
    }

}
