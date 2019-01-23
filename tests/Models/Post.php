<?php

namespace Zbiller\Sort\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zbiller\Sort\Traits\IsSortable;

class Post extends Model
{
    use IsSortable;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'name',
        'views',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'post_id');
    }
}
