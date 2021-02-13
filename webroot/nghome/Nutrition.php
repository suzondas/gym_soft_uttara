<?php
include("connection.php");
$id=intval(mysqli_real_escape_string($conn,$_REQUEST["id"]));
$sql="SELECT `id`,`start_date`,`expire_date` FROM `gym_nutrition` WHERE `user_id`=$id";
$result = array();
$query=$conn->query($sql);
if($query->num_rows>0)
{
	$result['status']="1";
	$result['error']="";
	while($r = $query->fetch_assoc())
	{
		$sql="SELECT `day_name`,`nutrition_time`,`nutrition_value` FROM `gym_nutrition_data` 
		INNER JOIN `gym_nutrition` ON `nutrition_id`=gym_nutrition.id WHERE `nutrition_id`='".$r['id']."'
		ORDER BY CASE WHEN day_name = 'Sunday' THEN 1 WHEN day_name = 'Monday' THEN 2 WHEN day_name = 'Tuesday'
		THEN 3 WHEN day_name = 'Wednesday' THEN 4
		WHEN day_name = 'Thursday' THEN 5 WHEN day_name = 'Friday' THEN 6 WHEN day_name = 'Saturday' THEN 7 END ASC";
		$query1=$conn->query($sql);
		if($query1->num_rows>0)
		{
			while($r1 = $query1->fetch_assoc())
			{
				$r['days'][]=$r1;
			}
			$result['result'][]=$r;
		}
		
	}
}
else
{
	$result['status']="0";
	$result['error']="No Record!";
}
if (empty($result['result']))
{
	$result['status']="0";
	$result['error']="No Record!";
}
echo json_encode($result);

?>