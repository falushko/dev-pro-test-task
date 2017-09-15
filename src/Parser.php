<?php

namespace App;

use GuzzleHttp\Client as HttpClient;
use PHPHtmlParser\Dom;

/**
 * This class is used to parse search result for $word from $website.
 * Class Parser
 * @package App
 */
class Parser
{
	private $httpClient;
	private $httpOptions = [
		'headers' => [
			'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
		]
	];

	public function __construct(string $website)
	{
		$this->httpClient = new HttpClient(['base_uri' => $website]);
	}

	/**
	 * This function makes the things done.
	 * @param string $word
	 * @return array
	 */
	public function parse(string $word) : array
	{
		$html = (string) $this->httpClient->get($word, $this->httpOptions)->getBody();

		$dom = new Dom;
		$dom->load($html);

		$content = trim((string) $dom->find('.content div#article')->innerHtml());

		return ['word' => $word, 'content' => $content];
	}
}