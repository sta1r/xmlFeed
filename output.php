<?php 
// core XML processing class 
include('XMLFeed.php');
// extended for News and Research
include('News.php');
include('Research.php');

$news = new News( array( 
	'origin' => 'news', 
	'feedType' => 'tag', 
	'collegeSlug' => 'fashion', 
	'slug' => 'ma-fashion-photography') 
);

$research = new Research( array( 
	'origin' => 'research-outputs', 
	'firstName' => 'Helen', 
	'lastName' => 'Storey') 
);

$news->returnXml();
$news->do_output();

// $research->returnXml();
// $research->do_research_output();


?>