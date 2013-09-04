<br>
<?php if(isset($messages) && count($messages) >= 25):?>
<button id="load_older_messages" class="btn btn-custom-purple btn-block btn-large"><i class="icon-refresh"></i> Load Older Messages</button>
<?php endif;?>
<?php if(isset($messages)):?>
<input type="hidden" value="<?php echo count($messages);?>" id="offset">
<div id="text_messages_div">
	<?php foreach($messages as $message):?>
	<div class="row" >
		<div class="span12">
			<div class="sms_bubble <?php echo ($message['from'] == $this->session->userdata('client_id')) ? 'blue-right' : '';?>">
			  	<p>
					<strong><?php echo $message['from_user'];?></strong> to 
					<strong><?php echo $message['to_user'];?></strong>
					- <?php echo $message['time_since'];?>
				</p>
				<?php echo $message['message'];?>	
			</div>
		</div>
	</div>
	<input type="hidden" class="message_id" value="<?php echo $message['id'];?>">
	<?php endforeach;?>
</div>
<div id="new_messages"></div>
<?php endif;?>
<div id="bottom_message">
