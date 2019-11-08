const Configuration = function () {
    this.totalInput = $('#totalWords');
    this.mostCommonWordInput = $('#wordExclude');
    this.rankRadio = $('[name="rank"]');
    this.supportedPlaces = $('.supportedPlace');

    this.getUrlPart = () => {
        let supportedItems = [];

        this.supportedPlaces.filter(':checked').each(function () {
            supportedItems.push($(this).val());
        });
console.info(this);
        return '/{rank}/{removingItems}/{supportedPlaceIds}/{totalWords}'
            .replace('{rank}', this.rankRadio.filter(':checked').val())
            .replace('{removingItems}', this.mostCommonWordInput.val())
            .replace('{supportedPlaceIds}', supportedItems.join(','))
            .replace('{totalWords}', this.totalInput.val());
    };

    return this;
};
