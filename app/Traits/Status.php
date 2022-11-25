<?php
namespace App\Traits;

trait Status
{
    public function scopeStatus($query, $status) {
        return 'STATUS_' . strtoupper(static::$status($query));
    }

    public function scopeTrashed($query)
    {
        return $query->whereStatus(static::STATUS_TRASHED);
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(static::STATUS_DRAFT);
    }

    public function scopePending($query)
    {
        return $query->whereStatus(static::STATUS_PENDING);
    }

    public function scopeReview($query)
    {
        return $query->whereStatus(static::STATUS_REVIEW);
    }

    public function scopeScheduled($query)
    {
        return $query->whereStatus(static::STATUS_SCHEDULED);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(static::STATUS_PUBLISHED);
    }
}