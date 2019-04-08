<?php view::layout('layout')?>	

<body>
<br>
<br>	
<div class="container"> 
    <div class="row">
        <div class="col-sm-12 col-md-9">
	        <div class="card">	         	
	        <div class="card-body table-responsive">          
                <table class="table"><thead class="thead-light">
			    <tr><th class="file-name">名称</th><th class="file-size">大小</th><th class="file-date-created">修改时间</th></tr>
			    <?php if($path != '/'):?>
			    	<tr>
				    	<td class="file-name">
					    	<a class="icon icon-up" href="<?php echo get_absolute_path($root.$path.'../');?>">返回上级</a>
					    </td>
					    <td class="file-size"></td>
					    <td class="file-date-modified"></td>
				    </tr>
			    <?php endif;?>
			    <?php foreach((array)$items as $item):?>
				    <?php if(!empty($item['folder'])):?>
					    <tr>
				 		    <td class="file-name"><a class="icon icon-dir" href="<?php echo get_absolute_path($root.$path.rawurlencode($item['name']));?>"><?php echo $item['name'];?>/</a></td>
						    <td class="file-size"><?php echo onedrive::human_filesize($item['size']);?></td>
						    <td class="file-date-modified"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></td>
					    </tr>
				    <?php else:?>
				  	    <tr>
						    <td class="file-name"><a class="icon icon-file" href="<?php echo get_absolute_path($root.$path).rawurlencode($item['name']);?>"><?php echo $item['name'];?></a></td>
						    <td class="file-size"><?php echo onedrive::human_filesize($item['size']);?></td>
						    <td class="file-date-modified"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></td>
					    </tr>
				    <?php endif;?>
			    <?php endforeach;?>
		        </table>
            </div>
			</div> <p><?php e($readme);?></p>
	    </div> 
    </div>
</div>
<br>
</body>
</html>