/**
 * call class Ajax
 */
let ajax = new Ajax();
ajax.getRefreshProfil();
ajax.updateProfil();
ajax.updatePassword();
ajax.updateSecretPass();
ajax.accountDisable();
ajax.accountEnable();
ajax.deleteAccount();

$(document).ready(function () {
    $(".dropdown").hover(
        function () {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
            $(this).toggleClass('open');
        },
        function () {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
            $(this).toggleClass('open');
        }
    );


    // Show form edit password / edit profil / edit secretpass /
    $('#profil-edit-secretpass').on('click', function (e) {
        e.preventDefault();
        // Show form edit secretpass
        $('.form-edit-profil').slideUp();
        $('.form-edit-password').slideUp();
        $('.form-edit-secretPass').slideDown();
        // Change menu
    });

    $('#profil-edit-password').on('click', function (e) {
        e.preventDefault();
        // show form edit password
        $('.form-edit-profil').slideUp();
        $('.form-edit-secretPass').slideUp();
        $('.form-edit-password').slideDown();
        // Change menu
        $('#li-edit-password').slideUp();
        $('#li-edit-profil').slideDown();
    });

    $('#profil-edit-account').on('click', function (e) {
        e.preventDefault();
        // show form edit profil
        $('.form-edit-password').slideUp();
        $('.form-edit-secretPass').slideUp();
        $('.form-edit-profil').slideDown();
        // Change menu
        $('#li-edit-profil').slideUp();
        $('#li-edit-password').slideDown();
    });


});