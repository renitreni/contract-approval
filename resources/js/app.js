require('./bootstrap');

import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import vSelect from 'vue-select';

createInertiaApp({
    resolve: name => import(`./Pages/${name}`),
    setup({el, app, props, plugin}) {
        const e = createApp({render: () => h(app, props)}).use(plugin);
        e.mount(el)
    },
});

InertiaProgress.init();

window.catchError = function (errors) {
    console.log(errors);
    let message = '';
    $.each(errors, function (index, item) {
        $.each(item, function (index, item) {
            message += item + '\n';
        })
    });
    alertify.alert(message, function () {
        alertify.error('Please try again.');
    });
}

