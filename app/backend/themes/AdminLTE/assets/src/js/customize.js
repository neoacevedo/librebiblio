/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license LICENSE.md
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

    function setDarkSideBarVariants(cssClass) {
        sessionStorage.dark_sidebar_variants = cssClass;
    }

    function getDarkSideBarVariants() {
        return sessionStorage.dark_sidebar_variants;
    }

    function setLightSideBarVariants(cssClass) {
        sessionStorage.light_sidebar_variants = cssClass;
    }

    function getLightSideBarVariants() {
        return sessionStorage.light_sidebar_variants;
    }

    theme = {
        dark_mode: function (object) {
            if (object.checked) {
                $('body').addClass('dark-mode');
                setDarkMode(1);
            } else {
                $('body').removeClass('dark-mode');
                setDarkMode(0);
            }
        },
        navbar_variants: function (object) {
            let navbars = document.getElementsByClassName('navbar');

            for (const el of navbars) {
                let classArr = Array.from(el.classList);

                // validar que exista el color
                if (classArr.length > 3) {
                    // Remuevo la variante
                    classArr.pop();
                    // Ahora remuevo el color
                    classArr.pop();
                }

                let classList = classArr.join(" ");
                el.classList = classList;

                let classes = object.value.split(" ");

                classes.forEach(item => {
                    el.classList.add(item);
                });

            }

            setNavBarVariants(object.value);
        },
        dark_sidebar_variants: function (object) {
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

            if (object.value == "" || object.value == undefined) {
                $main_header.addClass("sidebar-dark-primary");
            }

            if (object.value != "") {
                document.getElementById("light-sidebar-variants").value = "";
            }

            setLightSideBarVariants("");

            setDarkSideBarVariants(object.value);
        },
        light_sidebar_variants: function (object) {
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

            if (object.value != "") {
                document.getElementById("dark-sidebar-variants").value = "";
            }

            setDarkSideBarVariants("");

            setLightSideBarVariants(object.value);
        },
    };

    if (getDarkMode() == 1) {
        $('body').addClass('dark-mode');
        document.getElementById("dark-mode").checked = true;
    } else {
        $('body').removeClass('dark-mode');
        document.getElementById("dark-mode").checked = false;
    }

    if (getNavBarVariants() != undefined) {
        document.getElementById("navbar-variants").value = getNavBarVariants();
        theme.navbar_variants(document.getElementById("navbar-variants"));
    } else {
        document.getElementById("navbar-variants").value = "navbar-light navbar-white";
    }

    if (getDarkSideBarVariants() != undefined && getDarkSideBarVariants() != "") {
        document.getElementById("dark-sidebar-variants").value = getDarkSideBarVariants();
        console.log(document.getElementById("dark-sidebar-variants").value);

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

        $main_header.addClass(getDarkSideBarVariants());

        if (document.getElementById("dark-sidebar-variants").value == "") {
            $main_header.addClass("sidebar-dark-primary");
        }

        if (document.getElementById("dark-sidebar-variants").value != "") {
            document.getElementById("light-sidebar-variants").value = "";
            setLightSideBarVariants("");
        }

    }

    if (getLightSideBarVariants() != undefined && getLightSideBarVariants() != "") {
        document.getElementById("light-sidebar-variants").value = getLightSideBarVariants();
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

        $main_header.addClass(document.getElementById("light-sidebar-variants").value);

        if (document.getElementById("light-sidebar-variants").value != "") {
            document.getElementById("dark-sidebar-variants").value = "";
            setDarkSideBarVariants("");
        }

    }
}(jQuery));