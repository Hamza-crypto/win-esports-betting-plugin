jQuery.noConflict()(function ($) {

    const $form = $('#we-widgets-form');
    const $inputs = $('input', $form);
    const $selects = $('select', $form);
    const $submitBtn = $('#we-widgets-form-submit-btn');
    const $spinner = $('#we-widgets-form-submit-btn-spinner');

    $form.on('submit', handleSubmit);

    function handleSubmit(e) {
        e.preventDefault();
        const data = {}
        $.each($inputs, function (index, input) {
            const $input = $(input);
            data[$input.attr('name')] = $input.val();
        });
        $.each($selects, function (index, select) {
            const $select = $(select);
            data[$select.attr('name')] = $select.val();
        })
        submit(data);
    }

    function submit(data) {
        const {action, ajaxUrl, nonce} = wpLocalize();
        const requestBody = {
            _ajax_nonce: nonce,
            action,
            data
        }

        disableForm();
        jQuery.post(ajaxUrl, requestBody)
            .done(function (response) {
                enableForm();
            })
            .fail(function (error) {
                enableForm();
                console.log(error);
            })
    }

    function wpLocalize() {
        const action = window.weBsSaveWidgetsSettingsObject.action;
        const ajaxUrl = window.weBsSaveWidgetsSettingsObject.ajaxUrl;
        const nonce = window.weBsSaveWidgetsSettingsObject.nonce;
        return {action, ajaxUrl, nonce}
    }

    function disableForm() {
        $inputs.attr('disabled', true);
        $selects.attr('disabled', true);
        $submitBtn.attr('disabled', true);
        $spinner.toggle();
    }

    function enableForm() {
        $inputs.attr('disabled', false);
        $selects.attr('disabled', false);
        $submitBtn.attr('disabled', false);
        $spinner.toggle();
    }
});