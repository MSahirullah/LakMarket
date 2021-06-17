$(document).ready(function () {
    $("#sidebarMenuCatagories").addClass('disabled');

    $("#sidebarMenuCatagories").addClass('highlighted-title');

    $('#sidebarMenuCatagories').hover(function () {
        $('#sidebarMenuCatagories').addClass('highlighted-title:h');
    });
});