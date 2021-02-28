import app from 'flarum/app';
import Button from 'flarum/components/Button';
import LocalizedInput from './components/LocalizedInput';

/* global m */

const settingsPrefix = 'clarkwinkelmann-reports.';
const translationPrefix = 'clarkwinkelmann-reports.admin.settings.';

app.initializers.add('clarkwinkelmann-reports', () => {
    app.extensionData
        .for('clarkwinkelmann-reports')
        .registerSetting(function () {
            let reasons;

            try {
                reasons = JSON.parse(this.setting(settingsPrefix + 'posts.reasons')());
            } catch (e) {
                // do nothing, we'll reset to something usable
            }

            if (!Array.isArray(reasons)) {
                reasons = [];
            }

            return [
                m('.Form-group', [
                    m('label', app.translator.trans(translationPrefix + 'reasons')),
                    m('table', [
                        m('thead', m('tr', [
                            m('th', app.translator.trans(translationPrefix + 'header.key')),
                            m('th', app.translator.trans(translationPrefix + 'header.label')),
                            m('th'),
                        ])),
                        m('tbody', [
                            reasons.map((reason, index) => m('tr', [
                                m('td', m('input.FormControl', {
                                    type: 'text',
                                    value: reason.key || '',
                                    onchange: event => {
                                        reason.key = event.target.value;
                                        this.setting(settingsPrefix + 'posts.reasons')(JSON.stringify(reasons));
                                    },
                                })),
                                m('td', m(LocalizedInput, {
                                    value: reason,
                                    onchange: (locale, value) => {
                                        console.log(locale, value);
                                        reason[locale] = value;
                                        this.setting(settingsPrefix + 'posts.reasons')(JSON.stringify(reasons));
                                    },
                                })),
                                m('td', Button.component({
                                    className: 'Button Button--icon',
                                    icon: 'fas fa-times',
                                    onclick: () => {
                                        reasons.splice(index, 1);

                                        this.setting(settingsPrefix + 'posts.reasons')(JSON.stringify(reasons));
                                    },
                                })),
                            ])),
                            m('tr', m('td', {
                                colspan: 3,
                            }, Button.component({
                                className: 'Button Button--block',
                                onclick: () => {
                                    reasons.push({
                                        key: '',
                                    });

                                    this.setting(settingsPrefix + 'posts.reasons')(JSON.stringify(reasons));
                                },
                            }, app.translator.trans(translationPrefix + 'add')))),
                        ]),
                    ]),
                ]),
            ];
        });
});
