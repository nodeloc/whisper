import app from 'flarum/app';
import {extend} from 'flarum/extend';
import IndexPage from 'flarum/components/IndexPage';
import Message from './models/Message';
import Conversation from './models/Conversation';
import ConversationUser from './models/ConversationUser';
import User from 'flarum/models/User';
import Model from 'flarum/Model';
import ConversationsPage from './components/ConversationsPage';
import ConversationViewPage from './components/ConversationViewPage';
import Stream from 'flarum/utils/Stream';
import UserControls from 'flarum/utils/UserControls';
import Button from 'flarum/components/Button';

import addConversationsDropdown from './addConversationsDropdown'
import StartConversationModal from "./components/StartConversationModal";

app.initializers.add('nodeloc-whisper', function (app) {
  app.store.models.messages = Message;
  app.store.models.conversations = Conversation;
  app.store.models.conversation_users = ConversationUser;

  User.prototype.conversations = Model.hasMany('conversations');
  User.prototype.unreadMessages = Model.attribute('unreadMessages');

  app.routes.conversations = { path: '/whisper/conversations', component: ConversationsPage };
  app.routes.messages = { path: '/whisper/messages/:id', component: ConversationViewPage };
// 构建路由对象

  addConversationsDropdown();

  extend(IndexPage.prototype, 'oncreate', function () {
    if (app.pusher) {
      app.pusher.then((object) => {
        const channels = object.channels;
        if (channels.user) {
          channels.user.bind('newMessage', (data) => {
            app.session.user.unreadMessages = Stream(app.session.user.unreadMessages() + 1);
            m.redraw();
          });
        }
      });
    }
  });

  extend(IndexPage.prototype, 'onremove', function () {
    if (app.pusher) {
      app.pusher.then((object) => {
        const channels = object.channels;
        if (channels.user) {
          channels.user.unbind('newMessage');
        }
      });
    }
  })
  extend(UserControls, 'moderationControls', (items, user) => {
    if (app.forum.attribute('canMessage')) {
      items.add('newMessage', Button.component({
        icon: 'fas fa-sms',
        onclick: () => app.modal.show(StartConversationModal, {user})
      }, app.translator.trans('nodeloc-whisper.forum.chat.chat_with')));
    }
  });
});
