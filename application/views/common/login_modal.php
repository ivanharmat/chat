<!-- Update Fridge Modal -->
<div class="modal hide" id="login_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open('', 'id="login_form" class="form-horizontal"');?>
			<div class="modal-header">
				<h4 class="modal-title" id="update_fridge_modal_title">Sign In</h4>
			</div>
			<div class="modal-body">
				<div id="modal_results"><?php echo $this->session->flashdata('flash_message');?></div>
				<div class="control-group">
    				<label class="control-label">Name</label>
    				<div class="controls">
      					<input type="text" name="name" placeholder="Name">
    				</div>
 				</div>
  				<div class="control-group">
    				<label class="control-label">Password</label>
	    			<div class="controls">
	      				<input type="password" name="password" placeholder="Password">
	    			</div>
  				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-custom-purple btn-block btn-large" id="sign_in_button"><i class="icon-user"></i> Sign In</button>
			</div>
			<?php echo form_close();?>	
		</div>
	</div>
</div>