<?php
/** @var yii\web\View $this */

use common\models\Theme;
use yii\bootstrap4\ActiveForm;
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
    echo Html::beginForm(["admin/theme/update", "id" => $this->theme->id], 'post', ['id' => 'customize-adminlte']);
    foreach ($settings as $key => $value) {
        if (!is_object($value)) {
            if ($value == 1) {
                $checked = "checked";
            } else {
                $checked = "";
            }

            echo '<div class="mb-4">'
            . '  <input name="dark-mode" class="mr-1" id="' . $key . '" onchange="theme.dark_mode(this)" type="checkbox" value="' . (int) !$value . '" ' . $checked .'>'
            . '  <span>' . ucfirst(str_replace("-", " ", $key)) . '</span>'
            . "</div>";
        } else {
            echo '<h6>' . ucfirst(str_replace("-", " ", $key)) . '</h6>'
            . '<div class="d-flex">'
            . ' <select id="' . $key .'" class="custom-select mb-3 text-light border-0 bg-white" onchange="theme.' . str_replace("-", "_", $key) . '(this)">';
            if (stripos($key, "sidebar") !== false) {
                echo '  <option>None Selected</option>';
            }
            foreach ($value as $clave => $valor) {
                $class = str_replace([" navbar-dark", " navbar-light", "-dark"], "", $clave);
                $class = str_replace(["navbar", "sidebar"], "bg", $class);
                $text = str_ireplace(["-", "navbar", "sidebar"], [" ", ""], $clave);

                $selected = "";
                if (is_int($valor)) {
                    $selected = $valor == 1 ? "selected" : "";
                } else {
                    $selected = $valor->$clave == 1 ? "selected" : "";
                }
                echo '<option value="' . $clave . '" class="' . $class . '" ' . $selected . '>' . ucwords($text) . '</option>';
            }
            echo ' </select>'
            . '</div>';
        }
    }

    echo Html::endForm();
}

?>
    </div>
</aside>
<!-- /.control-sidebar -->