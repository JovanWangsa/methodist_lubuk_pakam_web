// Konfigurasi PM2 untuk menjalankan API di VPS: pm2 start ecosystem.config.cjs
module.exports = {
  apps: [
    {
      name: 'api',
      script: 'src/server.js',
      instances: 1,
      env: { NODE_ENV: 'production' },
      max_memory_restart: '300M',
      time: true,
    },
  ],
};
