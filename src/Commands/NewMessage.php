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

use Flarum\User\User;

class NewMessage
{
    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @var null
     */
    public $conversationId;

    /**
     * NewMessage constructor.
     * @param User $actor
     * @param array $data
     * @param null $conversationId
     */
    public function __construct(User $actor, array $data, $conversationId = null)
    {
        $this->actor = $actor;
        $this->data = $data;
        $this->conversationId = $conversationId;
    }
}
