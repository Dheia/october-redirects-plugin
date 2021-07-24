$(function() {
    let popup;
    let popupContent = $('#synderHttpsTestModal .modal-content')[0].cloneNode(true).innerHTML;
    let action = $('[data-synder-https-test]');
    let form = action.parents('form');

    let request = (method) => {
        return new Promise((resolve, reject) => {
            form.request(method, {
                success: (data) => {
                    $(this).removeClass('oc-loading disabled');
                    resolve(data);
                },
                loading: $.oc.stripeLoadIndicator
            });
        });
    };

    let mainStep1 = (resolve, reject) => {
        request('onTest_Step1').then((data) => {
            if (data.result) {
                $('[data-test-case="1"]')
                    .attr('data-status', 'success')
                    .find('.status-text span')
                    .text(data.resultText);
                resolve.call();
            } else {
                $('[data-test-case="1"]')
                    .attr('data-status', 'error')
                    .find('.status-text span')
                    .text(data.resultText);
                
                $('[data-test-case="2"],[data-test-case="3"],[data-test-case="4"]')
                    .attr('data-status', 'canceled')
                    .find('.status-text span')
                    .text(data.resultText);
                reject.call();
            }
        });
    };

    let mainStep2 = (resolve, reject) => {
        request('onTest_Step2').then((data) => {
            if (data.result) {
                $('[data-test-case="2"]')
                    .attr('data-status', 'success')
                    .find('.status-text span')
                    .text(data.resultText);
                resolve.call();
            } else {
                $('[data-test-case="2"]')
                    .attr('data-status', 'error')
                    .find('.status-text span')
                    .text(data.resultText);
                
                $('[data-test-case="3"],[data-test-case="4"]')
                    .attr('data-status', 'canceled')
                    .find('.status-text span')
                    .text(data.resultText);
                reject.call();
            }
        });
    };

    let mainStep3 = (resolve, reject) => {
        request('onTest_Step3').then((data) => {
            $('[data-test-case="3"]')
                .attr('data-status', data.result? 'success': 'error')
                .find('.status-text span')
                .text(data.resultText);
            resolve.call();
        });
    };

    let mainStep4 = (resolve, reject) => {
        request('onTest_Step4').then((data) => {
            $('[data-test-case="4"]')
                .attr('data-status', data.result? 'success': 'error')
                .find('.status-text span')
                .text(data.resultText);
            resolve.call();
        });
    };

    let main = () => {
        let cancel = (() => {
            $('.modal.fade.in [data-dismiss]:disabled').prop('disabled', false);
        }).bind(this);

        let handle4 = mainStep4.bind(this, cancel, cancel);
        let handle3 = mainStep3.bind(this, handle4, cancel);
        let handle2 = mainStep2.bind(this, handle3, cancel);
        mainStep1.call(this, handle2, cancel);
    };


    $('[data-synder-https-test]').on('click', function() {
        popup = $.popup({ content: popupContent });
        main();
    });
}); 
