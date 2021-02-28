<?php

namespace ClarkWinkelmann\Reports\Serializers;

use ClarkWinkelmann\Reports\Report;
use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;

class ReportSerializer extends AbstractSerializer
{
    protected $type = 'reports';

    /**
     * @param Report $report
     * @return array
     */
    protected function getDefaultAttributes($report)
    {
        return [
            'reason' => $report->reason,
            'comment' => $report->comment,
            'moderatorNotes' => $report->moderator_notes,
            'createdAt' => $this->formatDate($report->created_at),
        ];
    }

    public function user($report)
    {
        return $this->hasOne($report, BasicUserSerializer::class);
    }
}
