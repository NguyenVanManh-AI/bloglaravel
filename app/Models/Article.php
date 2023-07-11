<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'id_user', 'title', 'content'
    ];
    public function commentsCount(){
        return $this->hasMany(Comment::class, 'id_article')->selectRaw('id_article, count(*) as count_comment')->groupBy('id_article');
    }

}
