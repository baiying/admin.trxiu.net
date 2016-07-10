<div class="container-fluid">
    <h3>会员管理</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/fans/index/">会员管理</a>
        </li>
    </ul>
    <!-- 筛选条件开始-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">按昵称查找</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row-fluid">
                <div class="span3">
                    <div class="control-group">
                        <input type="text" placeholder="输入用户昵称" class="m-wrap span8 args" id="search_name" value="" />
                        <span>
                            <button class="btn green button-search" ><i class="icon-search"></i> 查找</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th width="90">头像</th>
                <th>昵称及openid</th>
                <th width="50">性别</th>
                <th width="50">主播</th>
                <th>省份</th>
                <th>城市</th>
                <th width="90">注册时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <?php if(!empty($fansList)):?>
                <tbody>
                <tr>
                    <td colspan="10">用户总数：<?=$fansTotal?>，总页数<?=$fansPageCount?></td>
                </tr>
                <?php foreach($fansList as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['fans_id'];?>" />
                        </td>
                        <td>
                            <?php if($item['wx_thumb'] != ""):?>
                            <img width="80" src="<?php echo $item['wx_thumb']?>" />
                            <?php else:?>
                            <?php echo "无"?>
                            <?php endif;?>
                        </td>
                        <td>
                            <h4><?php echo $item['wx_name'];?></h4>
                            <p>
                            <span class="label label-gray">openid:</span>
                            <?php echo $item['wx_openid']?>
                            </p>
                        </td>
                        <td><?php echo $item['wx_sex'] == 1 ? '男' : '女';?></td>
                        <td><?php echo $item['anchor_id'] > 0 ? '是' : '否';?></td>
                        <td><?php echo $item['wx_province'];?></td>
                        <td><?php echo $item['wx_city'];?></td>
                        <td><?php echo date("Y-m-d", $item['create_time'])?></td>
                        <td>
                        <?php if($item['anchor_id'] == 0):?>
                            <button type="button" name="button-addAnchor" class="btn green mini addAnchor" data-anchor_id="<?php echo $item['anchor_id'];?>" data-fans_id="<?php echo $item['fans_id'];?>" data-wx_name="<?php echo $item['wx_name'];?>" ><p style="width: 6em;padding:0px;"><i class="icon-pencil"></i> 晋升主播</p></button>
                        <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            <?php endif;?>
        </table>

        <!--分页-->
        <?php if($pageBar != ""):?>
            <div class="row-fluid">
                <div class="span6">&nbsp;</div>
                <div class="span6">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $pageBar;?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <!-- 分页结束-->
    </div>
</div>
<!-- 主播信息编辑弹出层 -->
<div id="addAnchor" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">粉丝ID：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-fans_id" placeholder="" value="" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">粉丝昵称：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-wx_name" placeholder="" value="" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">宣传底图：</label>
            <div class="controls" id="container">
                <img src="" width="200" class="bgimg" style="display:none;" />
                <input type="hidden" class="anchor-backimage" value="" />
                <p>
                    <button type="button" id="pickfiles" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">微信二维码名片地址：</label>
            <div class="controls" id="container_qrcode">
                <img src="" width="200" class="qrcode" style="display:none;" />
                <input type="hidden" class="anchor-qrcode" value="" />
                <p>
                    <button type="button" id="btn_qrcode" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">所属平台：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-platform" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">直播间地址：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-broadcast" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主播描述：</label>
            <div class="controls">
                <textarea class="m-wrap anchor-description" rows="3"></textarea>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="managerid" value="" />
    </div>
</div>






