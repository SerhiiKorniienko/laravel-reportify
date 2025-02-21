<?php

namespace SerhiiKorniienko\Reportify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use SerhiiKorniienko\Reportify\Models\Report;

/**
 * @mixin Model
 *
 * @phpstan-ignore trait.unused
 */
trait Reportable
{
    /**
     * Define a polymorphic one-to-many relationship.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function report(): ReportBuilder
    {
        return new ReportBuilder($this);
    }

    /**
     * Get the count of reports for the model.
     */
    public function reportCount(): int
    {
        return $this->reports()->count();
    }

    /**
     * Check if the content is flagged by a specific user.
     */
    public function isReportedBy($userId): bool
    {
        return $this->reports()->where('reporter_id', $userId)->exists();
    }

    /**
     * Scopes
     */
    public function scopeNotReportedBy($query, ?int $userId)
    {
        if (! $userId) {
            return $query;
        }

        return $query->whereDoesntHave('reports', function ($q) use ($userId) {
            $q->where('reporter_id', $userId);
        });
    }

    public function scopeNotFlaggedGlobally($query)
    {
        $threshold = config('reportify.global_threshold', 3);

        return $query->whereDoesntHave('reports', function ($q) use ($threshold) {
            $q->selectRaw('reportable_id, COUNT(*) as report_count')
                ->groupBy('reportable_id')
                ->havingRaw('COUNT(*) >= ?', [$threshold]);
        });
    }

    public function scopeVisibleFor($query, ?int $userId)
    {
        return $query
            ->notReportedBy($userId)
            ->notFlaggedGlobally();
    }
}
