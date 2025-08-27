<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait GeneratesPrefixedId
{
    /**
     * Boot the trait and attach creating model event to auto-generate the ID.
     */
    public static function bootGeneratesPrefixedId(): void
    {
        static::creating(function (Model $model) {
            $primaryKey = $model->getKeyName();

            if (! empty($model->{$primaryKey})) {
                return; // Respect manually provided IDs
            }

            $prefix = property_exists($model, 'idPrefix') ? $model->idPrefix : '';

            // Find current max numeric suffix for given prefix
            $latestId = $model->newQuery()
                ->when($prefix !== '', function ($query) use ($primaryKey, $prefix) {
                    $query->where($primaryKey, 'like', $prefix . '%');
                })
                ->orderByRaw('LENGTH(' . $primaryKey . ') DESC')
                ->orderBy($primaryKey, 'desc')
                ->value($primaryKey);

            $nextNumber = 1;
            if (is_string($latestId) && $latestId !== '') {
                $numeric = preg_replace('/^' . preg_quote($prefix, '/') . '/u', '', $latestId);
                $numeric = preg_replace('/\D+/u', '', (string) $numeric);
                $nextNumber = max(1, (int) $numeric + 1);
            }

            // Optional zero padding if model defines $idPadTo
            $padTo = property_exists($model, 'idPadTo') ? (int) $model->idPadTo : 0;
            $suffix = $padTo > 0 ? str_pad((string) $nextNumber, $padTo, '0', STR_PAD_LEFT) : (string) $nextNumber;

            $candidate = $prefix . $suffix;

            // Ensure uniqueness in case of race/ordering edge cases
            while ($model->newQuery()->where($primaryKey, $candidate)->exists()) {
                $nextNumber += 1;
                $suffix = $padTo > 0 ? str_pad((string) $nextNumber, $padTo, '0', STR_PAD_LEFT) : (string) $nextNumber;
                $candidate = $prefix . $suffix;
            }

            $model->{$primaryKey} = $candidate;
        });
    }
}


