<?php
/**
 *
 *  This file is part of nodeloc/whisper
 *
 *  Copyright (c) 2020 Nodeloc.
 *
 *  For the full copyright and license information, please view the license.md
 *  file that was distributed with this source code.
 *
 */

namespace Nodeloc\Whisper\Api\Controllers;


use Flarum\Api\Controller\AbstractListController;
use Nodeloc\Whisper\Api\Serializers\ConversationSerializer;
use Nodeloc\Whisper\Conversation;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListConversationsController extends AbstractListController
{
    public $serializer = ConversationSerializer::class;

    public $include = [
        'recipients',
        'recipients.user'
    ];

    public $limit = 12;

    public $maxLimit = 12;

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $limit = $this->extractLimit($request);
        $offset = array_key_exists('offset', $request->getQueryParams()) ? $request->getQueryParams()['offset'] : 0;

        $conversations = Conversation::whereHas('recipients', function ($q) use ($actor) {
            $q->where('user_id', $actor->id);
        })
            ->orderBy('updated_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return $conversations;
    }
}
