jQuery.noConflict()(function ($) {

    const $bonusReviewCards = $('.we-bs-bonus-review-card');

    if ($bonusReviewCards) {
        let heightMax = 0;
        $bonusReviewCards.each(function () {
            heightMax = Math.max(heightMax, $(this).height());
        });
        $bonusReviewCards.each(function () {
            $(this).height(heightMax);
        });
    }

    const $paymentMethodsTrigger = $('#we-bs-review-payment-methods-trigger');
    const $hiddenPaymentMethods = $('.we-bs-review-hidden-payment-method');

    if ($paymentMethodsTrigger && $hiddenPaymentMethods) {
        const paymentMethodTriggerClosedText = $paymentMethodsTrigger.text();
        const paymentMethodTriggerOpenedText = 'Show Less';
        let paymentMethodsOpened = false;
        $paymentMethodsTrigger.on('click', function () {
            paymentMethodsOpened = !paymentMethodsOpened;
            $hiddenPaymentMethods.toggle();
            $paymentMethodsTrigger.text(
                paymentMethodsOpened
                    ? paymentMethodTriggerOpenedText
                    : paymentMethodTriggerClosedText
            );
        });
    }

    const $softwareProvidersTrigger = $('#we-bs-review-software-providers-trigger');
    const $hiddenSoftwareProviders = $('.we-bs-review-hidden-software-providers');

    if ($softwareProvidersTrigger && $hiddenSoftwareProviders) {
        const softwareProvidersTriggerClosedText = $softwareProvidersTrigger.text();
        const softwareProvidersTriggerOpenedText = 'Show Less';
        let softwareProvidersOpened = false;
        $softwareProvidersTrigger.on('click', function () {
            softwareProvidersOpened = !softwareProvidersOpened;
            $hiddenSoftwareProviders.toggle();
            $softwareProvidersTrigger.text(
                softwareProvidersOpened
                    ? softwareProvidersTriggerOpenedText
                    : softwareProvidersTriggerClosedText
            );
        });
    }


});