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

namespace Nodeloc\Whisper\Commands;

use Flarum\User\Exception\PermissionDeniedException;
use Nodeloc\Whisper\Message;

class HideMessageHandler
{
    public function handle(HideMessage $command)
    {
        $actor = $command->actor;
        $messageId = $command->messageId;

        $actor->assertCan('deleteMessage');

        $message = Message::find($messageId);

        if ($actor->id != $message->user_id) {
            throw new PermissionDeniedException;
        }

        $message->is_hidden = true;

        $message->save();
    }
}
