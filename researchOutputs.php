<?php

if(class_exists('ResearchOutputs') != true) {

	class ResearchOutputs {
		
		public $xml;
		public $firstName;
		public $lastName;
		public $url;
		
		/**
		 * [__construct This returns the firstName and lastName in the object]
		 *
		 * @param string  $firstName [set the firstName for the RSS feed URL]
		 * @param string  $lastName [set the lastName for the RSS feed URL]
		 */
		public function __construct( $firstName = "", $lastName = "" ) {
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			
			$this->url = "http://ualresearchonline.arts.ac.uk/cgi/search/advanced/export_kultur_MediaRSS2.xml?screen=Public%3A%3AEPrintSearch&_action_export=1&output=MediaRSS2&exp=0%7C1%7C-date%2Fcreators_name%2Ftitle%7Carchive%7C-%7Cbestoutputs%3Abestoutputs%3AALL%3AEQ%3ATRUE%7Ccreators_name%3Acreators_name%3AALL%3AIN%3A".$lastName."%2C+".$firstName."%7C-%7Ceprint_status%3Aeprint_status%3AALL%3AEQ%3Aarchive%7Cmetadata_visibility%3Ametadata_visibility%3AALL%3AEX%3Ashow&n=";
			$t = $this->url;
		}
		
		public function __destruct() {
			unset( $this->array);
		}
				
		public function outputsDatesCache($firstName="", $lastName=""){
		    //$cache_file = "/web/sites/t4www/www.arts.ac.uk/output-".$firstName."-".$lastName.".txt";
		    $cache_file = "output-".$firstName."-".$lastName.".txt";
		    $cache_outofdate = "-1 day"; // Minimum interval to update the cache file    
		    
		    // TRY AND GET THE LIVE DATA
		    // --------------------------------------

			$ch = curl_init("http://ualresearchonline.arts.ac.uk/cgi/search/advanced/export_kultur_MediaRSS2.xml?screen=Public%3A%3AEPrintSearch&_action_export=1&output=MediaRSS2&exp=0%7C1%7C-date%2Fcreators_name%2Ftitle%7Carchive%7C-%7Cbestoutputs%3Abestoutputs%3AALL%3AEQ%3ATRUE%7Ccreators_name%3Acreators_name%3AALL%3AIN%3A".$lastName."%2C+".$firstName."%7C-%7Ceprint_status%3Aeprint_status%3AALL%3AEQ%3Aarchive%7Cmetadata_visibility%3Ametadata_visibility%3AALL%3AEX%3Ashow&n="); 
			
		    curl_setopt($ch, CURLOPT_PROXY, 'wwwcache.arts.ac.uk:3128');  curl_setopt($ch, CURLOPT_FAILONERROR,1);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		    $retValue = curl_exec($ch); curl_close($ch);
		    
		    if (!empty($retValue)) {
		        // IF the LIVE data was returned. 
		        if ((!file_exists($cache_file)) OR (!empty($_GET['cacheupdate'])) OR (@filesize($cache_file) <= 10) OR ((filemtime($cache_file) < (strtotime($cache_outofdate))))) {
		            // IF no cache exists OR forced update OR cache file is emmpty OR cachefile is out of date (as defiend by $cache_outofdate), UPDATE IT.
		            $writeDat = @file_put_contents($cache_file, $retValue);
		            echo '<!-- DEBUG: Cache file was successfully updated -->'; // echo '<!-- DEBUG: Cache file was successfully updated (' . $cache_file . ') -->';
		        }
		        // Return LIVE data
		        return $retValue;		        
		    } else {
		        // ELSE no live data was returned. Try read it from the cache
		        if ((@file_exists($cache_file)) AND (filesize($cache_file) > 10)) {
		            // As long as the cache file is populated, return that.
		            echo '<!-- DEBUG: cache update failed, read old information from cache (' . $cache_file . ') -->';
		            $retValue = @file_get_contents($cache_file);
		            
		            // As long as it is not empty, return cache data
		            if (!empty($retValue)) {
		                return $retValue;
		            }
		        }
		        
		        // Return Error message (No LIVE data or populated CACHE data)
		        echo '<!-- DEBUG: Unable to update file and no cache available -->';
		        return 'ERROR';
		    }
		}
		
		public function returnXml() {
			echo '<!-- DEBUG: start returnXML -->';
			$this->xml = @simplexml_load_string($this->outputsDatesCache($this->firstName, $this->lastName));
			$result = $this->xml;
			
			//			echo $this->url;
			//			var_dump($this->xml);

			echo '<!-- DEBUG: returnXML successful -->';
			return $this->xml;
		}
		
		public function returnErrors() {
			if(isset($_GET['errors'])){
				ini_set('display_errors',1); 
				ini_set('error_reporting', E_ALL); 
				error_reporting(E_ALL);
			}
		}
		

	}

}
	
?>