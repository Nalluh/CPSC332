<!DOCTYPE html>
<html>
<head>
	<title>Survey System</title>
</head>
<body>
	<h1>Survey System</h1>
	<form action="search.php" method="GET">
		<label for="search">Search by name or code:</label>
		<input type="text" name="search" id="search">
		<input type="submit" value="Search">
	</form>
	<h2>All Surveys</h2>
	<table>
		<thead>
			<tr>
				<th>Code</th>
				<th>Name</th>
				<th>Description</th>
				<th>Start Date-Time</th>
				<th>End Date-Time</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			
	</tbody>
</table>
</body>
</html>

<?php


for($i =0; $i <= $_POST['SurveyQuestions']){

	echo $_POST['SurveyQuestions'];
}

?>
