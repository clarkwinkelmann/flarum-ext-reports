import {extend} from 'flarum/extend';
import app from 'flarum/app';
import PostControls from 'flarum/utils/PostControls';
import Button from 'flarum/components/Button';
import ReportModal from './components/ReportModal';
import Report from './models/Report';

app.initializers.add('clarkwinkelmann-reports', () => {
    app.store.models.reports = Report;

    extend(PostControls, 'userControls', function (items, post) {
        items.add('report', Button.component({
            icon: 'fas fa-flag',
            onclick() {
                app.modal.show(ReportModal, {
                    type: 'posts',
                    id: post.id(),
                });
            },
        }, app.translator.trans('clarkwinkelmann-reports.forum.controls.post')));
    });
});
