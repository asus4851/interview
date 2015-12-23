<?php
/**
 * @var yii\web\View $this
 * @var array $list
 */
use yii\helpers\Html;

/**
 * @param yii\web\View $view
 * @param $list
 * @param $pid
 * @param $deep
 */
function employeeTreeOutput( $view, $list, $pid, $deep )
{
    $deep++;
    foreach( $list[$pid] as $item )
    {
        echo $view->render('tree_item', compact('item', 'deep'));
        if( isset($list[$item->id]) )
            employeeTreeOutput($view, $list, $item->id, $deep);
    }
}

?>
<p>
    <?= Html::a('Back to gridview', ['index'], ['class' => 'btn btn-success']) ?>
</p>
<ul class="list-group">
    <?php employeeTreeOutput($this, $list, 0, 0); ?>
</ul>
