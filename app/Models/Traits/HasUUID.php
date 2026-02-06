<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUUID {
    public static function bootHasUUID() {
        static::creating(function (Model $model) {
            $model->setAttribute('uuid', Str::uuid());
        });
    }

    public static function findByUuid($uuid, $abort = true) {

        if (static::where('uuid', $uuid)->exists()) {
            return static::where('uuid', $uuid)->first();
        }

        if ($abort)
            abort(404);
    }
}
