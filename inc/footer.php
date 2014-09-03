<?php

	// Footer
	
?>
		<script src="<?=$this->l5->HTMLRoot()?>js/vendor/jquery.js"></script>
		<script src="<?=$this->l5->HTMLRoot()?>js/foundation.min.js"></script>
		<script src="<?=$this->l5->HTMLRoot()?>js/jquery.lettering.js"></script>
		<script src="<?=$this->l5->HTMLRoot()?>js/circletype.min.js"></script>
		<script type="text/javascript">
			$(document).foundation({
				'magellan-expedition' : {
					
					destination_threshold: 0
				}
			});
		</script>
		<?php	// Check for scroll
		
			if (isset($this->scroll)) {
			
				echo '
				<script type="text/javascript">$(window).scrollTop($("' . $this->scroll . '").offset().top).scrollLeft($("' . $this->scroll . '").offset().left)</script>
				';
			
			}
		
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('div[data-type="background"]').each(function(){
					var $bgobj = $(this); // assigning the object
				 
					$(window).scroll(function() {
						//var yPos = -($(window).scrollTop() / $bgobj.data('speed'));
						var yPos = -( ($(window).scrollTop() - $bgobj.offset().top) / $bgobj.data('speed'));
						 
						// Put together our final background position
						var coords = '50% '+ yPos + 'px';
			 
						// Move the background
						$bgobj.css({ backgroundPosition: coords });
					}); 
				});    
			});
		</script>
		<script type="text/javascript">
		
			$('.homepageherocontent>h1:first-child').circleType({fluid:true});
			$('.homepageherocontent>h1:last-child').circleType({fluid:true, dir:-1});
		
		</script>
		<!-- Google Analytics -->
		<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-52762676-1', 'auto');
			  ga('send', 'pageview');
		</script>
	</body>
</html>