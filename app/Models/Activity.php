<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, int $take = 50)
    {
        return static::whereUserId($user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(fn($activity) => $activity->created_at->format('Y-m-d'));
    }
}
