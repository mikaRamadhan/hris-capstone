<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectionResult extends Model
{
    protected $fillable = [
        'application_id',
        'stage_name',
        'stage_order',
        'result',
        'notes',
        'selected_at',
    ];

    protected $casts = [
        'stage_order' => 'integer',
        'selected_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
