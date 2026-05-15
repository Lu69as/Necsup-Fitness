<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once(dirname(__DIR__, 2) . '/necsup-api/base.php');
        getBasicHeadFeatures("..", "Necsup Fitness");
    ?>
</head>
<body id="workouts"><?php    
    $loginValid = isCurrentLoginValid();
    echo $loginValid;
    // echo dirname(__DIR__, 2) . '/necsup-id';

    if (!$loginValid) {
        // redirectWithParam('../../necsup-id', "notLoggedIn", 1);
    }

    else if (empty($_GET("workoutIdSelected"))) {
        $userWorkoutsResult = getDatabaseRow(
            "SELECT
                workoutId,
                name,
                icon,
                notes,
                dateTime
            FROM fitness_workouts
            WHERE userId = ?",
            "s", [
                $loginValid
            ]
        );

        ?>
            <!-- <a class="btn1" href="./?workoutIdSelected=0">
                Create new workout
                <span>+</span>
            </a> -->
        <?php

        if ($userWorkoutsResult->num_rows < 1) { ?>
            <h4>You haven't logged any workouts yet, create your first above!</h4>
        <?php } 
    }

    else {

    } ?>

    <script src="./script.js"></script>
</body>
</html>