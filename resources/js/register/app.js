/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'
import { createApp, h } from 'vue'
import App from './App.vue'
import routes from './routes'
import { createRouter, createWebHistory } from 'vue-router'
import { Notyf } from 'notyf'
import { LoadingPlugin } from 'vue-loading-overlay'
import vueFilePond from 'vue-filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'active',
    routes,
})

const notyf = new Notyf({
    duration: 5000,
    position: {
        x: 'right',
        y: 'top',
    },
    ripple: true,
})

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview, FilePondPluginFileValidateSize, FilePondPluginImageValidateSize)

const app = createApp(App)

app.config.globalProperties.$notyf = notyf

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.use(
    LoadingPlugin,
    {
        enforceFocus: false,
        canCancel: false,
        loader: 'spinner',
        color: '#8080ff',
        backgroundColor: '#111111',
        width: 110,
        height: 110,
        opacity: 0.4,
        zIndex: 1999,
    },
    {
        default: () =>
            h('div', { class: 'grid min-h-[240px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible' }, [
                h('div', { class: 'flex gap-4' }, [
                    h('svg', {
                        class: 'text-gray-300 animate-spin',
                        viewBox: '0 0 64 64',
                        xmlns: 'http://www.w3.org/2000/svg',
                        width: 30,
                        height: 30,
                        fill: 'none',
                        innerHTML: `
                    <path d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"></path>
                `,
                    }),
                    h('h2', { class: 'text-center text-gray-200 text-xl font-semibold' }, 'Loading...'),
                ]),
            ]),
    }
)
app.component('file-pond', FilePond)
app.use(router)
app.mount('#register-container')
