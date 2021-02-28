import app from 'flarum/app';
import Button from 'flarum/components/Button';
import SelectDropdown from 'flarum/components/SelectDropdown';

/* global m */

export default class LocalizedInput {
    oninit() {
        this.locale = app.data.locale;
    }

    view(vnode) {
        const locales = [];

        for (const locale in app.data.locales) {
            if (!app.data.locales.hasOwnProperty(locale)) {
                continue;
            }

            locales.push(Button.component({
                active: this.locale === locale,
                icon: this.locale === locale ? 'fas fa-check' : true,
                onclick: () => {
                    this.locale = locale;
                },
            }, locale.toUpperCase()));
        }

        return m('.ReportLocalizedInput', [
            SelectDropdown.component({
                buttonClassName: 'Button',
            }, locales),
            m('input.FormControl', {
                value: vnode.attrs.value[this.locale] || '',
                onchange: event => {
                    vnode.attrs.onchange(this.locale, event.target.value);
                },
            }),
        ]);
    }
}
