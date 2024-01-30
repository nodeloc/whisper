import app from 'flarum/forum/app';
import NotificationsDropdown from 'flarum/forum/components/NotificationsDropdown';

import ConversationsList from './ConversationsList';
import ConversationsPage from "./ConversationsPage";
import ConversationViewPage from "./ConversationViewPage";

export default class ConversationsDropdown extends NotificationsDropdown {
  oninit(vnode) {
    super.oninit(vnode);
    this.onclick = this.onclick.bind(this);
    this.getMenu = this.getMenu.bind(this);
    this.goToRoute = this.goToRoute.bind(this);
  }

  static initAttrs(attrs) {
    attrs.label ||= app.translator.trans('nodeloc-whisper.forum.dropdown.tooltip');
    attrs.icon ||= 'fas fa-sms';
    attrs.className = 'MessagesDropdown NotificationsDropdown';

    super.initAttrs(attrs);
  }

  onclick() {
    if (app.drawer.isOpen()) {
      this.goToRoute();
    }
  }

  getMenu() {
    return (
        <form className={'Dropdown-menu ' + this.attrs.menuClassName}>
          {!!this.showing && <ConversationsList mobile={false}/>}
        </form>
    );
  }

  goToRoute() {
    const conversationsRoute = app.route('conversations');
    console.error('Conversations route:',app.routes);
    if (app.route && conversationsRoute) {
      m.route(conversationsRoute);
    } else {
      console.error('Conversations route not found!');
    }
  }

  getUnreadCount() {
    return app.session.user.unreadMessages();
  }

  getNewCount() {
    return app.session.user.unreadMessages();
  }
}
