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
        </li>
    </ul>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 添加活动</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>活动ID</th>
                <th>活动名称</th>
                <th>活动说明</th>
                <th>参加的主播数量</th>
                <th>活动总票数</th>
                <th>创建时间</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>活动状态</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($ballot)):?>
                <tbody>
                <?php foreach($ballot as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['ballot_id']?>" />
                        </td>
                        <td><?php echo $item['ballot_id']?></td>
                        <td><?php echo $item['ballot_name']?></td>
                        <td><?php echo $item['description']?></td>
                        <td><?php echo $item['anchor_count']?></td>
                        <td><?php echo $item['votes']?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['begin_time'])?></td>
                        <td><?php echo date("Y-m-d H:i:s", $item['end_time'])?></td>
                        <td><?php echo $item['status'] == 1 ? '有效' : '冻结'?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit"
                                    data-ballot_id="<?php echo $item['ballot_id']?>"
                                    data-ballot_name="<?php echo $item['ballot_name']?>"
                                    data-description="<?php echo $item['description']?>"
                                    data-status="<?php echo $item['status']?>"
                                    data-begin_time="<?php echo date("Y-m-d H:i:s", $item['begin_time'])?>"
                                    data-end_time="<?php echo date("Y-m-d H:i:s", $item['end_time'])?>"
                            ><i class="icon-pencil"></i> 编辑</button>
                            <a href="/ballot/anchor/?ballot_id=<?php echo $item['ballot_id']?>&ballot_name=<?php echo $item['ballot_name']?>">
                                <button type="button" name="button-anchor" class="btn green mini button-anchor"
                                        data-ballot_id="<?php echo $item['ballot_id']?>"
                                ><i class="icon-pencil"></i> 管理活动主播</button>
                            </a>

                            <?php if($item['status'] == 1):?>
                                <button type="button" name="button-lock" class="btn red mini button-status" data-status="2" data-ballot_id="<?php echo $item['ballot_id']?>"><i class="icon-lock"></i> 冻结</button>
                            <?php else:?>
                                <button type="button" name="button-unlock" class="btn blue mini button-status" data-status="1" data-ballot_id="<?php echo $item['ballot_id']?>"><i class="icon-unlock"></i> 解冻</button>
                            <?php endif;?>
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
                <div class="input-append date form_datetime">
					<input size="10" id="begin_time" type="text" value="" class="m-wrap ballot-begin_time">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">结束时间：</label>
            <div class="controls">
                <div class="input-append date form_datetime">
					<input size="10" id="end_time" type="text" value="" class="m-wrap ballot-end_time">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
                
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">状态：</label>
            <div class="controls">
                <select name="sel" class="m-wrap ballot-status">
                    <option value="1">有效</option>
                    <option value="2">冻结</option>
                    <option value="3">已结束</option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="ballot_id" value="" />
    </div>
</div>






