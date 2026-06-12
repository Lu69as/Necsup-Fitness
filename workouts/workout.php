<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once(dirname(__DIR__, 2) . '/necsup-api/base.php');
        getBasicHeadFeatures("..", "Necsup Fitness");
    ?>
</head>
<body id="workouts">
    <nav class="topPageMenu">
        <button page="new" class="activePageTab">New workout</button>
        <button page="plans">Plans</button>
        <button page="history">History</button>
    </nav>
    <?php
        if (
            isset($_GET["action"])
            && $_GET["action"] == "view"
            && isset($_GET["workoutId"])
        ) {
            
        }
        if (isset($_GET["action"]) && $_GET["action"] == "new") {
            if (isset($_GET["copyPlan"])) {

            }
            else if (isset($_GET["copyWorkout"])) {
                
            }
        }

    ?>
    <script src="./script.js"></script>
</body>
</html>