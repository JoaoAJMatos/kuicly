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

            <th>Título do Curso</th>
            <th>Qtd</th>
            <th>Montante</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cursosDoInstrutor as $curso): ?>

            <tr>
                <td><?= $curso->title ?></td>
                <td><?= $quantidade ?></td>
                <?php foreach ($eachprice as $price): ?>
                    <td><?= $price ?></td>
                <?php endforeach; ?>

            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Total de Vendas: <?= $totalVendas ?></h2>
</div>
