<?php

//Api.php
//All methods

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=users", "root", "");
	}

	//Get all tickets
	function fetch_all()
	{
		$query = "SELECT * FROM ticket ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	//Add Tickets(works for creating a ticket type too)
	function insert()
	{
		if(isset($_POST["ticket_type"]))
		{
			$form_data = array(
				':ticket_type'		=>	$_POST["ticket_type"],
				':name'		=>	$_POST["name"]
			);
			$query = "
			INSERT INTO ticket
			(ticket_type, name) VALUES 
			(:ticket_type, :name)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM ticket WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['name'] = $row['name'];
				$data['ticket_type'] = $row['ticket_type'];
			}
			return $data;
		}
	}

//Edit Ticket (You can use same method to update ticket type)
	function update()
	{
		if(isset($_POST["name"]))
		{
			$form_data = array(
				':name'	=>	$_POST['name'],
				':ticket_type'	=>	$_POST['ticket_type'],
				':id'			=>	$_POST['id']
			);
			$query = "
			UPDATE ticket
			SET name = :name, ticket_type = :ticket_type 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	
}

?>
