<!DOCTYPE HTML>
<?php
    session_start();

    if(!isset($_SESSION["userId"])){
        header("Location: http://judah.cedarville.edu/~miller/TermProject/login.php");
    }
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 4</title>
        <link rel="stylesheet" type="text/css" href="css/project4.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script lang="javascript" src="js/project4.js" defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-5">
                <h1>Academic Planning</h1>
            </div>
            <div class="col-2">
                <div class="row">
                    Name: <?php print $_SESSION["user"] ?>
                </div>
                <div class="row" id="major">
                    Major:
                </div>
            </div>
            <div class="col-2">
                <div class="row" id="catalogYear">
                    Catalog Year:
                </div>
                <div class="row" id="catalogHours">
                    Catalog Hours:
                </div>
            </div>
            <div class="col-2">
                <label for="plan">Plan</label><br>
                <select name="plan" id="planSelect" value="" onchange="getCombined(this.value)">
                    <?php
                        $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

                        // Retrieve the user's plans from the database
                        $query = $db->prepare("SELECT id, name FROM ae_Plan WHERE user_id = ?");
                        $query->bind_param("i", $_SESSION["userId"]);
                        $query->execute();
                        $query->bind_result($planId, $planName);
                    
                        // List the user's plans
                        while($query->fetch()){
                            print "<option value='$planId'>$planName</option>";
                        }
                        $query->close();
                        $db->close();
                    ?>
                </select>
            </div>
            <div class="col-1">
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="align-right"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3">
                <div class="section padding">
                    <div class="row">
                        <div class="col-12 no-padding">
                            <h3>Courses</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div id="accordion">
                            <!-- Accordion populates here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9" id="plan">
                <!-- Plan populates here -->
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="row">
                    <!-- Lower left -->
                    <div id="calculator">
                        <label for="calc_equation">Equation:</label>
                        <br>
                        <input type="text" id="calc_equation">
                        <br>
                        <label for="calc_result">Result:</label>
                        <br>
                        <input type="text" id="calc_result" readonly>
                        <br>
                        <input type="button" id="calc_submit" value="Calculate" onclick="calculate();">

			<script>
			function calculate(){
			   var string = document.getElementById("calc_equation").value;
			   document.getElementById("calc_result").value = eval(string)
			}
			</script>
                    </div>
                </div>
                <div class="row">
                    <a href="../cs3220.html">
                        <div class="col-6 centered section">
                            <h3>Evan's Course Page</h3>
                        </div>
                    </a>
                    <a href="http://judah.cedarville.edu/index.php">
                        <div class="col-6 centered section">
                            <h3>Main Course Page</h3>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-9">
                <table id="catalog" class="display compact">
                </table>
            </div>
        </div>
    </body>
</html>
