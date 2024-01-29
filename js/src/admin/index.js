import app from 'flarum/admin/app';

app.initializers.add('nodeloc-whisper', () => {
  app.extensionData
    .for('nodeloc-whisper')
    .registerSetting({
      setting: 'nodeloc-whisper.return_key',
      type: 'bool',
      label: app.translator.trans('nodeloc-whisper.admin.settings.return_key'),
    })
    .registerPermission(
      {
        icon: 'fas fa-user-lock',
        label: app.translator.trans('nodeloc-whisper.admin.permissions.start_label'),
        permission: 'startConversation',
      },
      'start'
    );
});
