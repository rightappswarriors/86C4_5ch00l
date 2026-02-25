<div class="row">
	<div class="col-md-12">
		<blockquote class="blockquote">
			<div class="row">
			<div class="col-md-6">
			<address class="text-primary">
			<p class="font-weight-bold">User Login Info</p>
			<p><?=$row->user_firstname." ".$row->user_lastname?></p>
			<p><?=$row->user_mobileno?></p>
			<p>Last Login: <code><?=date("m/d/Y",strtotime($row->user_lastlogin))?></p></code>
			</address>
			</div>
			<div class="col-md-6">
				<p>Enrollment Status: <code><?=$row->enrollstatus?></code></p>
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Change Status </button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
						<code><a class="dropdown-item" href="#">Confirmed</a>
						<a class="dropdown-item" href="#">For Payment</a>
						<a class="dropdown-item" href="#">Admin Interview</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Suspended</a>
						<a class="dropdown-item" href="#">Terminated</a>
						<a class="dropdown-item" href="#">Withdrawn</a></code>
					</div>
				</div>
			</div>
			</div>
			<div class="col-md-12">
			
			</div>
			<a href="<?=site_url("students/updateinfo/".$row->id)?>" class="btn btn-warning btn-block">Update Info</a>
		</blockquote>	
	</div>
</div>