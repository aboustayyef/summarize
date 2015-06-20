<?php

require_once('vendor/autoload.php');

$document = new Aboustayyef\Document("fromUrl", "http://www.bbc.com/news/world-us-canada-33211192");

$sentences = $document->sentences;

$document->top_scoring_sentences(5);

echo "Sorted in order of appearance: \n";
$orderOfAppearance = $document->top_scoring_sentences(5);
var_dump($orderOfAppearance);

echo "Sorted in order of strength: \n";
var_dump($document->top_scoring_sentences(5,false));

$paragraph = "";
foreach ($orderOfAppearance as $sentence => $position) {
	$paragraph .= $sentence;
}
echo "$paragraph \n";

?>
