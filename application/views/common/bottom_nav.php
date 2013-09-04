<div class="navbar navbar-fixed-bottom">
    <div class="navbar-inner navbar-tall">
        <div class="container" >
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".collapse_bottom">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse navbar-responsive-collapse collapse_bottom">
            	<ul class="nav">
                    <li>
                        <?php echo form_open('', 'id="chat_form"');?>
                    	    <button type="submit" class="btn btn-custom-purple pull-right btn-large" id="chat_button">
                                <i class="icon-check"></i> Submit
                            </button>
  							<input class="span10" id="chat_text_field" name="chat_text_field" type="text">
                       		
                       
                        <?php echo form_close();?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>