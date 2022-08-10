<?php
/** @var yii\web\View $this */

use yii\bootstrap4\Html;
use yii\widgets\Pjax;

?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3 control-sidebar-content">
        <h5>Customize AdminLTE</h5>
        <hr class="mb-2">
        <?php
            $settings = $this->theme->settings;

if ($settings) {
    foreach ($settings as $key => $value) {
        if (!is_object($value)) {
            echo '<div class="mb-4">'
            . '  <input name="dark-mode" class="mr-1" id="' . $key . '" onchange="theme.dark_mode(this)" type="checkbox" />'
            . '  <span>' . ucfirst(str_replace("-", " ", $key)) . '</span>'
            . "</div>";
        } else {
            $bg = stripos($key, "sidebar") === false ? "bg-white" : "bg-primary";
            echo '<h6>' . ucfirst(str_replace("-", " ", $key)) . '</h6>'
            . '<div class="d-flex">'
            . ' <select id="' . $key .'" class="custom-select mb-3 text-light border-0 ' . $bg . '" onchange="theme.' . str_replace("-", "_", $key) . '(this)">';
            if (stripos($key, "sidebar") !== false) {
                echo '  <option value="">None Selected</option>';
            }
            foreach ($value as $clave => $valor) {
                $class = str_replace([" navbar-dark", " navbar-light", "-dark"], "", $clave);
                $class = str_replace(["navbar", "sidebar", "bg-light"], "bg", $class);
                $text = str_ireplace(["-", "navbar", "sidebar"], [" ", ""], $clave);
                echo '<option value="' . $clave . '" class="' . $class . '">' . ucwords($text) . '</option>';
            }
            echo ' </select>'
            . '</div>';
        }
    }
}

?>
    </div>
</aside>
<!-- /.control-sidebar -->