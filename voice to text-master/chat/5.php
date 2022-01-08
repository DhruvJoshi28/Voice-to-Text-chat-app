<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body bgcolor="orange">
	<?php

	    class student
	    {
	    	public $name,$id,$sem;
	    	public function getdate($n,$i,$s)
	    	{
	    		$this -> name = $n;
	    		$this -> id  = $i;
	    		$this -> sem = $s;
	    	}

	    	public function display()
	    	{
	    		echo "My name is:".$this -> name;
	    		echo "My id is:",$this -> id;
	    		echo "My degree is:".$this -> sem;
	    	}
	    }

	    $s1 = new student;
	    $s1 -> getdata("Joshi Dhruv","19DIT023","5");
	    $s1 -> display();
	?>
    
</body>
</html>>