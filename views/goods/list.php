<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
use app\common\util\page;
?>
<?php echo IndexTitleWidget::widget(); ?>
<div class="m-content">
    <div class="qgj-title">
        <div class="qgj-title_main">服务商品</div>
    </div>
    <form action="<?php echo Url::to(['list']); ?>" method="get" id="searchForm">
        <div class="form-horizontal qgj-form-search">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">服务分类</label>
                    <div class="control-input">
                        <select class="form-control" name="category_p_id">
                            <option value="" <?php echo empty($category_p_id) ? 'selected' : ''; ?>>全部分类</option>
                            <?php if (!empty($category)) { ?>
                                <?php foreach ($category as $key => $val) { ?>
                                    <option value="<?php echo $val -> id; ?>" <?php echo $val -> id == $category_p_id ? 'selected' : ''; ?>><?php echo $val -> name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">二级分类</label>
                    <div class="control-input">
                        <select class="form-control" name="category_id">
                            <option value="">全部类别</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="control-input">
                        <div class="input-group w150">
                            <input type="text" class="form-control bg-gray-lighter" value="<?php echo $keyword; ?>" name="keyword" placeholder="搜索">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="icon-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <input type="hidden" name="status" value="<?php echo $status; ?>">
            <div class="qgj-nav mt10">
                <div class="pull-right"><a href="<?php echo Url::to(['add']); ?>" class="btn btn-default">添加服务</a></div>
                <div class="btn-group">
                    <a href="javascript:;" class="btn btn-default <?php echo empty($status) ? 'active' : ''; ?>" onclick="statusSearch('')">全部</a>
                    <a href="javascript:;" class="btn btn-default <?php echo $status == BE_EXAMINE ? 'active' : ''; ?>" onclick="statusSearch('3')">待审核</a>
                    <a href="javascript:;" class="btn btn-default <?php echo $status == IS_YES ? 'active' : ''; ?>" onclick="statusSearch('1')">已上架</a>
                    <a href="javascript:;" class="btn btn-default <?php echo $status == IS_NO ? 'active' : ''; ?>" onclick="statusSearch('2')">已下架</a>
                    <a href="javascript:;" class="btn btn-default <?php echo $status == BE_REJECT ? 'active' : ''; ?>" onclick="statusSearch('4')">驳回</a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-special">
            <thead>
            <tr>
                <th>商品服务</th>
                <th>状态</th>
                <th>服务商</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($list)) { ?>
                <?php foreach ($list as $key => $val) { ?>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?php echo UPLOAD_IMG_SERVER_GOODS_SOURCE . $val['goods_img'][0]; ?>">
                                </div>
                                <div class="media-body">
                                    <h5 class="mb5"><?php echo $val['name']; ?></h5>
                                    <div class="text-gray-light"><?php echo $val['p_category_name'] ?>-<?php echo $val['category_name']; ?></div>
                                    <div class="text-gray-light"><?php  if($val['min_price']==$val['max_price']){echo $val['min_price'];}else{echo  $val['min_price'].'-'.$val['max_price'];} ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="media-onsale">
                            <?php switch ($val['status']){
                                case IS_YES:
                                    echo '已上架';
                                    break;
                                case IS_NO:
                                    echo '已下架';
                                    break;
                                case BE_EXAMINE:
                                    echo '待审核';
                                    break;
                                case BE_REJECT:
                                    echo '驳回';
                                    break;
                            }?>
                        </td>
                        <td><?php echo $val['service_name']; ?></td>
                        <td><?php echo $val['create_time']; ?></td>
                        <td>
                            <?php if($val['status']!= 4){ ?>
                            <a href="<?php echo Url::to(['view', 'id' => $val['id'],'status'=>1]); ?>" class="text-primary mb5">详情</a>
                            <?php } ?>
                            <a href="<?php echo Url::to(['edit', 'id' => $val['id']]); ?>" class="text-primary mb5">编辑</a>
                        <?php if ($val['status'] == GOODS_STATUS_CANCEL){?>
                            <a href="<?php echo Url::to(['set-status', 'goods_id' => $val['id']]); ?>" class="text-primary mb5">上架</a>
                        <?php }?>
                        <?php if ($val['status'] == GOODS_STATUS_NORMAL){?>
                            <a href="<?php echo Url::to(['set-status', 'goods_id' => $val['id']]); ?>" class="text-primary mb5">下架</a>
                        <?php }?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <?php if (empty($list)) { ?>
            <div class="text-center h5 ptb15 bg-white">暂时无数据</div>
        <?php } ?>

        <?php if ($count > PAGE_PARAMS) {
            $page = new page($count, PAGE_PARAMS, $page, Url::to(['list']) . '?page={page}', 2, $_GET);
            echo $page -> myde_write();
        } ?>
    </div>

</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/list.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/common/page.js'); ?>"></script>
<script>
    var category_id = '<?php echo $category_id; ?>';

</script>