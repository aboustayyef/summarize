<?php namespace Aboustayyef;
/**
 *  Extracts the content
 */
class Document
{
  public $text;
  public $sentences = [];
  function __construct($instantiationMethod = "fromText", $argument= "The new Pepsi #MeshGhalat ad is being criticized for using the word Ataf to refer to women and I agree that the term is disrespectful but not specifically towards women. I’ve seen girls use that term as well and it’s more of a slang term that’s inappropriate to use when referring to anyone in general. So yes using the “ataf” term is wrong but I don’t think that’s the only problem with this ad. In fact, I still can’t understand what’s really happening between the guy and the girl. For all I know, it could be one of three scenarios and all of them don’t make sense: 1- The guy’s car overheats so the girl comes to the rescue and they decide to have a picnic together? 2- The girl is with the guy and the car overheats and he has the picnic kit ready so he gets to spend quality time with her in the wilderness? 3- The girl was having a picnic by herself and this guy comes out of nowhere because his car broke down? Moreover, who does a picnic in Faqra (looks like Faqra in the background) and who keeps a picnic set and a hiking backpack in his car all the time? Kello mich zabit :) To be fair, the two other ads are pretty cool and the whole #MeshGhalat campaign is fun. I used that hashtag a lot and it will easily go viral.") {
    if ($instantiationMethod == "fromText") {
      $this->text = $argument;
      $this->extractSentences();
      $this->scoreSentences();
    }
    // To Do: Instantiation from URL
    return false;
  }

  public function extractSentences(){

      // Returns a collection of Keyphrases;

      // split by punctuation delimiters into sentences
      $pattern =  '/(?<=[.?!;])\s+(?=\p{Lu})/';
      $sentences = preg_split( $pattern, $this->text );
      foreach ($sentences as $key => $sentence) {
        array_push($this->sentences, ['sentence' => $sentence, 'order' => $key, 'score' => 0]);
      }
  }
  public function scoreSentences(){

    foreach ($this->sentences as $key1 => $sentence1) {
      $score = 0;
      foreach ($this->sentences as $key2 => $sentence2) {
        if ($sentence1['sentence'] === $sentence2['sentence']) {
          continue;
        }
        $score += $this->compare($sentence1['sentence'], $sentence2['sentence']);        
      }
      $this->sentences[$key1]['score'] = $score;
    }
    // array_multisort($sentenceScores);
    // $sentenceScores = array_reverse($sentenceScores);
  }

  public function split_sentence_into_words($sentence){
    $raw = preg_split('#\s+#', $sentence);
    $result = [];
    foreach ($raw as $key => $word) {
      if (strlen(trim($word)) > 0) {
        $result[] = $word;
      }
    }
    return $result;
  }

  public function compare($sentence1, $sentence2){

    $words1 = $this->split_sentence_into_words(strtolower($sentence1));
    $words2 = $this->split_sentence_into_words(strtolower($sentence2));
   
    $union = array_unique(array_intersect($words1, $words2));

    $combination = array_unique(array_merge($words1, $words2));
    if ((count($words1) < 3) || (count($words2) < 3)) {
      # sentences too short, 
      return 0;
    }
    $jaccard = count($union)/count($combination);
    return $jaccard;
  }

  public function top_scoring_sentences($howmany = 5 ){
    $scored = [];
    foreach ($this->sentences as $key => $sentence) {
      $scored[$sentence['sentence']] = $sentence['score'];
    }
    asort($scored);
    $scored = array_reverse($scored);
    return array_slice($scored, 0, $howmany);

  }

}



?>
