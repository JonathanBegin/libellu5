<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class timedate {
	
		private $time;
		private $okay;
		
		public function __construct ($time) {
		
			if (is_numeric($time))
				$this->okay = true;
			else
				$this->okay = false;
			
			if ($this->okay) {
			
				$this->time = $time;
			
			}
		
		}
		
		public function ago () {
		
			if ($this->okay) {
				
				$diff = time() - $this->time;
				
				// Work for future
				$future = false;
				if ($diff < 0) {
					$diff = $diff * -1;
					$future = true;
				}
				
				if ($diff > 59) {
				
					$interval = array();
					
					// Years
					$interval['years'] = floor($diff/31536000);
					$diff -= ($interval['years'] * 31536000);
					
					// Months
					$interval['months'] = floor($diff/2592000);
					$diff -= ($interval['months'] * 2592000);
					
					// Days
					$interval['days'] = floor($diff/86400);
					$diff -= ($interval['days'] * 86400);
					
					// Hours
					$interval['hours'] = floor($diff/3600);
					$diff -= ($interval['hours'] * 3600);
					
					// Minutes
					$interval['minutes'] = floor($diff/60);
					$diff -= ($interval['minutes'] * 60);
					
					// Seconds
					$interval['seconds'] = $diff;
					
					$string = '';
					$i = 0;
					
					foreach ($interval as $name => $amount) {
					
						if (($amount > 0) && ($i < 2)) {
							
							if ($amount == 1)
								$nname = rtrim($name,'s');
							else
								$nname = $name;
							
							$string .= $amount . ' ' . $nname . ' and ';
							$i++;
						
						} elseif ($i > 0)
							$i++;
					
					}
					
					if ($future)
						$string = 'In ' . $string;
					else
						$string = $string . ' ago';
						
					$pos = strrpos($string, ' and ');
					
					if($pos !== false)
					{
						$string = substr_replace($string, '', $pos, strlen(' and '));
					}
					
					return $string;
				
				} else {
				
					if ($future)
						return 'In ' . $diff . ' seconds';
					else
						return 'Just now';
					
				}
				
			} else
				return 'Some time ago';
		
		}
		
		public function db() {
			if ($this->okay)
				return $this->time;
			else
				return 0;
		}
	
	}