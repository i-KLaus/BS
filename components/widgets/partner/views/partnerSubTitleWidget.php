<?php
use yii\helpers\Url;
?>
<div class="m-title">
    <ul>
        <li <?php if(in_array($action, ['list', 'info', 'edit']) && $controller == 'partner'){?>class="active"<?php }?>><a href="<?php echo Url::to(['/partner/partner/list'])?>">服务商列表</a></li>
        <li <?php if($action == 'list' && $controller == 'subaccount'){?>class="active"<?php }?>><a href="<?php echo Url::to(['/partner/subaccount/list'])?>">子服务商</a></li>
        <li <?php if(in_array($action, ['record-list', 'record-info'])){?>class="active"<?php }?>><a href="<?php echo Url::to(['/partner/balance/record-list'])?>">充值记录</a></li>
    </ul>
</div>