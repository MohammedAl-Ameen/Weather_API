<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->registerJsFile("/js/main.js");
$this->registerCSSFile("/css/custom.css");
$this->title = 'weather';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-weather">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="group-container">
        <div class="input-group w-25">
            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="city_name" <?php echo $role != "admin" ? "readonly value='Amman'" : "" ?>>
        </div>
        <button type="button" class="btn btn-info" id="info">Weather info</button>
    </div>


    <div id="weather-container" class="weather-container">
        <div id="weather-wrap" class="weather-wrap">
        </div>

    </div>
</div>