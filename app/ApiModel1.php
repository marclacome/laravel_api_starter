<?php

namespace App;

use App\ModelWithAttributes;

class ApiModel1 extends ModelWithAttributes
{
    protected $fillable = ['fname', 'lname', 'email', 'town'];
}
