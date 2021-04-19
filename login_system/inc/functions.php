<?php 
define('DB_NAME', 'F:\Web\HasinHayder\php_practice\8-crud\crud\data\db.txt');
function seed(){
    $data = array(
        array(
            'id' => 1,
            'fname' => 'Jamal',
            'lname' => 'Ahmed',
            'roll' => '8'
        ),
        array(
            'id' => 2,
            'fname' => 'Kamal',
            'lname' => 'Ahmed',
            'roll' => '9'
        ),
        array(
            'id' => 3,
            'fname' => 'Rahim',
            'lname' => 'Uddin',
            'roll' => '10'
        ),
        array(
            'id' => 4,
            'fname' => 'Karim',
            'lname' => 'Hossen',
            'roll' => '11'
        ),
        array(
            'id' => 5,
            'fname' => 'Ratan',
            'lname' => 'Hossen',
            'roll' => '12'
        )
    );

    // Data serialized 
    $serializedData = serialize($data);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX);
}

function generateReport(){
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Roll</th>
            <?php if(hasPrivilege()): ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>
        <?php foreach($students as $student){
            ?>
                <tr>
                    <td><?php printf('%s', $student['id']); ?></td>
                    <td><?php printf('%s %s', $student['fname'], $student['lname']); ?></td>
                    <td><?php printf('%s', $student['roll']); ?></td>
                    <?php if(isAdmin()): ?>
                        <td><?php printf('<a href="index.php?task=edit&id=%s">Edit<a/> | <a class="delete" href="index.php?task=delete&id=%s">Delete<a/>', $student['id'], $student['id']); ?></td>
                    <?php elseif(isManager()): ?>
                        <td><?php printf('<a href="index.php?task=edit&id=%s">Edit<a/>', $student['id']); ?></td>
                    <?php endif; ?>
                </tr>
            <?php
        };
        ?>
    </table>
    <?php
}

// Add student 
function addStudent($fname, $lname, $roll){
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student ) {
        if($student['roll'] == $roll){
            $found = true;
            break;
        }
    }
    if(!$found){
        $newId = getNewId($students);
        $student = array(
            'id' => $newId,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );
        array_Push($students, $student);
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}

 
function getStudent($id){
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student ) {
        if($student['id'] == $id){
            return $student;
        }
    }
    return false;
}
// Update student
function updateStudent($id, $fname, $lname, $roll){
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student ) {
        if($student['roll'] == $roll && $student['id'] != $id){
            $found = true;
            break;
        }
    }
    if(!$found){
        $students[$id-1]['fname'] = $fname;
        $students[$id-1]['lname'] = $lname;
        $students[$id-1]['roll'] = $roll;
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}

// Delete student
function deleteStudent($id){
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $offset=>$student ) {
        if($student['id'] == $id){
            unset($students[$offset]);
        }
    }
    $serializedData = serialize($students);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX);
}

// NewId 
function getNewId($students){
    $maxId = max(array_column($students, 'id'));
    return $maxId+1;
}

// Admin function 
function isAdmin(){
    return('admin' == $_SESSION['role']);
}

// Manager function 
function isManager(){
    return('manager' == $_SESSION['role']);
}

//has Privilege function 
function hasPrivilege(){
    return (isAdmin() || isManager());
}