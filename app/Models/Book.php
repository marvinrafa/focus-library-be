<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function checkouts()
    {
        return $this->hasMany(BookCheckout::class, 'book_id');
    }

    public function activeCheckouts()
    {
        return $this->hasMany(BookCheckout::class, 'book_id')->where('active', true);
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    protected $fillable = [
        'title',
        'year',
        'published',
        'author_id',
        'genre_id',
        'base_stock'
    ];

    public static function filters()
    {
        return [
            [
                "type" => "text",
                "name" => "title",
                "label" => "Title"
            ],
            [
                "type" => "select",
                "name" => "author_id",
                "label" => "Author",
                "scoped" => true,
                "values" => getList(Author::all())
            ],
            [
                "type" => "select",
                "name" => "genre_id",
                "label" => "Genre",
                "scoped" => true,
                "values" => getList(Genre::all())
            ],
        ];
    }

    public function scopeAuthorId($query, $input)
    {
        return $query->where('author_id', $input);
    }

    public function scopeGenreId($query, $input)
    {
        return $query->where('genre_id', $input);
    }

    public function scopePublished($query, $input)
    {
        return $query->where('published', $input == "true");
    }

    public function scopeSearch($query, $input) {
        return $query
            ->where('title', 'ilike', '%'.$input.'%')
            ->orWhereHas('author', function( $query ) use ( $input ){
                $query->where('name', 'ilike', '%'.$input.'%');
            })
            ->orWhereHas('genre', function( $query ) use ( $input ){
                $query->where('name', 'ilike', '%'.$input.'%');
            });
    }
}
