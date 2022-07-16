/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

(function ($) {
    theme = {
        dark_mode: function (object) {
            if (object.checked) {
                $('body').addClass('dark-mode')
            } else {
                $('body').removeClass('dark-mode')
            }
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
        }
    };
}(jQuery));