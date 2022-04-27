<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
       
         'user_id',
          'title', 
          'body',
    ];
    
//post belongs to user
    public function user(){

    return $this->belongsTo(User::class);
}

//comments belongs to the posts
public function comments(){
    return $this->hasMany(Comments::class);
}
}
