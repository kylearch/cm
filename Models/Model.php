<?php

namespace Models;

class Model
{
	public function __construct($values = [])
	{
		foreach ($values as $property => $value)
		{
			// Some validation on these fields would be prudent so they match their DB column type at very least
			if (property_exists($this, $property)) $this->{$property} = $value;
		}
	}

	public function isValid()
	{
		$valid = TRUE;
		foreach ($this::$required as $field)
		{
			if (empty($this->{$field})) $valid = FALSE;
		}
		return $valid;
	}
}