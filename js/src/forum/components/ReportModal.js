import app from 'flarum/app';
import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';

/* global m */

export default class ReportModal extends Modal {
    oninit(vnode) {
        super.oninit(vnode);

        this.reason = null;
        this.comment = '';
        this.loading = false;
    }

    title() {
        return app.translator.trans('clarkwinkelmann-reports.forum.modal.title');
    }

    content() {
        const reasons = app.forum.attribute('reportPostsReasons') || [];

        return m('.Modal-body', [
            reasons.map(reason => m('.Form-group', m('label', [
                m('input', {
                    type: 'radio',
                    checked: this.reason === reason.key,
                    onchange: () => {
                        this.reason = reason.key;
                    },
                }),
                ' ',
                reason[app.data.locale],
            ]))),
            m('.Form-group', [
                m('textarea.FormControl', {
                    value: this.comment,
                    onchange: event => {
                        this.comment = event.target.value;
                    },
                    disabled: this.loading,
                }),
            ]),
            m('.Form-group', [
                Button.component({
                    type: 'submit',
                    className: 'Button Button--primary Button--block',
                    loading: this.loading,
                    disabled: this.loading,
                }, app.translator.trans('clarkwinkelmann-reports.forum.modal.submit')),
            ]),
        ]);
    }

    onsubmit(event) {
        event.preventDefault();

        this.loading = true;

        app.store.createRecord('reports').save({
            subjectType: this.attrs.type,
            subjectId: this.attrs.id,
            reason: this.reason,
            comment: this.comment,
        }).then(() => {
            app.modal.close();
        }).catch(error => {
            this.loading = false;
            m.redraw();

            throw error;
        });
    }
}
