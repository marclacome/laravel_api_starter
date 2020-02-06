<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelWithAttributes extends Model
{
    /**
     * setAttributes
     *
     * @param  array $data
     *
     * @return void
     */
    public function setAttributes($data)
    {
        $c = collect($data);
        $c->each(function ($item, $key) {
            $this->attributes[$key] = $item;
        });
    }
}
