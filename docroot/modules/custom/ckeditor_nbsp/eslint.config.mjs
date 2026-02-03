import js from "@eslint/js";
import importPlugin from "eslint-plugin-import";
import prettierConfig from "eslint-config-prettier";

export default [
  {
    ignores: [
      "assets/vendor/**",
      "node_modules/**",
      "**/js_test_files/**",
      "**/*.js",
      "!tests/Drupal/Nightwatch/**/*.js",
      "!**/*.es6.js",
      "modules/locale/tests/locale_test.es6.js"
    ],
  },
  js.configs.recommended,
  {
    files: ["**/*.es6.js", "tests/Drupal/Nightwatch/**/*.js"],

    plugins: {
      import: importPlugin,
    },

    languageOptions: {
      ecmaVersion: "latest",
      sourceType: "script",
      globals: {
        Drupal: "readonly",
        drupalSettings: "readonly",
        drupalTranslations: "readonly",
        domready: "readonly",
        jQuery: "readonly",
        _: "readonly",
        matchMedia: "readonly",
        Backbone: "readonly",
        Modernizr: "readonly",
        CKEDITOR: "readonly",
      },
    },

    rules: {
      "consistent-return": "off",
      "no-underscore-dangle": "off",
      "max-nested-callbacks": ["warn", 3],
      "import/no-mutable-exports": "warn",
      "no-plusplus": ["warn", { allowForLoopAfterthoughts: true }],
      "no-param-reassign": "off",
      "no-prototype-builtins": "off",
      "no-unused-vars": "warn",
      "operator-linebreak": ["error", "after", { overrides: { "?": "ignore", ":": "ignore" } }],
      "no-shadow": "off",
      "no-new": "off",
      "no-continue": "off",
      "new-cap": "off",
      "max-len": "off",
      "default-case": "off",
      "prefer-destructuring": "off",
      "import/named": "off",
    },
  },
  prettierConfig,
];