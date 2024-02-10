<?php


/** @var yii\web\View $this */
/** @var app\models\CourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Course $cursosDoInstrutor */
/** @var common\models\Course $totalVendas */
/** @var common\models\Course $eachprice */
/** @var common\models\Course $quantidade */



$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">

    <table class="table">
        <thead>
        <tr>

            <th>Course Title</th>
            <th>Qtt</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cursosDoInstrutor as $curso): ?>

            <tr>
                <td><?= $curso->title ?></td>
                <td><?= $quantidade ?></td>
                <?php foreach ($eachprice as $price){
                    $totalprice =+ $price;
                 } ?>
                 <td><?= $totalprice ?> €</td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Total Sales: <?= $totalVendas ?> €</h2>
</div>
