<div class="container-fluid">
    <h3>主播管理</h3>
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
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>主播ID</th>
                <th>openid</th>
                <th>微信账号</th>
                <th>性别</th>
                <th>微信头像</th>
                <th>access_token</th>
                <th>refresh_token</th>
                <th>access_token</th>
                <th>国家</th>
                <th>省份</th>
                <th>城市</th>
                <th>unionid</th>
                <th>注册时间</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($fansList)):?>
                <tbody>
                <?php foreach($fansList as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['fans_id']?>" />
                        </td>
                        <td><?php echo $item['anchor_id']?></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['wx_openid']?></p></td>
                        <td><?php echo $item['wx_name']?></td>
                        <td><?php echo $item['wx_sex']?></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['wx_thumb']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['wx_access_token']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['wx_refresh_token']?></p></td>
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['wx_access_token_expire']?></p></td>
                        <td><?php echo $item['wx_country']?></td>
                        <td><?php echo $item['wx_province']?></td>
                        <td><?php echo $item['wx_city']?></td>
                        <td><?php echo $item['wx_unionid']?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit" data-anchor-id="<?php echo $item['fans_id']?>" data-anchor-name="<?php echo $item['wx_name']?>" ><p style="width: 6em;padding:0px;"><i class="icon-pencil"></i> 晋升主播</p></button>
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






