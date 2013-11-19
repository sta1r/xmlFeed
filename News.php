<?php

class News extends XMLFeed {
    
    public function do_item_loop($item) { 
			
		//var_dump($item);
		$media = $item->children('http://search.yahoo.com/mrss/');
		
		?>
		<li class="row">
			<figure>
				<a href="<?php echo $item->link; ?>" title="Read the full post on our News blog"><img src="<?php echo $media->attributes(); ?>" alt=""></a>
			</figure>
			<div class="text">
				<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
				<?php echo $item->description; ?>
			</div>
		</li>

		<?php

		// echo the categories array
		// foreach ($item->category as $category) {
		// 	echo $category.' ';
		// }

	}



}

?>