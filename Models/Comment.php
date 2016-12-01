<?php

namespace Models;

use DB;

class Comment extends Model
{

	public static $table    = 'comments';
	public static $required = [ 'comment' ];

	public $id;
	public $userId;
	public $comment;
	public $length;
	public $averageWordLength;
	public $twoLetterWords;
	public $capitalLetters;
	public $created_at;

	public function store()
	{
		$userId = $_SESSION['userId'];
		$this->created_at = date('Y-m-d h:i:s');
		$values = [
			'userId'            => $userId,
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
		DB::query('UPDATE `users` SET `numComments` = `numComments` + 1 WHERE `id` = :userId', ['userId' => $userId]);
	}

	public function delete()
	{
		DB::query('UPDATE `users` SET `numComments` = `numComments` - 1 WHERE `id` = :userId', ['userId' => $this->userId]);
		DB::query('DELETE FROM `comments` WHERE `id` = :commentId', ['commentId' => $this->id]);
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