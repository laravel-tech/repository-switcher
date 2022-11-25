<?php

namespace App\Models;

use App\Interfaces\Status as Statusable;
use App\Traits\Status;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $heading
 * @property string $slug
 * @property string $content
 * @property string $status
 * @property string $title
 * @property string $description
 */
class Article extends Model implements Statusable
{
    use Status;

    protected $fillable = [
        'heading',
        'slug',
        'content',
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
