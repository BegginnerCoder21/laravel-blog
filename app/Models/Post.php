<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Psy\VersionUpdater\SelfUpdate;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function category(){

        return $this->belongsTo(Category::class);
    }

    public function getTitreAttribute($attribute){

        return Str::title($attribute);
    }

    public static function boot(){

        parent::boot();

        self::creating(function ($post){
            $post->user()->associate(auth()->user()->id);
            $post->category()->associate(request()->category);
        });

        // self::updating(function ($post){
        //     $post->category()->associate(request()->category);
        // });

        static::saving(function ($post){
            $post->category()->associate(request()->category);
        });
    }
}
