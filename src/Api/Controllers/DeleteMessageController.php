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

use Flarum\Api\Controller\AbstractDeleteController;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Nodeloc\Whisper\Commands\HideMessage;
use Psr\Http\Message\ServerRequestInterface;

class DeleteMessageController extends AbstractDeleteController
{
    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function delete(ServerRequestInterface $request)
    {
        $id = Arr::get($request->getQueryParams(), 'id');

        $actor = $request->getAttribute('actor');

        $this->bus->dispatch(
            new HideMessage($id, $actor)
        );
    }
}
