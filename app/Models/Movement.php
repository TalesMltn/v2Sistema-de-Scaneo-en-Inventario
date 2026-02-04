<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['tool_id', 'type', 'stock_before', 'stock_after'];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}