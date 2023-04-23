<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'published',
        'author_id',
        'genre_id'
    ];

    public static function filters()
    {
        return [
            [
                "type" => "text",
                "name" => "first_name",
                "label" => "First Name"
            ],
            [
                "type"=> "select",
                "name"=> "author_id",
                "label"=> "Author",
                "values" => getList(Author::all())
            ],
            [
                "type"=> "select",
                "name"=> "genre_id",
                "label"=> "Genre",
                "values" => getList(Genre::all())
            ],
        ];
    }

}
