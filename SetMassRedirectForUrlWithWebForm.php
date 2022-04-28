<?php
/**
 * Set Mass Redirect for Url with Web Form.
 * Can use when happened mismatch errors with URLS.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('default');
umask(0);

Mage::app()->setCurrentStore(1);

if ($_POST['action_type'] == 'delete' && isset($_POST['redirect-url']) && isset($_POST['ids'])):
    foreach ($_POST['ids'] as $id):
        $rewriteItem = false;
        $rewriteItem = Mage::getModel('core/url_rewrite')->loadByIdPath($id);
        if ($rewriteItem) {
            try {
                $rewriteItem->setTargetPath($_POST['redirect-url']);
                $rewriteItem->save();
                echo 'UPDATED -> ' . $rewriteItem->getData('id_path') . '<br>';
            } catch (Exception $e) {
                var_dump($e->getMessage());
                echo '<br>';
            }
            unset($rewriteItem);
        }
    endforeach;
endif;
?>
<h1>Search URl rewrite</h1>
<form action="remove-url-rewrite.php" method="get">
    <input name="target-value" value="" style="font-size: 20pt; width: 100%"/>
    <br>
    <input type="submit" style="font-size: 20pt;"/>
</form>

<?php if (isset($_GET['target-value'])):
    $collection = Mage::getModel('core/url_rewrite')->getCollection();
    $collection->addFieldToFilter('target_path', array(array('like' => '%' . $_GET['target-value'])));
    $collection->addFieldToFilter('is_system', array(array('like' => '0')));
    ?>
    <br>
    <br>
    <br>
    <hr>
    <h1 style="color: orangered">
        <?php if ($_GET['target-value']): echo $_GET['target-value']; endif; ?>
    </h1>
    <hr>
    <form action="remove-url-rewrite.php" method="post">
        <input type="hidden" name="action_type" value="delete">
        <input name="redirect-url" value="" style="font-size: 18pt; width: 100%"/>
        <hr>
        <table width="2000">
            <?php $i = 0;
            foreach ($collection as $c): $i++; ?>
                <tr <?php if ($i % 2 == 0): ?> bgcolor="grey" <?php endif; ?> >
                    <td><?php echo $i; ?></td>
                    <td><input type="checkbox" value="<?php echo $c->getData('id_path'); ?>" name="ids[]"></td>
                    <td><?php echo $c->getData('id_path'); ?></td>
                    <td><?php echo $c->getData('request_path'); ?></td>
                    <td><?php echo $c->getData('target_path'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" style="font-size: 20pt;"/>
    </form>
<?php endif; ?>

