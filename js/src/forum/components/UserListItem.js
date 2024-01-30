import Component from 'flarum/common/Component';
import avatar from 'flarum/common/helpers/avatar';
import username from 'flarum/common/helpers/username';
import userOnline from 'flarum/common/helpers/userOnline';
import app from 'flarum/forum/app';

export default class UserListItem extends Component {
  oninit(vnode) {
    this.conversation = vnode.attrs.conversation;
    this.index = vnode.attrs.i;
    this.active = vnode.attrs.active;
    this.loading = true;
    this.mobile = vnode.attrs.mobile;
    this.conversation.recipients().map((recipient) => {
      if (parseInt(recipient.user().id()) !== parseInt(app.session.user.id())) {
        this.user = recipient.user();
        this.loading = false;
        m.redraw();
      }
    });
    super.oncreate(vnode);
  }

  onremove(vnode) {
    super.onremove(vnode);
  }

  oncreate(vnode) {
    super.oncreate(vnode);
  }


  onclick(e) {
    this.clicked = true; // Set the flag to true when the item is clicked
    this.attrs.onclick(e); // Call the original onclick handler

    // Remove 'active' class from other items
    const items = document.querySelectorAll('.UserListItem');
    items.forEach(item => {
      if (item !== e.currentTarget) {
        item.classList.remove('active');
      }
    });
  }

  view(vnode) {
    if (this.loading || !this.user) return null;

    return (
        <li id={this.index} className={this.clicked ? 'UserListItem active' : 'UserListItem'} onclick={(e) => this.onclick(e)}>
          <div className="UserListItem-content">
            {avatar(this.user)}
          </div>
        </li>
    );
  }
}
