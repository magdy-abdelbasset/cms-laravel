<?php

namespace App\Models;

use App\Utils\Files;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory ,SoftDeletes;
    protected $guarded = [];
    protected $appends= [
        "image",
    ];
    public function getImageAttribute()
    { 
    $image = (new Files(self::class,'first'))->get($this->id) ;
        return !empty($image->url) ? asset($image->url) :  asset(Files::IMAGE_PATH) ;
    }  
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
