<?php
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
$this->registerJs($this->render('js/create.js'));
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
    ]) ?>

</div>
