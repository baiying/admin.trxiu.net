<link href="/media/css/error.css" rel="stylesheet" type="text/css"/>
<div class="container-fluid">
    <h3 class="page-title">错误</h3>
    <div class="row-fluid">
    	<div class="span12">
    		<?php if(!empty($errors)):?>
    		<ul>
    		    <?php foreach($errors as $err):?>
    		    <li><?php echo $err;?></li>
    		    <?php endforeach;?>
    		</ul>
    		<?php endif;?>
    	</div>
    </div>
</div>
