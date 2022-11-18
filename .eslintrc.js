module.exports = {
  root: true,
  // parser: '@typescript-eslint/parser',
  extends: ['eslint:recommended', 'plugin:vue/vue3-essential', 'standard-with-typescript'],
  overrides: [],
  ignorePatterns: ['resources/dist/**/*'],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module'
  },
  env: {
    browser: true,
    node: true,
    es2021: true
  },
  plugins: ['vue'],
  rules: {
    'no-const-assign': 'off',
    'newline-before-return': 'error',
    semi: 'off',
    // 'quotes': ["error", "double"],
    'no-unreachable': 'error',
    'no-extra-semi': 'error',
    'no-unexpected-multiline': 'error',
    'comma-dangle': [
      'error',
      {
        arrays: 'never',
        objects: 'never',
        imports: 'never',
        exports: 'never',
        functions: 'never'
      }
    ]
  }
};
