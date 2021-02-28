<?php

namespace ClarkWinkelmann\Reports\Controllers;

use ClarkWinkelmann\Reports\Report;
use ClarkWinkelmann\Reports\Serializers\ReportSerializer;
use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateReportController extends AbstractCreateController
{
    public $serializer = ReportSerializer::class;

    protected $validator;
    protected $settings;

    public function __construct(Factory $validator, SettingsRepositoryInterface $settings)
    {
        $this->validator = $validator;
        $this->settings = $settings;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        /**
         * @var User $actor
         */
        $actor = $request->getAttribute('actor');

        $report = new Report();

        // TODO: permission to allow guest
        if (!$actor->isGuest()) {
            $report->user()->associate($actor);
        }

        $attributes = Arr::get($request->getParsedBody(), 'data.attributes', []);

        $postsReasons = json_decode($this->settings->get('clarkwinkelmann-reports.posts.reasons'), true);

        $rules = [
            'subjectType' => ['required', 'in:posts'], // TODO: support other types
            'subjectId' => ['required', Rule::exists('posts', 'id')], // TODO: do not expose private posts
            'reason' => ['required', Rule::in(Arr::pluck($postsReasons, 'key'))],
            'comment' => 'required|string|max:255',
        ];

        $this->validator->make($attributes, $rules)->validate();

        // TODO: validation
        $report->subject_type = Arr::get($attributes, 'subjectType');
        $report->subject_id = Arr::get($attributes, 'subjectId');
        $report->reason = Arr::get($attributes, 'reason');
        $report->comment = Arr::get($attributes, 'comment');

        $report->save();

        return $report;
    }
}
