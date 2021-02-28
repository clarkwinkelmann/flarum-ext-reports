<?php

namespace ClarkWinkelmann\Reports\Controllers;

use ClarkWinkelmann\Reports\Report;
use ClarkWinkelmann\Reports\Serializers\ReportSerializer;
use Flarum\Api\Controller\AbstractListController;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListReportController extends AbstractListController
{
    public $serializer = ReportSerializer::class;

    protected function data(ServerRequestInterface $request, Document $document)
    {
        // TODO: permission
        return Report::all();
    }
}
