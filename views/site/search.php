<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
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

    <?php if(!empty($data)) { ?>
    <div class="search-results">
        <table class="table table-striped table-bordered">
            <tr>
                <td width="20%">
                    Your search request
                </td>
                <td width="80%">
                    <?= (!empty($data['search_request'])) ? $data['search_request'] : '' ?>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    Your search responce
                </td>
                <td width="80%">
                    <?= (!empty($data['search'])) ? $data['search'] : '' ?>
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>
</div>
