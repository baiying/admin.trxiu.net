<div class="container-fluid">
    <h3>活动管理</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/ballot/index/">活动管理</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="#"><?php echo $_GET['ballot_name']?></a>
        </li>
    </ul>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 关联活动主播</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>主播昵称</th>
                <th>主播ID</th>
                <th>得票数</th>
                <th>主播头像地址</th>
                <th>宣传底图</th>
                <th>微信二维码名片地址</th>
                <th>所属平台</th>
                <th>直播间地址</th>
                <th>主播描述</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($ballotAnchor)):?>
                <tbody>
                <?php foreach($ballotAnchor as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['ballot_anchor_id']?>" />
                        </td>
                        <td><?php echo $item['Information']['anchor_name']?></td>
                        <td><?php echo $item['anchor_id']?></td>
                        <td><?php echo $item['votes']?></td>
                        <td><?php echo $item['Information']['thumb']?></td>
                        <td><?php echo $item['Information']['backimage']?></td>
                        <td><?php echo $item['Information']['qrcode']?></td>
                        <td><?php echo $item['Information']['platform']?></td>
                        <td><?php echo $item['Information']['broadcast']?></td>
                        <td><?php echo $item['Information']['description']?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit"
                                    data-ballot_anchor_id="<?php echo $item['ballot_anchor_id']?>"
                            ><i class="icon-pencil"></i> 编辑</button>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            <?php endif;?>
        </table>

        <!--分页-->
        <?php if(!empty($pageBar)):?>
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
            <label class="control-label">投票活动名称：</label>
            <div class="controls">
                <input type="text" class="m-wrap ballot-ballot_name" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">投票活动说明：</label>
            <div class="controls">
                <input type="text" class="m-wrap ballot-description" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">开始时间：</label>
            <div class="controls">
                <input type="text" class="m-wrap ballot-begin_time" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">结束时间：</label>
            <div class="controls">
                <input type="text" class="m-wrap ballot-end_time" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">状态：</label>
            <div class="controls">
                <input type="text" class="m-wrap ballot-status" placeholder="" value="" />
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="ballot_id" value="" />
    </div>
</div>






