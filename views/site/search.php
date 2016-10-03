<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => Yii::$app->request->csrfParam, 'content' => Yii::$app->request->getCsrfToken()]);
?>
<div class="site-search">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
                                        'id'          => 'search-form',
                                        'options'     => ['class' => 'form-horizontal'],
                                        'fieldConfig' => [
                                            'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                                        ],
                                    ]); ?>

    <?= $form->field($model,
                     'address')->textInput(['autofocus' => true])->hint('Please enter your address')->label('Address') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!empty($data['search_request']) || !empty($data['search'])) { ?>
        <div class="search-results">
            <h2>Search data</h2>
            <table class="table table-striped table-bordered">
                <tr>
                    <td width="20%">
                        Your search request
                    </td>
                    <td width="80%">
                        <?= (!empty($data['search_request'])) ? Html::encode($data['search_request']) : '' ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        Your search responce
                    </td>
                    <td width="80%">
                        <?= (!empty($data['search'])) ? Html::encode($data['search']) : '' ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>

    <?php if (!empty($data['search_history'])) { ?>
        <h2>Search history</h2>
        <div class="search-history">
            <table class="table table-striped table-bordered">
                <tr>
                    <td><?= Html::encode('№') ?></td>
                    <td><?= Html::encode('Search string') ?></td>
                    <td><?= Html::encode('Date') ?></td>
                    <td><?= Html::encode('Count') ?></td>
                </tr>
                <?php $i = 0;
                foreach ($data['search_history'] as $request) {
                    $i++; ?>
                    <tr>
                        <td width="10%">
                            <?= $i ?>
                        </td>
                        <td width="60%">
                            <?= Html::a( Html::encode($request['request']), ['site/detail', 'id' => $request['id']]) ?>
                        </td>
                        <td width="20%">
                            <?= Html::encode($request['c_time']) ?>
                        </td>
                        <td width="10%">
                            <?= Html::encode($request['count']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>
