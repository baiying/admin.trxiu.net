<div class="container-fluid">
    <h3>主播管理</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/anchor/index/">主播管理</a>
        </li>
    </ul>
    <!-- 筛选条件开始-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">按条件查找</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row-fluid">
                <div class="span3">
                    <div class="control-group">
                        <input type="text" placeholder="输入账号" class="m-wrap span8 args" data-args-key="apply_code" value="" />
                        <span>
                            <button class="btn green button-search" ><i class="icon-search"></i> 查找</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 添加主播</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>主播ID</th>
                <th>主播昵称</th>
                <th>主播头像</th>
                <th>宣传底图</th>
                <th>微信二维码名片</th>
                <th>所属平台</th>
                <th>直播间地址</th>
                <th>主播描述</th>
                <th>注册时间</th>
                <th>信息更新时间</th>
                <th>最后登录时间</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($anchor)):?>
                <tbody>
                <?php foreach($anchor as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['anchor_id']?>" />
                        </td>
                        <td><?php echo $item['anchor_id']?></td>
                        <td><?php echo $item['anchor_name']?></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['thumb']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['backimage']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['qrcode']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['platform']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['broadcast']?></p></td>
                        <td><?php echo $item['description']?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['modify_time'])?></td>
                        <td><?php echo $item['last_time']?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit" data-anchor-id="<?php echo $item['anchor_id']?>" data-anchor-name="<?php echo $item['anchor_name']?>" ><i class="icon-pencil"></i> 编辑</button>
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
<!-- 管理员信息编辑弹出层 -->
<div id="editModal" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">主播昵称：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-anchor_name" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">所属平台：</label>
            <div class="controls">
                <input type="text" class="m-wrap manager-password" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">	直播间地址：</label>
            <div class="controls">
                <input type="text" class="m-wrap manager-mobile" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主播描述：</label>
            <div class="controls">
                <input type="text" class="m-wrap manager-realname" placeholder="" value="" />
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="managerid" value="" />
    </div>
</div>






