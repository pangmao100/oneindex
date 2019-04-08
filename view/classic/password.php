<?php view::layout('layout')?>

<?php view::begin('content');?>
	
<div class="container"> 
    <div class="row">
        <div class="col-sm-12 col-md-9">
        <br>
            <div class="card">
                <div class="card-body">
	            <h2>这是一个受保护的文件夹，您需要提供访问密码才能查看。</h2>	   
	            <form action="" method="post">	  
	                <div class="form-group">
                    <label for="pwd"></label>
                    <input name="password" class="form-control" id="pwd" placeholder="输入密码" type="password"/>
                    </div>
	                <br>
	                <button type="submit" class="btn btn-outline-primary">查看</button>
		        	<a href="/one" class="btn btn-outline-primary">返回首页</a>
	            </form>
	        </div>
        </div>
    </div>	
</div>
</div>	