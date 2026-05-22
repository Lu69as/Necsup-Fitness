<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once(dirname(__DIR__, 2) . '/necsup-api/base.php');
        getBasicHeadFeatures("..", "Necsup Fitness");
    ?>
</head>
<body id="workouts">
    <nav class="oneDeepMenu tabs">
        <button page="new" class="activePageTab">New workout</button>
        <button page="plans">Plans</button>
        <button page="history">History</button>
    </nav>
    <?php
        $loginValid = isCurrentLoginValid();
        if (!$loginValid) {
            redirectWithParam("../../necsup-id", "loginRedirectApp", "necsup-fitness");
        }

        $userWorkoutsResult = getDatabaseRow(
            "SELECT
                w.workoutId,
                w.name,
                w.icon,
                IFNULL(w.notes, 'No notes') as notes,
                w.dateTime,
                IFNULL((
                    SELECT concat(e.name, ': ', wes.reps, ' - ', wes.weight, ' Kg')
                    FROM fitness_workout_exercise_sets wes
                    LEFT JOIN fitness_workout_exercises we on we.workoutExerciseId = wes.workoutExerciseId
                    LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
                    WHERE we.workoutId = w.workoutId
                    LIMIT 1
                ), 'Nothing logged yet') AS 'first'
            FROM fitness_workouts w
            WHERE userId = ?",
            "s", [
                $loginValid
            ]
        );

        ?>
            <a class="btn1" href="./?workoutIdSelected=0">
                Create new workout
                <span>+</span>
            </a>
        <?php

        if ($userWorkoutsResult->num_rows < 1) {
            ?>
                <h4>You haven't logged any workouts yet, create your first above!</h4>
            <?php
        }
        else {
            echo "<div class='workouts'>";
            while($row = $userWorkoutsResult->fetch_assoc()) {
                $workoutDate = date_create($row['dateTime']);
                $workoutDateFormated = date_format($workoutDate, "d. M Y h:m");
                ?>
                <a href="./?workoutIdSelected=<?= $row['workoutId'] ?>" class="workout">
                    <h3 class="title">
                        <img src="<?= $row['icon'] ?>" alt="Workout icon">
                        <?= $row['name'] ?>
                    </h3>
                    <p class="notesAndDate">
                        <?= "<b>$workoutDateFormated</b> - " . $row['notes'] ?>
                    </p>
                    <p class="firstSet">
                        <b>First set:</b>
                        <?= $row['first'] ?>
                    </p>
                </a>
                <?php
            }
            echo "</div>";
        }

        // else if ($_GET["workoutIdSelected"] !== 0) {
        //     ?>
        //         <nav class="insidePageNav">
        //             <a href="./" class="close"></a>
        //             <h1>Create workout</h1>
        //             <button>Save</button>
        //         </nav>
        //     <?php


        //     $workoutResult = getDatabaseRow(
        //         "SELECT
        //             userId,
        //             name,
        //             icon,
        //             notes
        //             dateTime
        //         FROM fitness_workouts
        //         WHERE workoutId = ?",
        //         "s", [
        //             $_GET["workoutIdSelected"]
        //         ]
        //     );

        //     if ($workoutResult->num_rows > 0) {
        //         $workoutRow = $workoutResult->fetch_assoc();

        //         $workoutSetsResult = getDatabaseRow(
        //             "SELECT
        //                 wes.workoutExerciseSetId,
        //                 wes.isLogged,
        //                 wes.notes,
        //                 wes.reps,
        //                 wes.weight,
        //                 wes.weightUnit,
        //                 e.name,
        //                 e.icon,
        //                 e.description
        //             FROM fitness_workout_exercise_sets wes
        //             LEFT JOIN fitness_workout_exercises we on we.workoutExerciseId = wes.workoutExerciseId
        //             LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
        //             WHERE we.workoutId = ?",
        //             "s", [
        //                 $_GET["workoutIdSelected"]
        //             ]
        //         );

        //         ?>
        //             <a class="btn1" href="./?workoutIdSelected=0">
        //                 Create new workout
        //                 <span>+</span>
        //             </a>
        //         <?php

        //         if ($userWorkoutsResult->num_rows < 1) {
        //             ?>
        //                 <h4>You haven't logged any workouts yet, create your first above!</h4>
        //             <?php
        //         }
        //         else {
        //             echo "<div class='workouts'>";
        //             while($row = $userWorkoutsResult->fetch_assoc()) {
        //                 $workoutDate = date_create($row['dateTime']);
        //                 $workoutDateFormated = date_format($workoutDate, "d. M Y h:m");
        //                 ?>
        //                 <a href="./?workoutIdSelected=<?= $row['workoutId'] ?>" class="workout">
        //                     <h3 class="title">
        //                         <img src="<?= $row['icon'] ?>" alt="Workout icon">
        //                         <?= $row['name'] ?>
        //                     </h3>
        //                     <p class="notesAndDate">
        //                         <?= "<b>$workoutDateFormated</b> - " . $row['notes'] ?>
        //                     </p>
        //                     <p class="firstSet">
        //                         <b>First set:</b>
        //                         <?= $row['first'] ?>
        //                     </p>
        //                 </a>
        //                 <?php
        //             }
        //             echo "</div>";
        //         }
        //     }
        //     else {

        //     }


            
        // }
    ?>
    <script src="./script.js"></script>
</body>
</html>