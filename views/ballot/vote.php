<div class="container-fluid">
    <h3>主播投票详情</h3>
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
            <a href="/ballot/anchor/?ballot_id=<?php echo $ballot['ballot_id']?>&ballot_name=<?php echo $ballot['ballot_name']?>">主播管理</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a >主播投票详情</a>
        </li>
    </ul>
    <div class="row-fluid">
        <h4><span class="text-error"><?php echo $ballot['ballot_name']?></span> 中 <span class="text-success"><?php echo $anchor['anchor_name']?></span> 的获票明细</h4>
    </div>
    
    <div class="row-fluid">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
        	<ul class="nav nav-tabs">
        		<li <?php echo $type == "free" ? 'class="active"' : ""?>><a href="/ballot/anchor-vote/?type=free&ballot_id=<?php echo $ballot_id?>&anchor_id=<?php echo $anchor_id?>">免费票</a></li>
        		<li <?php echo $type == "canvass" ? 'class="active"' : ""?>><a href="/ballot/anchor-vote/?type=canvass&ballot_id=<?php echo $ballot_id?>&anchor_id=<?php echo $anchor_id?>">付费拉票</a></li>
        		<li <?php echo $type == "pay" ? 'class="active"' : ""?>><a href="/ballot/anchor-vote/?type=pay&ballot_id=<?php echo $ballot_id?>&anchor_id=<?php echo $anchor_id?>">拉票</a></li>
        	</ul>
        	<div class="tab-content">
        	<?php if(in_array($type, ['free', 'pay'])):?>
        		<table class="table table-condensed table-hover">
        		    <thead>
        		        <tr>
        		            <th>投票人</th>
        		            <th>投票时间</th>
        		            <th>红包金额</th>
        		        </tr>
        		    </thead>
        		    <tbody>
        		    <?php if(isset($votes) && !empty($votes)):?>
        		    <?php foreach($votes as $item):?>
        		        <tr>
        		            <td><?php echo $item['name']?></td>
        		            <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
        		            <td>￥<?php echo $item['earn']?>元</td>
        		        </tr>
        		    <?php endforeach;?>
        		    <?php endif;?>
        		    </tbody>
        		</table>
        	<?php else:?>
        	   <table class="table table-condensed table-hover">
        		    <thead>
        		        <tr>
        		            <th>拉票人</th>
        		            <th>拉票时间</th>
        		            <th>拉票金额</th>
        		        </tr>
        		    </thead>
        		    <tbody>
        		    <?php if(isset($canvass) && !empty($canvass)):?>
        		    <?php foreach($canvass as $item):?>
        		        <tr>
        		            <td><?php echo $item['name']?></td>
        		            <td><?php echo date("Y-m-d H:i:s", $item['create_time'])?></td>
        		            <td>￥<?php echo $item['charge']?>元</td>
        		        </tr>
        		    <?php endforeach;?>
    		        <?php endif;?>
        		    </tbody>
        		</table>
        	<?php endif;?>
    	    <?php if(isset($pageBar) && $pageBar != ""):?>
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
        	</div>
        </div>
        <!--END TABS-->
        
    </div>
</div>






