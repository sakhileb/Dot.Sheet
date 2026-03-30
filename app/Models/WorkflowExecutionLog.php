<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowExecutionLog extends Model
{
    protected $fillable = [
        'spreadsheet_id',
        'triggered_by_user_id',
        'rule_id',
        'rule_name',
        'rule_action',
        'rule_operator',
        'rule_expected_value',
        'row_index',
        'col_index',
        'cell_reference',
        'actual_value',
        'notification_channels',
        'status',
    ];

    protected $casts = [
        'notification_channels' => 'array',
    ];

    public function spreadsheet(): BelongsTo
    {
        return $this->belongsTo(Spreadsheet::class);
    }

    public function triggeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by_user_id');
    }
}
