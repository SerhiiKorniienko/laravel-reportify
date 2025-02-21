<?php

namespace SerhiiKorniienko\Reportify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    protected $table = 'reportify_reports';

    protected $fillable = [
        'reportable_type',
        'reportable_id',
        'reporter_id',
        'reason',
        'status',
    ];

    /**
     * Get the parent reportable model (e.g., User, Post, Comment etc.).
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
