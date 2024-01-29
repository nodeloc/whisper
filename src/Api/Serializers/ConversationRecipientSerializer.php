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

namespace Nodeloc\Whisper\Api\Serializers;


use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\UserSerializer;
use Nodeloc\Whisper\ConversationUser;

class ConversationRecipientSerializer extends AbstractSerializer
{
    protected $type = 'conversation_users';

    protected function getDefaultAttributes($conversationUser)
    {
        if (!($conversationUser instanceof ConversationUser)) {
            throw new \InvalidArgumentException(
                get_class($this) . ' can only serialize instances of ' . ConversationUser::class
            );
        }

        return [
            'userId' => $conversationUser->user_id,
            'conversationId' => $conversationUser->conversation_id,
            'lastRead' => $conversationUser->last_read_message_number
        ];
    }

    public function user($conversationUser)
    {
        return $this->hasOne($conversationUser, UserSerializer::class);
    }

    public function conversation($conversationUser)
    {
        return $this->hasOne($conversationUser, ConversationSerializer::class);
    }
}
