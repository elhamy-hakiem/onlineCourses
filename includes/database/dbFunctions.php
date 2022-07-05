<?php
########################################################
//All Database Functions 
#########################################################
/**
 * Get All From Table Function
 * @param  $field , $table, $join => join condition ,  $on => ON condition , $where => where condition, $and => and condition
 * @return  array
 */
function getAllFrom($field , $table, $join= NULL,  $on= NULL, $where = NULL, $and = NULL)
{
    global $connection;
    $stmt = $connection ->prepare("SELECT $field FROM `$table` $join  $on $where  $and");
    $stmt ->execute();
    $allData = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    //Check If Found Data Or No
    $count = $stmt ->rowCount();

    if($count > 0)
    {
        return $allData;
    }
    else
    {
        return null;
    }
}
###############################################################
/**
 * Get user by User Id
 * @param $groupId
 * @return Array
 */
function getUserById($userId)
{
    $users = getAllFrom(
        "users.* ,users_groups.group_name" ,
        "users",
        "LEFT JOIN `users_groups`",
        " ON `users`.`user_group` = `users_groups`.`group_id`",
        "WHERE `users`.`user_id` = '$userId'",
        null
    );
    return $users;
}
###############################################################
/**
 * Get users by group Id
 * @param $groupId
 * @return Array
 */
function getUsersByGroup($groupId)
{
    $users = getAllFrom(
        "users.* ,users_groups.group_name" ,
        "users",
        "LEFT JOIN `users_groups`",
        " ON `users`.`user_group` = `users_groups`.`group_id`",
        "WHERE `users`.`user_group` = '$groupId'",
        null
    );
    return $users;
}
################################################################
/*
** Get Latest Records Function
** version(1.0)
*/
function getLatest( $columnName ,$tableName ,$orderColumn ,$limit = 8 )
{
    global $connection;
    $stmt = $connection ->prepare("SELECT $columnName FROM $tableName ORDER BY $orderColumn DESC LIMIT $limit ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($rows))
    {
        return $rows;
    }
    else
    {
        return null ;
    }
}
#################################################################
/**
 * Inserting row into database
 * @param string $tableName
 * @param array $dataInputs
 * @return boolean
 */
function Insert($tableName,$dataInputs)
{
    global $connection;
    // setup some variables for fields and values
    $fields  = '';
    $values = '';
    // populate them
    foreach ($dataInputs as $f => $v)
    {
        $fields  .= "`$f`,";
        $values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
    }

    // remove our trailing ,
    $fields = substr($fields, 0, -1);
    // remove our trailing ,
    $values = substr($values, 0, -1);

    $querystring = "INSERT INTO `{$tableName}` ({$fields}) VALUES({$values})";
    $row = $connection->exec($querystring);
    if($row)
        return true;
    else
        return false;
}
#################################################################
/**
 *
 * @param string $table
 * @param string $array
 * @return Boolean
 */
function Update($tableName,$data,$where='')
{
    global $connection;
    //set $key = $value :)
    $query  = '';
    foreach ($data as $f => $v) 
    {
        (is_numeric($v) && intval($v) == $v || is_float($v)) ? $v."," : "'$v' ,";
        $query  .= "`$f` = '{$v}' ,";
    }
    //Remove trailing ,
    $query = substr($query, 0,-1);
    $querystring = "UPDATE `{$tableName}` SET {$query} {$where}";
    $row = $connection->exec($querystring);
    if($row)
        return true;
    else
        return false;
}
#################################################################
/**
 *
 * @param string $from
 * @param string $where
 * @return boolean
 */
function Delete($from,$where)
{
    global $connection;
    $query = "DELETE FROM `$from` $where";
    $row = $connection ->exec($query);
    if($row)
        return true;
    else
        return false;
}
##################################################################################
// Student Course Function
###################################################################################
    /**
     * confirm  subscription
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    function confirmStudentSubscription($studentId,$courseId)
    {
        $data = array(
            'approved'   => 1
        );
        if(Update("courses_students",$data,"WHERE `course_id`=$courseId AND `student_id`=$studentId"))
            return true;
        else
            return false;
    }
        /**
     * add student to course
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    function addStudentToCourse($studentId,$courseId)
    {
        $data = array(
            'course_id'   => $courseId,
            'student_id'  => $studentId
        );
        if(Insert('courses_students',$data))
            return true;
        else
            return false;
    }

    /**
     * Delete student From course
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    function deleteStudentFromCourse($studentId,$courseId)
    {
        if(delete('courses_students',"WHERE `course_id`=$courseId AND `student_id`=$studentId"))
            return true;
        else
            return false;
    }

    /**
     * check if user joined course
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    function isStudentJoinedCourse($studentId,$courseId)
    {
        $student = getAllFrom(
            "*" ,
            "courses_students",
            "",
            "",
            "WHERE `course_id`=$courseId",
            "AND `student_id`=$studentId LIMIT 1"
        );
        if(!empty($student))
            return true;
        else
            return false;
    }
    /**
     * check if user Approved course
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    function isApprovedJoinedCourse($studentId,$courseId)
    {
        $student = getAllFrom(
            "*" ,
            "courses_students",
            "",
            "WHERE `course_id`=$courseId",
            "AND `student_id`=$studentId",
            "AND approved =1 LIMIT 1"
        );
        if(!empty($student))
            return true;
        else
            return false;
    }
###################################################################################
?>