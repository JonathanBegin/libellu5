<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class libellu5 {
	
		private $sql;
		private $root;
		private $HTMLRoot;
		private $title;
		
		public function __construct ($l5Host, $l5User, $l5Pass, $l5Database, $l5HTMLRoot) {
		
			// Connect to database
			$this->sql = mysqli_connect($l5Host, $l5User, $l5Pass, $l5Database);
			
			// Set roots
			$this->root = substr(__DIR__,0,-7);
			$this->HTMLRoot = $l5HTMLRoot;
			
		}
		
		// Root gets
		
		public function root () {
			return $this->root;
		}
		
		public function HTMLRoot () {
			return $this->HTMLRoot;
		}
		
		// Database functionality
		public function sql ($string, array $params) {
		
			if (!is_string($string)) {
				
				// oh no
				
			}
			
			// Prepare the variables
			$i = '';
			foreach ($params as $parameter) {
				$i .= 's';
			}
			
			if ($stmt = mysqli_prepare($this->sql,$string)) {
			
				if (count($params) == count($params,1)) {
				
					$params = array($params);
					$multiQuery = FALSE;
					
				} else
					$multiQuery = TRUE;
				
				$bindParams = array();    
				$bindParamsReferences = array(); 
				
				if ($i) {
				
					$bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");         
					
					foreach ($bindParams as $key => $value) { 
						$bindParamsReferences[$key] = &$bindParams[$key];  
					}
					
					array_unshift($bindParamsReferences,$i); 
					$bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
					$bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); 
					
				} 
				
				$result = array();
				foreach ($params as $queryKey => $query) {
					
					foreach ($bindParams as $paramKey => $value) {
					
						$bindParams[$paramKey] = $query[$paramKey]; 
					
					}
					
					$queryResult = array(); 
					
					if (mysqli_stmt_execute($stmt)) {
					
						$resultMetaData = mysqli_stmt_result_metadata($stmt); 
						
						if ($resultMetaData) { 
						
							$stmtRow = array();   
							$rowReferences = array();
					  
							while ($field = mysqli_fetch_field($resultMetaData)) {
							
								$rowReferences[] = &$stmtRow[$field->name];
							
							}
				   
							mysqli_free_result($resultMetaData);
							
							// Free up memory
							mysqli_stmt_store_result($stmt);
							
							$bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
							$bindResultMethod->invokeArgs($stmt, $rowReferences);
							
							while (mysqli_stmt_fetch($stmt)) {
							
								$row = array(); 
								
								foreach ($stmtRow as $key => $value) {
									
									$row[$key] = $value;
									
								}
								
								$queryResult[] = $row;
								
							}
							
							mysqli_stmt_free_result($stmt); 
							
						} else { 
					  
							$queryResult[] = mysqli_stmt_affected_rows($stmt);
						
						}
					
					} else {
					
						$queryResult[] = FALSE;
						
					}
					
					$result[$queryKey] = $queryResult; 
				}
				
				mysqli_stmt_close($stmt);
				
			} else
				return mysqli_error($this->sql);
			
			if ($multiQuery)
				return $result;
				
			else
				return $result[0];
		
		}
		
		public function setTitle ($title) {
		
			if (is_string($title)) {
				$this->title = $title;
			}
		
		}
		
		public function title () {
		
			return $this->title;
		
		}
		
		public function setSetting ( $setting, $value ) {
		
			// Check that setting exists
			$checkSetting = $this->sql('SELECT * FROM l5_settings WHERE setting = ?',array($setting));
			if (!is_array($checkSetting)) {
			
				throw new error ('Error: ' . $checkSetting,$this);
				return false;
				
			} else {
			
				if (empty($checkSetting)) {
				
					throw new error ('Error: trying to change a setting ("' . $setting . '") which does not exist.');
					return false;
					
				} else {
				
					return $checkSetting['value'];
				
				}
			
			}
		
		}
		
		public function setting ( $setting ) {
		
			// Check that setting exists
			$checkSetting = $this->sql('SELECT * FROM l5_settings WHERE setting = ?',array($setting));
			if (!is_array($checkSetting))
				throw new error ('Error: ' . $checkSetting,$this);
			else {
			
				if (empty($checkSetting)) {
				
					throw new error ('Error: trying to get a setting ("' . $setting . '") which does not exist.');
					return false;
					
				} else {
				
					$setSetting = $this->sql('UPDATE l5_settings SET value = ? WHERE setting = ?',array($value,$setting));
					if (!is_array($setSetting)) {
					
						throw new error ('Error: ' . $setSetting,$this);
						return false;
						
					} else {
					
						return true;
					
					}
				
				}
			
			}
		
		}
	
	}