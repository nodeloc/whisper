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

use Flarum\Api\Controller\AbstractCreateController;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Nodeloc\Whisper\Api\Serializers\MessageSerializer;
use Nodeloc\Whisper\Commands\NewMessage;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateMessageController extends AbstractCreateController
{
    /**
     * @var string
     */
    public $serializer = MessageSerializer::class;

    public $include = ['user'];

    /**
     * @var Dispatcher
     */
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');

        $message = $this->bus->dispatch(
            new NewMessage($actor, Arr::get($request->getParsedBody(), 'data', []))
        );

        return $message;
    }
}
