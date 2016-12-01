<?php

namespace Models;

use DB;

class Comment
{

	public static $table = 'comments';

	public $id;
	public $userId;
	public $comment;
	public $length;
	public $averageWordLength;
	public $twoLetterWords;
	public $capitalLetters;
	public $created_at;

	public function __construct($values = [])
	{
		foreach ($values as $property => $value)
		{
			// Some validation on these fields would be prudent so they match their DB column type at very least
			if (property_exists($this, $property)) $this->{$property} = $value;
		}
	}

	public function store()
	{
		$this->created_at = date('Y-m-d h:i:s');
		$values = [
			'userId'            => 1, // Need to grab from session
			'comment'           => $this->comment,
			'length'            => $this->getLength(),
			'averageWordLength' => $this->getAverageWordLength(),
			'twoLetterWords'    => $this->getTwoLetterWords(),
			'capitalLetters'    => $this->getCapitalLetters(),
			'created_at'        => $this->created_at,
		];
		DB::query('INSERT INTO `' . self::$table . '` 
			(`userId`, `comment`, `length`, `averageWordLength`, `twoLetterWords`, `capitalLetters`, `created_at`)
			VALUES
			(:userId, :comment, :length, :averageWordLength, :twoLetterWords, :capitalLetters, :created_at)',
			$values
		);
	}

	public function getLength()
	{
		$this->length = mb_strlen($this->comment);
		return $this->length;
	}

	public function getAverageWordLength()
	{
		$words = explode(" ", $this->comment);
		$lengths = array_map(function($word)
		{
			return mb_strlen($word);
		}, $words);
		$this->averageWordLength = array_sum($lengths) / count($words);
		return $this->averageWordLength;
	}

	public function getTwoLetterWords()
	{
		$words = explode(" ", $this->comment);
		$twoLetterWords = array_filter($words, function($word)
		{
			return mb_strlen($word) === 2;
		});
		$this->twoLetterWords = count($twoLetterWords);
		return $this->twoLetterWords;
	}

	public function getCapitalLetters()
	{
		$this->capitalLetters = mb_strlen(preg_replace('![^A-Z]+!', '', $this->comment));
		return $this->capitalLetters;
	}

	public function similar()
	{
		$bindings = [
			'commentId' => $this->id,
			'minLength' => max($this->averageWordLength - 1, 0),
			'maxLength' => $this->averageWordLength + 1,
		];
		$similar = DB::getObject('Models\Comment',
			'SELECT `comments`.`*`, `users`.`username` FROM `' . self::$table . '` JOIN `users` ON `' . self::$table . '`.`userId` = `users`.`id` WHERE `comments`.`id` != :commentId AND `averageWordLength` >= :minLength AND `averageWordLength` <= :maxLength ORDER BY `' . self::$table . '`.`created_at` DESC', 
			$bindings
		);
		return $similar;
	}

}