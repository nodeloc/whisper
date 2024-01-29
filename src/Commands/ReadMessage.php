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

class ReadMessage
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
     * ReadMessage constructor.
     * @param User $actor
     * @param array $data
     */
    public function __construct(User $actor, array $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }
}
