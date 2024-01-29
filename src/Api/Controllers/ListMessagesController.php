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
use Nodeloc\Whisper\Api\Serializers\MessageSerializer;
use Tobscure\JsonApi\Document;
use Flarum\User\Exception\PermissionDeniedException;
use Illuminate\Support\Arr;
use Nodeloc\Whisper\Conversation;
use Nodeloc\Whisper\Message;
use Psr\Http\Message\ServerRequestInterface;

class ListMessagesController extends AbstractListController
{
    public $serializer = MessageSerializer::class;

    public $include = ['user'];

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $conversationId = Arr::get($request->getQueryParams(), 'id');
        $actor = $request->getAttribute('actor');
        $limit = $this->extractLimit($request);
        $offset = $request->getQueryParams()['offset'];

        $conversation = Conversation::find($conversationId);

        if (!$conversation->recipients()->where('user_id', $actor->id)->exists()) {
            throw new PermissionDeniedException;
        }

        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return $messages;
    }
}
