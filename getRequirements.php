<?php
    class Requirements{
        public $categories;

        public function __construct(){
            $this->categories = array();
        }

        public function addCategory($category){
	    if($this->categories[$category] == null){
            	$this->categories[$category] = new Category();
	    }
        }
    }

    class Category{
        public $courses;

        public function __construct(){
            $this->courses = array();
        }

        public function addCourse($course){
	    array_push($this->courses, $course);
        }
    }

    session_start();

    $planId = $_GET["id"];
    $requirements = new Requirements();
    $student = $_SESSION["user"];

    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    // Retrieve plan information from database
    $query = $db->prepare("SELECT catalog_id FROM ae_Plan WHERE id = ?");
    $query->bind_param("i", $planId);
    $query->execute();
    $query->bind_result($catalogId);
    $query->fetch();
    $query->close();


    // Retrieve categories from database and add to requirements
    //$query = $db->prepare("SELECT r.category_id, c.name FROM ae_Requirement r, ae_Category c WHERE c.id = r.category_id AND r.catalog_id = ?");
    $query = $db->prepare("SELECT c.name, co.desig
	FROM ae_Requirement r, ae_Category_Course cc
	INNER JOIN ae_Category c ON c.id = cc.category_id
	INNER JOIN ae_Course co ON co.id = cc.course_id
	WHERE c.id = r.category_id
	AND r.catalog_id =?");
    $query->bind_param("i", $catalogId);
    $query->execute();
    $query->bind_result($categoryName, $desig);
    while($query->fetch()){
        $requirements->addCategory($categoryName);
        $requirements->categories[$categoryName]->addCourse($desig);
    }
    $query->close();
    $db->close();
    echo json_encode($requirements);
?>
