	
  </div>
  <script src="/skin/js/jquery.min.js"></script>
  <script src="/skin/js/bootstrap.min.js"></script>
  <?php if(isset($js)):?>
	<!-- Include Custom JS files -->
	<?php foreach($js as $j):?>
		<?php if(strpos($j, '.js') === FALSE):?>
			<?php if(file_exists(getcwd().'/skin/js/custom/'.$j.'.js')):?>
			<script src="/skin/js/custom/<?php echo $j;?>.js"></script>
			<?php endif;?>
		<?php else:?>
			<?php $filename = explode('.js', $j);?>
			<?php if(file_exists(getcwd().'/skin/js/custom/'.$filename[0].'.js')):?>
			<script src="/skin/js/custom/<?php echo $j;?>"></script>
			<?php endif;?>
		<?php endif;?> 
	<?php endforeach;?>
	<?php endif;?>
</html>