$(function () {
    let config = new Configuration();

    $('#changeSubmit').on('click', function () {
        $(location).attr('href', config.getUrlPart());
    });
});
