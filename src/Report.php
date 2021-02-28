<?php

namespace ClarkWinkelmann\Reports;

use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Flarum\User\User;

/**
 * @property int $id
 * @property string $subject_type
 * @property string $subject_id
 * @property int $user_id
 * @property string $reason
 * @property string $comment
 * @property string $moderator_notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $resolved_user_id
 * @property Carbon $resolved_at
 *
 * @property User $user
 */
class Report extends AbstractModel
{
    protected $table = 'clarkwinkelmann_reports';

    public $timestamps = true;

    protected $casts = [
        'resolved_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
