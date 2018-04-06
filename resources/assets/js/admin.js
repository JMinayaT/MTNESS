$(document).ready(function () {
    
    $('[data-toggle="tooltip"]').tooltip()

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, .main-panel, .navbar, .footer').toggleClass('active');
        console.log("hola");
    });

    $('#btnSidebarMini i').on('click', function () {
        $('#sidebar, .main-panel, .navbar, .sidebar-wrapper, #btnSidebarMini, .nav-item-collapse, .footer').toggleClass('mini');
        $(".nav-item-collapse").children('.collapse').collapse('hide');   
          
    });


    $(".nav-item-collapse").hover(
        function() {
            if ($(this).hasClass('mini') || window.matchMedia('(max-width: 767px)').matches) {
                $(this).children('.collapse').collapse('show');
            }
        },
        function() {
            if ($(this).hasClass('mini') || window.matchMedia('(max-width: 767px)').matches) {
                $(this).children('.collapse').collapse('hide');
            }
        }
    );
});
