{{ $translator->trans('nodeloc-whisper.forum.notifications.email.new_private_message.youHaveReceivedNewMessage', ['{user}' => $blueprint->user->display_name]) }}

{{ $blueprint->message->message }}
