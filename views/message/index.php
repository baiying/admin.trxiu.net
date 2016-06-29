<div class="container-fluid">
    <h3>消息管理</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/message/index/">会员管理</a>
        </li>
    </ul>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 新建群发</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>消息编号</th>
                <th>消息内容</th>
                <th>发送时间</th>
                <th>发送人</th>
                <th>发送人ID</th>
                <th>接收人</th>
                <th>接收人ID</th>
            </tr>
            </thead>
            <?php if(!empty($messageList)):?>
                <tbody>
                <?php foreach($messageList as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['message_id'];?>" />
                        </td>
                        <td><?php echo $item['code'];?></td>
                        <td><?php echo $item['content'];?></td>
                        <td><?php echo $item['create_time'];?></td>
                        <td><?php echo $item['send_fans']['wx_name'];?></td>
                        <td><?php echo $item['send_fans']['fans_id'];?></td>
                        <td>群发</td>
                        <td>ALL</td>
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
<div id="addMessage" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">操作人：</label>
            <div class="controls">
                <input type="text" class="m-wrap message-send_fans" placeholder="" value="系统消息" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">消息内容：</label>
            <div class="controls">
                <textarea class="m-wrap message-content" placeholder="">
                </textarea>
            </div>
        </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="managerid" value="" />
    </div>
</div>






