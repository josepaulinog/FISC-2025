import path from 'path';

// Get the current working directory
const currentPath = process.cwd();

// Extract the folder name of the theme dynamically
const themeFolder = currentPath.split(path.sep).pop();

/**
 * Compiler configuration
 *
 * @type {import('@roots/bud').Config}
 */
export default async (app) => {
  /**
   * Application assets & entrypoints
   */
  app
    .entry('app', ['@scripts/app', '@styles/app'])
    .entry('editor', ['@scripts/editor', '@styles/editor'])
    .assets(['images', 'fonts']);

  /**
   * Set public path dynamically
   */
  app.setPublicPath(`/wp-content/themes/${themeFolder}/public/`);

  /**
   * Development server settings
   */
  app.setUrl(
    process.env.NODE_ENV === 'production'
      ? 'https://fisc.freebalance.com/'
      : 'http://localhost:3000'
  );

  if (process.env.NODE_ENV !== 'production') {
    app.setProxyUrl('https://www.fisc.local/');
    app.watch(['resources/views', 'app']);
  }

  /**
   * Generate WordPress `theme.json`
   */
  app.wpjson
    .setSettings({
      background: {
        backgroundImage: true,
      },
      color: {
        custom: false,
        customDuotone: false,
        customGradient: false,
        defaultDuotone: false,
        defaultGradients: false,
        defaultPalette: false,
        duotone: [],
      },
      custom: {
        spacing: {},
        typography: {
          fontFamily: 'var(--wp--preset--font-family--sans)',
          'font-size': {},
          'line-height': {},
        },
      },
      spacing: {
        padding: true,
        units: ['px', '%', 'em', 'rem', 'vw', 'vh'],
      },
      typography: {
        customFontSize: false,
      },
    })
    .useTailwindColors()
    .useTailwindFontFamily()
    .useTailwindFontSize()
    .setOption('styles', {
      typography: {
        fontFamily: 'var(--wp--preset--font-family--sans)',
      },
    });
};
