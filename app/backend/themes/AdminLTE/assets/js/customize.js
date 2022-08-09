/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

(function ($) {
    function setDarkMode(enabled) {
        sessionStorage.darkMode = enabled;
    }

    function getDarkMode() {
        return sessionStorage.darkMode;
    }

    function setNavBarVariants(cssClass) {
        sessionStorage.navbar_variants = cssClass;
    }

    function getNavBarVariants() {
        return sessionStorage.navbar_variants;
    }

    if (getDarkMode() == 1) {
        $('body').addClass('dark-mode');
    } else {
        $('body').removeClass('dark-mode');
    }

    if (getNavBarVariants() != undefined) {
        var $main_header = $(".main-header");
        $main_header.removeClass();
        $main_header.addClass(getNavBarVariants());
    }

    theme = {
        dark_mode: function (object) {
            if (object.checked) {
                $('body').addClass('dark-mode');
                setDarkMode(1);
                object.value = 1;
            } else {
                $('body').removeClass('dark-mode');
                setDarkMode(0);
                object.value = 0;
            }

            document.getElementById("customize-adminlte").submit();
        },
        navbar_variants: function (object) {
            var $main_header = $(".main-header");

            // remover los temas claro y oscuro del navbar
            $main_header.removeClass('navbar-dark').removeClass('navbar-light');

            // Get class list string
            var classList = $main_header.attr("class");


            // Creating class array by splitting class list string
            var classArr = classList.split(" ");

            // validar que exista el color
            if (classArr.length > 3) {
                // remover el último elemento (el color)
                classArr.pop();
            }

            $main_header.removeClass();

            classList = "";

            classList = classArr.join(" ");

            $main_header.addClass(classList);

            $main_header.addClass(object.value);

            setNavBarVariants(classList + " " + object.value);

        },
        dark_sidebar_options: function (object) {
            var $main_header = $(".main-sidebar");

            // Get class list string
            var classList = $main_header.attr("class");

            // Creating class array by splitting class list string
            var classArr = classList.split(" ");

            // validar que exista el color
            if (classArr.length == 3) {
                // remover el último elemento (el color)
                classArr.pop();
            }

            $main_header.removeClass();

            classList = "";

            classList = classArr.join(" ");

            $main_header.addClass(classList);

            $main_header.addClass(object.value);

            // setNavBarDark(classList + " " + object.value);
        },
        light_sidebar_options: function (object) {
            var $main_header = $(".main-sidebar");

            // Get class list string
            var classList = $main_header.attr("class");

            // Creating class array by splitting class list string
            var classArr = classList.split(" ");

            // validar que exista el color
            if (classArr.length == 3) {
                // remover el último elemento (el color)
                classArr.pop();
            }

            $main_header.removeClass();

            classList = "";

            classList = classArr.join(" ");

            $main_header.addClass(classList);

            $main_header.addClass(object.value);
        },
    };
}(jQuery));