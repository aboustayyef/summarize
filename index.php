<?php

require_once('vendor/autoload.php');

$document = new Aboustayyef\Document;

$sentences = $document->sentences;

$topscoring = $document->top_scoring_sentences(5);

$inorder = [];
foreach ($topscoring as $phrase => $score) {
	foreach ($document->sentences as $key => $sentence) {
		if ($phrase == $sentence['sentence']) {
			$inorder[$phrase] = $sentence['order'];
			continue;
		}
	}
}
asort($inorder);
var_dump($inorder);

?>
