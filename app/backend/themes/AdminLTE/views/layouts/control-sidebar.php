<?php
/** @var yii\web\View $this */

use common\models\Theme;
use yii\bootstrap4\ActiveForm;

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
                        . '  <input class="mr-1" onchange="theme.dark_mode(this)" type="checkbox" value="' . $value . '">'
                        . '  <span>' . ucfirst(str_replace("-", " ", $key)) . '</span>'
                        . "</div>";
                    } else {
                        echo '<h6>' . ucfirst(str_replace("-", " ", $key)) . '</h6>'
                        . '<div class="d-flex">'
                        . ' <select class="custom-select mb-3 text-light border-0 bg-white" onchange="theme.' . str_replace("-", "_", $key) . '(this)">';
                        if (stripos($key, "sidebar") !== false) {
                            echo '  <option>None Selected</option>';
                        }
                        foreach ($value as $clave => $valor) {
                            $class = str_replace([" navbar-dark", " navbar-light", "-dark"], "", $clave);
                            $class = str_replace(["navbar", "sidebar"], "bg", $class);
                            $text = str_ireplace(["-", "navbar", "sidebar"], [" ", ""], $clave);
                            $selected = $valor == 1 ? "selected": "";
                            
                            echo '<option value="' . $clave . '" class="' . $class . '" ' . $selected . '>' . ucwords($text) . '</option>';
                        }
                        echo ' </select>'
                        . '</div>';
                    }
                }
            }
            ActiveForm::begin(['action' => ["admin/theme/update", "id" => $this->theme->id]]);
            ActiveForm::end();
        ?>
    </div>
</aside>
<!-- /.control-sidebar -->