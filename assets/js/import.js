jQuery.noConflict()(function ($) {

    const $fileInput = $('#we-bs-input-file');
    const $uploadBtn = $('#we-bs-import-btn');
    const $uploadFeedback = $('#we-bs-upload-feedback');
    const $uploadCount = $('#we-bs-upload-count');
    const $uploadProgress = $('#we-bs-upload-progress');
    const $uploadedName = $('#we-bs-upload-name');

    enableUploadBtn();
    enableFileInput();

    $uploadBtn.on('click', onUploadBtnClick);

    async function onUploadBtnClick() {

        if (!$fileInput[0].files.length) {
            alert('No file selected.');
            return;
        }

        /**@type {File} */
        const file = $fileInput[0].files[0];

        if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            && file.type !== 'application/vnd.ms-excel') {
            alert('Not an xls/xlsx file.');
            return;
        }

        const workbook = XLSX.read(await file.arrayBuffer());

        if (!workbook.SheetNames.length) {
            alert('The workbook is empty.');
            return;
        }

        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];
        const json = XLSX.utils.sheet_to_json(worksheet, {
            raw: false,
            defval: '',
        });

        if (!json.length) {
            alert('The worksheet is empty.');
            return;
        }

        disableUploadBtn();
        disableFileInput();
        showUploadFeedback();

        let uploadedCount = 0;
        for (let itemIndex in json) {
            let name = '';
            if (json[itemIndex]['Name']) {
                name = json[itemIndex]['Name'];
            } else if (json[itemIndex]['Casino/betting site']) {
                name = json[itemIndex]['Casino/betting site'];
            }
            updateUploadFeedback(uploadedCount, json.length, name);
            try {
                const responseData = await upload(json[itemIndex]);
                if (responseData['code']) {
                    console.log(responseData);
                }
            } catch (responseError) {
                console.log(responseError);
            }
            uploadedCount++;
        }
        enableFileInput();
        enableUploadBtn();
        hideUploadFeedback();
        updateUploadFeedback();
    }

    function upload(bettingSite) {
        return new Promise(function (resolve, reject) {
            const requestBody = {
                _ajax_nonce: wpLocalize().nonce,
                action: wpLocalize().action,
                data: bettingSite
            }

            jQuery.post(wpLocalize().ajaxUrl, requestBody)
                .done(function (responseData) {
                    resolve(responseData);
                })
                .fail(function (responseError) {
                    reject(responseError);
                })
        });
    }

    function wpLocalize() {
        const action = window.weBsImportObject.action;
        const ajaxUrl = window.weBsImportObject.ajaxUrl;
        const nonce = window.weBsImportObject.nonce;
        return {action, ajaxUrl, nonce}
    }

    function disableUploadBtn() {
        $uploadBtn.attr('disabled', true);
    }

    function enableUploadBtn() {
        $uploadBtn.removeAttr('disabled');
    }

    function enableFileInput() {
        $fileInput.removeAttr('disabled');
    }

    function disableFileInput() {
        $fileInput.attr('disabled', true);
    }

    function hideUploadFeedback() {
        $uploadFeedback.addClass('d-none');
    }

    function showUploadFeedback() {
        $uploadFeedback.removeClass('d-none');
    }

    function updateUploadFeedback(count = 0, total = 1, name = '') {
        updateUploadProgress(count, total);
        updateUploadCount(count, total);
        updateUploadedName(name);
    }

    function updateUploadProgress(count, total) {
        $uploadProgress.width(`${(count / total) * 100}%`);
        $uploadProgress.html(`${Math.ceil((count / total) * 100).toFixed(0)}%`);
    }

    function updateUploadCount(count, total) {
        $uploadCount.html(`<p>${count} / ${total}</p>`)
    }

    function updateUploadedName(name) {
        $uploadedName.html(`<span>${name}</span>`)
    }
});