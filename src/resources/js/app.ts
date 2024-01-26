import 'ress'; // resetcss
import 'swiper/css';
// import 'swiper/css/effect-fade';
// import 'swiper/css/navigation';
// import 'swiper/css/pagination';
// import 'swiper/css/scrollbar';
import '../css/app.scss';
import { createSSRApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createAuth0 } from '@auth0/auth0-vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue') as any),
  setup({ el, App, props, plugin }) {
    const app = createSSRApp({ render: () => h(App, props) });

    app.config.globalProperties.route = route;

    app.use(
      createAuth0({
        domain: import.meta.env.VITE_AUTH0_DOMAIN,
        clientId: import.meta.env.VITE_AUTH0_CLIENT_ID,
        authorizationParams: {
          redirect_uri: import.meta.env.VITE_AUTH0_CALLBACK_URL,
        },
      }),
    );
    app.use(ZiggyVue);
    app.use(plugin);
    app.mount(el);
  },
});
