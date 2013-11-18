<?php

class Research extends XMLFeed {

	public function do_research_item_loop($item) { 
		
		$image = $item->children('media', true);
		
		if (!empty($image)) {
			$image_link = $image['content'];				
			$image_src = "http://ualresearchonline.arts.ac.uk".$image->content->attributes();
		} else {
			$image_src = "http://app.resrc.it/o=60/http://www.arts.ac.uk/media/placeholder-images/research-580x580.jpg";
		}
				
		$bg_img = "<div class=\"center-cropped\" style=\"background-image: url(".$image_src.")\"><img class=\"lazyOwl\" src=".$image_src." /></div>";
		$desc = $item->description;
	
		echo "<div class=\"item\">";	
		echo $bg_img; 
		echo "<div class=\"item-description\">";
		echo "<h4><a href=\"";
		if ($item->link != '') { echo $item->link; } 
		echo "\">";
		if ($item->title != '') { echo $item->title; } 
		echo "</a></h4><p>";
		// try to match our pattern
		preg_match_all("/\([1-2][0-9][0-9][0-9]\)/", $desc, $matches);
		// loop through the matches with foreach
		foreach($matches[0] as $value)
		{
			echo $value;
		}
		echo "</p></div></div>";
	}

	public function do_research_output() {
		
		$xml = $this->xml;

		if (!empty($xml)) {

			echo "<h2>Research Outputs</h2>";
			echo "<div class=\"row\">";
			echo "<div class=\"owl-carousel research-outputs\">";

			foreach( $xml->channel->item as $item ) 
			{ 
				$this->do_research_item_loop($item); 
			} 
			echo "</div></div>";

		}

		
	}


}

?>