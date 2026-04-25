module.exports = {
  ci: {
    collect: {
      startServerCommand: 'php artisan serve --port=8080',
      startServerReadyTimeout: 30000,
      url: ['http://127.0.0.1:8080'],
      numberOfRuns: 3,
      settings: {
        chromeFlags: '--no-sandbox --disable-gpu --headless'
      }
    },
    assert: {
      assertions: {
        'categories:performance': ['warn', { minScore: 0.9 }],
        'categories:accessibility': ['error', { minScore: 0.95 }],
        'categories:best-practices': ['error', { minScore: 0.95 }],
        'categories:seo': ['error', { minScore: 1.0 }],
        'first-contentful-paint': ['warn', { maxNumericValue: 2000 }],
        'interactive': ['warn', { maxNumericValue: 3500 }],
      },
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};
