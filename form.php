<?
/**
 * Basic Form Classes
 */

class Form {
	var $preamble, $to, $cc, $bcc, $from, $subject, $message, $headers, $separator, $newline, $fields;
	
	function __construct() {
		$this->newline = "\n";
		$this->separator = "\n\n";
	}
	
	function send() {
		
		if(strlen($this->from))
			$this->headers[] = "From: ".$this->from;
		
		if(strlen($this->cc))
			$this->headers[] = "CC: ".$this->cc;
		
		if(strlen($this->bcc))
			$this->headers[] = "BCC: ".$this->bcc;
			
		$this->message = $this->subject . $this->newline;
		
		for ($i=0; $i < strlen($this->subject); $i++) { 
			$this->message .= "=";
		}
		$this->message .= $this->separator;
		
		if(strlen($this->preamble))
			$this->message = $this->preamble . $this->separator;
		
		foreach($this->fields as $field) {
			if(isset($field->label) && isset($field->value)) {
				$this->message .= $field->label;
				
				if(strlen($field->value))
					$this->message .= ': '. $field->value;
					
				$this->message .= $this->separator;
			}
				
			if(isset($field->heading)) {
				$this->message .= $this->newline . $field->heading . $this->newline;
				for ($i=0; $i < strlen($this->subject); $i++) { 
					$this->message .= "-";
				}
				$this->message .= $this->separator;
			}
		}

		$this->headers = implode($this->headers,"\r\n");

		return mail($this->to, $this->subject, $this->message, $this->headers);
	}
}

class FormField {
	var $label, $value;
	
	function __construct($label=NULL, $value=NULL) {
		$this->label = $label;
		$this->value = stripslashes($value);
	}
}

class FormHeading {
	var $heading;
	
	function __construct($heading=NULL) {
		$this->heading = $heading;
	}
}