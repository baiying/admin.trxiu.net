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
                        <td><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['description']?></p></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['modify_time'])?></td>
                        <td><?php echo $item['last_time']?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit"
                                    data-anchor_id="<?php echo $item['anchor_id']?>"
                                    data-anchor_name="<?php echo $item['anchor_name']?>"
                                    data-thumb="<?php echo $item['thumb']?>"
                                    data-backimage="<?php echo $item['backimage']?>"
                                    data-qrcode="<?php echo $item['qrcode']?>"
                                    data-platform="<?php echo $item['platform']?>"
                                    data-broadcast="<?php echo $item['broadcast']?>"
                                    data-description="<?php echo $item['description']?>"
                            ><i class="icon-pencil"></i> 编辑</button>
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
                <input type="text" class="m-wrap anchor-name" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主播头像：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-thumb" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">宣传底图：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-backimage" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">微信二维码名片地址：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-qrcode" placeholder="" value="" />
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
                <input type="text" class="m-wrap anchor-description" placeholder="" value="" />
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="anchor_id" value="" />
    </div>
</div>






