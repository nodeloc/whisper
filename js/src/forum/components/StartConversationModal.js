import Modal from 'flarum/common/components/Modal';
import Button from 'flarum/common/components/Button';
import RecipientSearch from './RecipientSearch';
import username from 'flarum/common/helpers/username';
import Stream from 'flarum/common/utils/Stream';
import withAttr from 'flarum/common/utils/withAttr';
import app from 'flarum/forum/app';

export default class StartConversationModal extends Modal {
  oninit(vnode) {
    super.oninit(vnode);

    app.cache.conversationsRecipient = null;

    this.conversations = this.attrs.conversations;

    this.already = false;

    this.messageContent = Stream('');
  }

  title() {
    return app.translator.trans('nodeloc-whisper.forum.modal.title');
  }

  className() {
    return 'StartConversationModal Modal--medium';
  }

  content() {
    return [
      <div className="Modal-body">
        {this.already ? [
          <h2>{app.translator.trans('nodeloc-whisper.forum.modal.already', {username: username(this.attrs.user)})}</h2>,
          <h2>{app.translator.trans('nodeloc-whisper.forum.modal.copied', {username: username(this.attrs.user)})}</h2>
          ] :
          <div>
            <div class="helpText">
              {app.translator.trans('nodeloc-whisper.forum.modal.help_start', {username: username(this.attrs.user)})}
            </div>
            <div className="AddRecipientModal-form">

                <div className="AddRecipientModal-form-submit">
                  <textarea value={this.messageContent()} oninput={withAttr('value', this.messageContent)} placeholder={app.translator.trans('nodeloc-whisper.forum.chat.text_placeholder')} rows="3"></textarea>
                  {Button.component({
                    type: 'submit',
                    className: 'Button Button--primary',
                    disabled: !this.messageContent(),
                  }, app.translator.trans('nodeloc-whisper.forum.modal.submit')
                  )}
                </div>
            </div>
          </div>
        }
      </div>
    ];
  }

  onsubmit(e) {
    e.preventDefault();

    const recipient = this.attrs.user;
    this.recpient = recipient;
    app.cache.conversationsRecipient = null;

    app.store.createRecord('conversations')
      .save({
        messageContents: this.messageContent(),
        recipient: recipient.id(),
      }).then(conversation => {
      if (!conversation.notNew()) {
        this.conversations.push(conversation);
        const preconv = app.session.user.conversations();
        preconv.push(conversation);
        app.session.user.conversations = Stream(preconv);
        m.redraw();
        app.modal.close();
      } else {
        console.log(conversation);
        m.redraw();
        app.modal.close();
      }
    })
  }
}
