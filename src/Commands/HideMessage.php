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

class HideMessage
{
    /**
     * @var string
     */
    public $messageId;

    /**
     * @var User
     */
    public $actor;

    /**
     * HideMessage constructor.
     * @param $messageId
     * @param User $actor
     */
    public function __construct($messageId, User $actor)
    {
        $this->messageId = $messageId;
        $this->actor = $actor;
    }
}
