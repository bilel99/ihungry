// AJAX
let ajax = new Ajax;
ajax.createCategory();
ajax.deleteCategory();
ajax.deleteTag();
ajax.editCategory();

$(document).ready(function () {

    /**
     * redirect link to href url
     * sidebar
     */
    $('.list-group-item').click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        window.location.href = url;
    });

    /**
     * Toggle sidebar
     * Open / Close sidebar
     * Call method
     */
    toggleSidebar();



});

/**
 * Page = Admin, Dashboard
 * Open / Close sidebar
 * data-sidebar is boolean
 * 1 => Open
 * 0 => Close
 * Default is Close sidebar (data-sidebar = 0)
 */
let toggleSidebar = function () {
    $('#toggle-sidebar').on('click', function (e) {
        e.preventDefault();
        let dataSidebar = $('.custom-sidebar').attr('data-sidebar');
        // Sidebar is Open
        if (dataSidebar == '1') {
            $('#icon-toggle-sidebar').removeClass('fas fa-arrow-left');
            $('#icon-toggle-sidebar').addClass('fas fa-bars');
            $('.custom-sidebar').animate({left: '-100%'}, 600);
            $('.custom-sidebar').attr('data-sidebar', '0');
        } else {
            // Sidebar is Close
            $('#icon-toggle-sidebar').removeClass('fas fa-bars');
            $('#icon-toggle-sidebar').addClass('fas fa-arrow-left');
            $('.custom-sidebar').animate({left: '0'}, 600);
            $('.custom-sidebar').attr('data-sidebar', '1');
        }
    });
}