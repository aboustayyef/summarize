<?php

require_once('vendor/autoload.php');

$document = new Aboustayyef\Document("fromUrl", "http://stateofmind13.com/2015/06/11/lebanese-policeman-physically-assaults-a-woman-for-stopping-at-a-red-light-ends-up-innocent-anyway/");

var_dump($document->text);

$sentences = $document->sentences;
var_dump($sentences);
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
