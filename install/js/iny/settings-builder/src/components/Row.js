import { LabelText } from 'LabelText';

export const Row = {
    props: ['title'],
    components: {
        LabelText,
    },
    // language=Vue
    template: `
        <div class='ui-form-row'>
            <LabelText :title='title'></LabelText>
            <div class='ui-form-content'>
                <div class='ui-form-row'>
                    <label class='ui-ctl ui-ctl-textbox ui-ctl-w100'>
                        <input type='text' name='MIN_PHP_VERSION' class='ui-ctl-element' placeholder='8.1'
                               value='<?= PHP_VERSION ?>'>
                    </label>
                </div>
            </div>
        </div>
    `,
};
