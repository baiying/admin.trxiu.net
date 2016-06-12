<div class="container-fluid">
    <h3>系统账号管理</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a> 
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/system/manager/">系统账号管理</a>
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
        <button class="btn green button-add" ><i class="icon-plus"></i> 添加管理员</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th width="25">
                        <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                    </th>
                    <th>账号</th>
                    <th>真实姓名</th>
                    <th>手机号码</th>
                    <th>创建时间</th>
                    <th>最后登录时间</th>
                    <th>状态</th>
                    <th class="span3">操作</th>
                </tr>
            </thead>
            <?php if(!empty($managers)):?>
            <tbody>
                <?php foreach($managers as $item):?>
                <tr>
                    <td>
                        <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['manager_id']?>" />
                    </td>
                    <td><?php echo $item['username']?></td>
                    <td><?php echo $item['real_name']?></td>
                    <td><?php echo $item['mobile']?></td>
                    <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
                    <td><?php echo date("Y-m-d H:i:s", $item['login_time'])?></td>
                    <td><?php echo $item['status'] == 1 ? '有效' : '冻结'?></td>
                    <td>
                        <button type="button" name="button-edit" class="btn green mini button-edit" data-manager-id="<?php echo $item['manager_id']?>" data-username="<?php echo $item['username']?>" data-mobile="<?php echo $item['mobile']?>" data-realname="<?php echo $item['real_name']?>"><i class="icon-pencil"></i> 编辑</button>
                        <?php if($item['status'] == 1):?>
                        <button type="button" name="button-lock" class="btn red mini button-status" data-status="2" data-manager-id="<?php echo $item['manager_id']?>"><i class="icon-lock"></i> 冻结</button>
                        <?php else:?>
                        <button type="button" name="button-unlock" class="btn blue mini button-status" data-status="1" data-manager-id="<?php echo $item['manager_id']?>"><i class="icon-unlock"></i> 解冻</button>
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
			<label class="control-label">账号：</label>
			<div class="controls">	
                <input type="text" class="m-wrap manager-username" placeholder="" value="" />
			</div>
		</div>	
		<div class="control-group">
			<label class="control-label">密码：</label>
			<div class="controls">	
				<input type="text" class="m-wrap manager-password" placeholder="" value="" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">手机号：</label>
			<div class="controls">	
				<input type="text" class="m-wrap manager-mobile" placeholder="" value="" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">真实姓名：</label>
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






