<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'active',
    ];

    // Genera slug automáticamente y asegura unicidad
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);

        $originalSlug = $this->attributes['slug'];
        $count = 1;
        while (static::where('slug', $this->attributes['slug'])
                    ->where('id', '!=', $this->id ?? 0)
                    ->exists()) {
            $this->attributes['slug'] = $originalSlug . '-' . $count++;
        }
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}