<?php

use yii\helpers\Html;

$this->title = 'Detail search information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-detail-search-information">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <h3><?= Html::encode('Your search request: ' . $search_request['request']) ?></h3>
    </div>


    <?php if (!empty($search_result)) { ?>
        <?php foreach ($search_result as $result) { ?>
            <div>
                <?php
                echo "<pre>";
                print_r($result);
                echo "<pre>";
                ?>
            </div>
        <?php } ?>
    <?php } ?>


</div>
