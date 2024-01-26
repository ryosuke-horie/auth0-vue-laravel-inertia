import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import fs from 'fs';

export default defineConfig(({ mode }) => {
  // .envを読み込む
  const env = loadEnv(mode, process.cwd());

  // 基本的なサーバー設定
  const serverConfig = {
    host: true,
    hmr: {
      host: env.VITE_HOST,
    },
    watch: {
      usePolling: false,
    },
    port: 5173,
  };

  // 開発環境の場合、HTTPS設定を追加
  if (mode === 'development') {
    serverConfig.https = {
      key: fs.readFileSync('/etc/nginx/ssl/server.key'),
      cert: fs.readFileSync('/etc/nginx/ssl/server.crt'),
      passphrase: env.VITE_HTTPS_PASSPHRASE,
    };
  }

  return {
    envDir: './',
    plugins: [
      laravel({
        input: ['resources/js/app.ts'],
        ssr: ['resources/js/ssr.js'],
        refresh: true,
      }),
      vue({
        template: {
          transformAssetUrls: {
            base: null,
            includeAbsolute: false,
          },
        },
      }),
    ],
    server: serverConfig,
    ssr: {
      noExternal: ['@inertiajs/server'],
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './resources/js'),
        ziggy: path.resolve('vendor/tightenco/ziggy/dist/index.es.js'),
        ziggyVue: path.resolve('vendor/tightenco/ziggy/dist/vue.es.js'),
      },
    },
    build: {
      rollupOptions: {
        external: ['/resources/js/api'],
      },
    },
  };
});
