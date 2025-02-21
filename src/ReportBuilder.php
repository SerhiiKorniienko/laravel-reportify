<?php

namespace SerhiiKorniienko\Reportify;

use Illuminate\Database\Eloquent\Model;
use SerhiiKorniienko\Reportify\Models\Report;

final class ReportBuilder
{
    protected array $attributes = [];

    public function __construct(protected Model $reportable) {}

    public function withReporter($reporter): self
    {
        $this->attributes['reporter_id'] = is_object($reporter) ? $reporter->id : $reporter;

        return $this;
    }

    public function withReason(string $reason): self
    {
        $this->attributes['reason'] = $reason;

        return $this;
    }

    public function withStatus(string $status): self
    {
        $this->attributes['status'] = $status;

        return $this;
    }

    public function create(): Report
    {
        /** @phpstan-ignore-next-line */
        return $this->reportable->reports()->create($this->attributes);
    }
}
