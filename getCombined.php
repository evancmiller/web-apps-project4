<?php
    class Combined{
        public $plan;
        public $catalog;

        public function __construct(){
            $this->plan = new Plan();
            $this->catalog = new Catalog();
        }
    }

    class Plan{
        public $student;
        public $name;
        public $major;
        public $courses;
        public $catYear;

        public function __construct(){
            $this->courses = array();
        }

        public function addCourse($course){
            $this->courses[$course] = new PlanCourse();
        }
    }

    class PlanCourse{
        public $id;
        public $year;
        public $term;
    }

    class Catalog{
        public $year;
        public $courses;

        public function __construct(){
            $this->courses = array();
        }

        public function addCourse($course){
            $this->courses[$course] = new CatalogCourse();
        }
    }

    class CatalogCourse{
        public $id;
        public $name;
        public $description;
        public $credits;
    }

    session_start();

    $planId = $_GET["id"];
    $combined = new Combined();
    $combined->plan->student = $_SESSION["user"];

    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    // Retrieve plan information from database
    $query = $db->prepare("SELECT name, major_id, catalog_id FROM ae_Plan WHERE id = ?");
    $query->bind_param("i", $planId);
    $query->execute();
    $query->bind_result($combined->plan->name, $majorId, $catalogId);
    $query->fetch();
    $query->close();

    // Retrieve major name from database
    $query = $db->prepare("SELECT name FROM ae_Major WHERE id = ?");
    $query->bind_param("i", $majorId);
    $query->execute();
    $query->bind_result($combined->plan->major);
    $query->fetch();
    $query->close();

    // Retrieve catalog year from database
    $query = $db->prepare("SELECT year FROM ae_Catalog WHERE id = ?");
    $query->bind_param("i", $catalogId);
    $query->execute();
    $query->bind_result($combined->plan->catYear);
    $query->fetch();
    $query->close();
    $combined->catalog->year = $combined->plan->catYear;

    // Retrieve planned courses from database and add to plan
    $query = $db->prepare("SELECT c.desig, pc.year, pc.semester FROM ae_Course c, ae_Plan_Course pc WHERE c.id = pc.course_id AND pc.plan_id = ?");
    $query->bind_param("i", $planId);
    $query->execute();
    $query->bind_result($desig, $year, $semester);
    while($query->fetch()){
        $combined->plan->addCourse($desig);
        $combined->plan->courses[$desig]->id = $desig;
        $combined->plan->courses[$desig]->year = $year;
        $combined->plan->courses[$desig]->term = $semester;
    }
    $query->close();

    // Retrieve courses from database and add to catalog
    $query = $db->prepare("SELECT c.desig, c.name, c.description, c.hours FROM ae_Course c INNER JOIN ae_Catalog_Course cc ON c.id = cc.course_id WHERE cc.catalog_id = ?");
    $query->bind_param("i", $catalogId);
    $query->execute();
    $query->bind_result($desig, $name, $description, $hours);
    while($query->fetch()){
        $combined->catalog->addCourse($desig);
        $combined->catalog->courses[$desig]->id = $desig;
        $combined->catalog->courses[$desig]->name = $name;
        $combined->catalog->courses[$desig]->description = $description;
        $combined->catalog->courses[$desig]->credits = (int)$hours;
    }

    $query->close();
    $db->close();
    echo json_encode($combined);
?>