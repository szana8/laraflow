<?php

namespace szana8\Laraflow;

use Illuminate\Database\Eloquent\Model;

class LaraflowHistory extends Model
{
    /**
     *
     * @var array
     */
    protected $fillable = ['transition', 'from', 'user_id', 'model_id', 'to', 'model_name'];

    /**
     * A state belong to the issue
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo("$this->model_name");
    }

    /**
     * A state belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}