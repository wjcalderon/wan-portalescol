import js from "@eslint/js";
import pluginVue from "eslint-plugin-vue";
import globals from "globals";

export default [
    js.configs.recommended,
    ...pluginVue.configs["flat/vue2-essential"],

    {
        files: ["**/*.{js,vue}"],
        languageOptions: {
            ecmaVersion: 2022,
            sourceType: "module",
            globals: {
                ...globals.node,
                ...globals.browser
            }
        },
        rules: {
            "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
            "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
            "vue/multi-word-component-names": ["error", { ignores: ["Glossary", "Pager", "Result"] }]
        }
    },

    { ignores: ["dist/**", "node_modules/**"] }
];