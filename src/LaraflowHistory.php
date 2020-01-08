<?php

namespace szana8\Laraflow;

use Illuminate\Database\Eloquent\Model;

class LaraflowHistory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['transition', 'from', 'user_id', 'to', 'flowable_type', 'flowable_id', 'field'];

    /**
     * A state belong to the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function flowable()
    {
        return $this->morphTo();
    }

    /**
     * A state belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
