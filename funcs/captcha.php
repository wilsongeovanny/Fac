<?php 
const PAGE="6LdeNnAaAAAAAM8GU1vqjVYRAyq5pv3zvssSqPQY";
const SECRET_C="6LdeNnAaAAAAAOJTBI8Ifz5GX91IbQE5YXd7550f";
function resultBlock($errors){
	if(count($errors) > 0)
	{
		echo "<div id='error' class='' role=''>
		<p href='#' onclick=\"showHide('error');\"></p>
		<ul>";
		foreach($errors as $error)
		{
			echo "<li>".$error."</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
}
?>