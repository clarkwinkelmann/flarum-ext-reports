<?php

namespace ClarkWinkelmann\Reports;

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),

    new Extend\Locales(__DIR__ . '/resources/locale'),

    (new Extend\Routes('api'))
        ->get('/reports', 'clarkwinkelmann-reports.index', Controllers\ListReportController::class)
        ->post('/reports', 'clarkwinkelmann-reports.store', Controllers\CreateReportController::class)
        ->get('/reports/{id:[0-9]+}', 'clarkwinkelmann-reports.show', Controllers\ShowReportController::class)
        ->patch('/reports/{id:[0-9]+}', 'clarkwinkelmann-reports.update', Controllers\UpdateReportController::class)
        ->delete('/reports/{id:[0-9]+}', 'clarkwinkelmann-reports.delete', Controllers\DeleteReportController::class),

    (new Extend\Settings())
        ->serializeToForum('reportPostsReasons', 'clarkwinkelmann-reports.posts.reasons', function ($value) {
            return json_decode($value, true);
        }),
];
