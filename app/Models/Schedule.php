<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'office_id',
        'is_wfa',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
        /*************  ✨ Codeium Command ⭐  *************/
        /**
         * Get the shift that this schedule belongs to
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        /******  cbced6bc-d7ef-4dbb-b631-36c514ba677e  *******/
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
