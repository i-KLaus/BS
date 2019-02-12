<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11
 * Time: 14:23
 */
?>
<?php if(!empty($sku)){ ?>
<label class="control-label">商品价格</label>
<div class="control-input">
    <table class="normal-table">
        <tbody class="tb">
        <tr>
            <td>套餐</td>
            <td>价格(元)</td>
        </tr>
            <?php foreach ($sku as $k=>$v) {?>
        <tr class="goodsData">
            <td><?php echo $v['name'] ?></td>
            <td><input type="text" maxlength="7"  value=""  class="table-input w100 pr" name="pri"></td>
            <input type="hidden" value="<?php echo $v['id'] ?>" class="sku_attr">
        </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php }?>
