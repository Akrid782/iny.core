import { BitrixVue } from 'ui.vue3';
import 'ui.forms';
import 'ui.layout-form';
import 'ui.buttons';
import { Router } from './router';
import { Main } from './components/Main';

export class AppSettings {
    #application;
    #rootNode;

    constructor(rootNode) {
        this.#rootNode = document.querySelector(rootNode);
    }

    attachTemplate() {
        const context = this;

        this.#application = BitrixVue.createApp({
            name: 'SettingsBuilder',
            components: {
                Main,
            },
            beforeCreate() {
                this.$bitrix.Application.set(context);
            },
            // language=Vue
            template: `
                <Main />
            `,
        });

        this.#application.use(Router);
        this.#application.mount(this.#rootNode);
    }

    detachTemplate() {
        if (this.#application) {
            this.#application.unmount();
        }
    }
}
