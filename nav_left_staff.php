<div id="accordion" class="panel-group" style="margin-top:20px;">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title ">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> My Menu </a>
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="glyphicon glyphicon-chevron-down pull-right"></a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="list-group">
					<a style="color:blue;" class="list-group-item" href="useraccountprofile.php?abuaditid=<?php echo $_SESSION['currentUser'];?>" >
						<span class="glyphicon glyphicon-home"></span> View Profile <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;" class="list-group-item" href="adminHome.php" >
						<span class="glyphicon glyphicon-phone"></span> Admin Home <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					
					<a style="color:red;" class="list-group-item" href="updateITFRecord.php" >
						<span class="glyphicon glyphicon-plus"></span> Update ITF Information <span style="color:red"></span><span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>