<?php

namespace Drupal\openai_summary\Service;

use Drupal\openai_connection\Service\OpenAIService;

/**
 * Service class for OpenAI integration.
 */
class OpenAISummary extends OpenAIService {

  /**
   * Generates text using GPT-4.
   *
   * @param string $prompt
   *   A String with the prompt.
   *
   * @return string
   *   The generated text.
   */
  public function generateText($prompt) { 
    $prefix = 'Create a less than 140 character summary of the following text, use a tone that provoke to continue reading the whole text: ';
    $prompt = $prefix . $prompt;
    $responseBody =  $this->request($prompt)->getBody()->getContents();
    $json = json_decode($responseBody, true);
    $content = $json['choices'][0]['message']['content'];
    return $content;
  }

}
