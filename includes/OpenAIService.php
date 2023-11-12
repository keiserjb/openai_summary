<?php
class OpenAIService {
  protected $apiKey;

  public function __construct() {
    $config = config('openai_summary.settings');
    $this->apiKey = $config->get('openai_api_key');
  }

  public function request($prompt) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->apiKey,
    ];
    $data = json_encode([
      'model' => 'gpt-4',
      'messages' => [
        ['role' => 'user', 'content' => $prompt]
      ]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  public function testConnection() {
    $url = 'https://api.openai.com/v1/models';
    $config = config('openai_summary.settings');
    $headers = [
      'Authorization: Bearer ' . $this->apiKey = $config->get('openai_api_key'),
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode == 200;
  }

  public function generateText($prompt) {
    $prefix = 'Create a less than 140 character summary of the following text, use a tone that provokes to continue reading the whole text: ';
    $prompt = $prefix . $prompt;
    $responseBody =  $this->request($prompt); // assuming request returns the response body as a string

    $json = json_decode($responseBody, true);
    if (isset($json['choices'][0]['message']['content'])) {
      $content = $json['choices'][0]['message']['content'];
      return $content;
    }

    return null; // or handle error accordingly
  }

}



