<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
use app\common\util\page;
?>
<?php echo IndexTitleWidget::widget(); ?>
<div class="m-content">
    <div class="qgj-title">
        <div class="qgj-title_main">商户服务</div>
    </div>
    <form action="<?php echo Url::to(['list']); ?>" method="get" id="searchForm">
        <div class="form-horizontal qgj-form-search">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">商户类型</label>
                    <div class="control-input">
                        <select class="form-control "  id="type" name="type">
                            <option value="">全部类型</option>
                            <?php foreach ($GLOBALS['MERCHANT_TYPE'] as $k=>$v){?>
                            <option value="<?php echo $k ?>" <?php if(isset($_GET['type'])){if($_GET['type'] == $k){echo 'selected';}} ?>> <?php echo $v ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">商圈/街区</label>
                    <div class="control-input">
                        <select class="form-control" name="block">
                            <option value="" <?php echo empty($sqlist) ? 'selected' : ''; ?>>全部类型</option>
                            <?php if (!empty($sqlist)) { ?>
                                <?php foreach ($sqlist as $key => $val) { ?>
                                    <option value="<?php echo $val['id']; ?>" <?php if(isset($_GET['block'])){if($_GET['block'] == $val['id']){echo 'selected';}} ?>> <?php echo $val['name'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="control-input">
                        <div class="input-group w150">
                            <input type="text" class="form-control bg-gray-lighter" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];} ?>" name="keyword" placeholder="搜索">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="icon-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
<!--            <input type="hidden" name="page" value="--><?php //echo $page; ?><!--">-->
<!--            <input type="hidden" name="status" value="--><?php //echo $status; ?><!--">-->
            <div class="qgj-nav mt10">
                <div class="pull-right"><a href="<?php echo Url::to(['add']); ?>" class="btn btn-default">添加商户</a></div>
                <div class="btn-group">
                    <a href="<?php echo Url::to(['list']) ?>" class="btn btn-default <?php echo isset($_GET['status']) ? '' : 'active'; ?>" onclick="statusSearch('')">全部</a>
                    <a href="<?php echo Url::to(['list','status'=>BE_EXAMINE]) ?>" class="btn btn-default <?php echo isset($_GET['status']) && $_GET['status'] == BE_EXAMINE ? 'active' : ''; ?>" >待审核</a>
                    <a href="<?php echo Url::to(['list','status'=>IS_YES]) ?>" class="btn btn-default <?php echo isset($_GET['status']) && $_GET['status'] == IS_YES ? 'active' : ''; ?>" >已上架</a>
                    <a href="<?php echo Url::to(['list','status'=>IS_NO]) ?>" class="btn btn-default <?php echo isset($_GET['status']) && $_GET['status'] == IS_NO ? 'active' : ''; ?>" >已下架</a>
                    <a href="<?php echo Url::to(['list','status'=>BE_REJECT]) ?>" class="btn btn-default <?php echo isset($_GET['status']) && $_GET['status'] == BE_REJECT ? 'active' : ''; ?>" >驳回</a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-special">
            <thead>
            <tr>
                <th>商品服务</th>
                <th>商户类型</th>
                <th>状态</th>
                <th>运营服务商</th>
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
                                    <?php $img = json_decode($val['goods_img']) ?>
                                    <img src="<?php echo UPLOAD_IMG_SERVER_GOODS_SOURCE . $img[0]; ?>">
                                </div>
                                <div class="media-body">
                                    <h5 class="mb5"><?php echo $val['merchant']['alias']; ?></h5>

                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="media-name"><?php if($val['type']==MERCHANT_TYPE_PP){echo $GLOBALS['MERCHANT_TYPE'][MERCHANT_TYPE_PP];}
                            elseif ($val['type']==MERCHANT_TYPE_SQ){echo $GLOBALS['MERCHANT_TYPE'][MERCHANT_TYPE_SQ];}
                            ?></div>
                            <div class="address"><?php echo $val['block_name']; ?></div>
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
                        <td><?php echo $val['serviceProviders']['name']  ?></td>
                        <td><?php echo $val['create_time']  ?></td>
                        <td>
                            <?php if($val['status']!= 4){ ?>
                                <a href="<?php echo Url::to(['view', 'id' => $val['id']]); ?>" class="text-primary mb5">详情</a>
                            <?php } ?>
                            <a href="<?php echo Url::to(['edit', 'id' => $val['id']]); ?>" class="text-primary mb5">编辑</a>

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


<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/common/page.js'); ?>"></script>