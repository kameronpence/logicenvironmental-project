<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_name',
        'changes',
        'ip_address',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, $model, ?array $changes = null): self
    {
        $modelName = '';
        if (method_exists($model, 'getActivityName')) {
            $modelName = $model->getActivityName();
        } elseif (isset($model->title)) {
            $modelName = $model->title;
        } elseif (isset($model->name)) {
            $modelName = $model->name;
        }

        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => class_basename($model),
            'model_id' => $model->id ?? null,
            'model_name' => $modelName,
            'changes' => $changes,
            'ip_address' => request()->ip(),
        ]);
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            default => ucfirst($this->action),
        };
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'success',
            'updated' => 'primary',
            'deleted' => 'danger',
            default => 'secondary',
        };
    }
}
