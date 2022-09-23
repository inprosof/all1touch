<style>
.logo-name {
    color: #d0e7e2;
    font-size: 80px;
    font-weight: 800;
    letter-spacing: 0px;
    margin-bottom: 0;
}
</style>
<div style="margin: 10px 0px;">
	<div class="ibox-content col-lg-4" style="margin: auto !important;">
		<div class="text-center loginscreen middle-box" style="padding-bottom: 30px !important;">
			<div>
				<div>

					<h4 class="logo-name"><?=$this->session->userdata("sys_name")?></h4>

				</div>
				<h3>CHANGE PASSWORD</h3>
				<form class="m-t" id="changePWform">
					<div class="form-group">
						<input type="password" class="form-control" name="old" placeholder="Current Password" required="">
					</div>
					<div class="form-group">
						<input type="password" id="new1" name="new1" class="form-control" placeholder="New Password" required="">
					</div>
					<div class="form-group">
						<input type="password" id="new2" name="new2" class="form-control" placeholder="Confirm Password" required="">
					</div>
					<button type="submit" id="sub_btn" class="btn btn-green block full-width m-b">CHANGE PASSWORD</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){
<!-- ------------------------------------------------------------------------------------------------------- -->
	//submit form
	$('#changePWform').ajax_submit({
			url : '/Settings/newpw',
			callback : function(id){
				console.log(id);
				if(id != ''){
					
				}
			}
		});
	
<!-- ------------------------------------------------------------------------------------------------------- -->
});

</script>