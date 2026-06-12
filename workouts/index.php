<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once(dirname(__DIR__, 2) . '/necsup-api/base.php');
        getBasicHeadFeatures("..", "Necsup Fitness");

        $loginValid = isCurrentLoginValid();
        if (!$loginValid) {
            redirectWithParam("../../necsup-id", "loginRedirectApp", "necsup-fitness");
        }
    ?>
</head>
<body id="workouts">
    <nav class="topNav">
        <button page="createNew" class="activePageTab">New workout</button>
        <button page="plans">Plans</button>
        <button page="history">History</button>
    </nav>
    <div class="topNav_tabs_container">
        <div class='topNav_tab  topNav_tab_createNew'>
            <a href="./workout.php?action=new" class="create_empty_btn">
                <i class="fa-solid fa-circle-play"></i>
                <div>
                    <h4>Log new workout</h4>
                    <p>Log empty workout without a plan.</p>
                </div>
            </a>
            <h3>Use saved plans</h3>
            <div class="scrolling_singleRow_grid new_workout_grid">
                <?php
                    $userPlansResult = getDatabaseRow(
                        "SELECT
                            wp.workoutPlanId,
                            wp.name,
                            IFNULL(wp.notes, 'No notes') as notes,
    
                            IFNULL((
                                SELECT e.icon
                                FROM fitness_workout_plan_exercises wpe
                                LEFT JOIN fitness_exercises e on e.exerciseId = wpe.exerciseId
                                WHERE wpe.workoutPlanId = wp.workoutPlanId
                                LIMIT 1
                            ), 'fa-icon§iconType§fa-solid fa-dumbbell') AS 'firstIcon',
    
                            IFNULL((
                                SELECT group_concat(' <span>', e.name, '</span>')
                                FROM fitness_workout_plan_exercises wpe
                                LEFT JOIN fitness_exercises e on e.exerciseId = wpe.exerciseId
                                WHERE wpe.workoutPlanId = wp.workoutPlanId
                                LIMIT 1
                            ), 'Empty plan') AS 'exerciseList'
                        FROM fitness_workout_plans wp
                        WHERE wp.userId = ?",
                        "s", [
                            $loginValid
                        ]
                    );
                    
                    while ($userPlansResult->num_rows > 0 && $row = $userPlansResult->fetch_assoc()) {
                        ?>
                            <a href="./workout.php?action=new&workoutPlan=<?= $row["workoutPlanId"] ?>" class="new_workout">
                                <div class="iconContainer"><?= findIconEl($row["firstIcon"]) ?></div>
                                <div>
                                    <h4><?= $row["name"] ?></h4>
                                    <p class="exerciseList"><?= $row["exerciseList"] ?></p>
                                </div>
                            </a>
                        <?php
                    }
                ?>
                <a href="./plan.php?action=new" class="new_workout">
                    <div class="iconContainer"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <h4>Create new plan</h4>
                        <p class="exerciseList">Create new empty plan to use for future workouts.</p>
                    </div>
                </a>
            </div>
            <h3>Copy previous workouts</h3>
            <div class="scrolling_singleRow_grid new_workout_grid">
                <?php
                    $userPlansResult = getDatabaseRow(
                        "SELECT
                            w.workoutId,
                            w.dateTime,
    
                            IFNULL((
                                SELECT e.icon
                                FROM fitness_workout_exercises we
                                LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
                                WHERE we.workoutId = w.workoutId
                                LIMIT 1
                            ), 'fa-icon§iconType§fa-solid fa-dumbbell') AS 'firstIcon',
    
                            IFNULL((
                                SELECT group_concat(' <span>', e.name, '</span>')
                                FROM fitness_workout_exercises we
                                LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
                                WHERE we.workoutId = w.workoutId
                                LIMIT 1
                            ), 'Empty plan') AS 'exerciseList'
                        FROM fitness_workouts w
                        WHERE w.userId = ?",
                        "s", [
                            $loginValid
                        ]
                    );
                    
                    while ($userPlansResult->num_rows > 0 && $row = $userPlansResult->fetch_assoc()) {
                        ?>
                            <a href="./workout.php?action=new&workoutCopy=<?= $row["workoutId"] ?>" class="new_workout">
                                <div class="iconContainer"><?= findIconEl($row["firstIcon"]) ?></div>
                                <div>
                                    <h4><?= $row["dateTime"] ?></h4>
                                    <p class="exerciseList"><?= $row["exerciseList"] ?></p>
                                </div>
                            </a>
                        <?php
                    }
                ?>
                <a href="./workout.php?action=new" class="new_workout">
                    <div class="iconContainer"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <h4>Log new workout</h4>
                        <p class="exerciseList">Log empty workout without a plan.</p>
                    </div>
                </a>
            </div>
        </div>
        <div class='topNav_tab topNav_tab_active topNav_tab_plans'>
            <a href="./workout.php?action=new" class="create_empty_btn">
                <i class="fa-solid fa-circle-play"></i>
                <div>
                    <h4>Create new plan</h4>
                    <p>Create new empty plan to use for future workouts.</p>
                </div>
            </a>
            <h3>Use saved plans</h3>
            <div class="workout_historyOrPlans_grid">
                <?php
                    $userPlansResult = getDatabaseRow(
                        "SELECT
                            wp.workoutPlanId,
                            wp.name,
                            IFNULL(wp.notes, 'No notes') as notes,
    
                            IFNULL((
                                SELECT e.icon
                                FROM fitness_workout_plan_exercises wpe
                                LEFT JOIN fitness_exercises e on e.exerciseId = wpe.exerciseId
                                WHERE wpe.workoutPlanId = wp.workoutPlanId
                                LIMIT 1
                            ), 'fa-icon§iconType§fa-solid fa-dumbbell') AS 'firstIcon',
    
                            IFNULL((
                                SELECT group_concat(' <span>', e.name, '</span>')
                                FROM fitness_workout_plan_exercises wpe
                                LEFT JOIN fitness_exercises e on e.exerciseId = wpe.exerciseId
                                WHERE wpe.workoutPlanId = wp.workoutPlanId
                                LIMIT 1
                            ), 'Empty plan') AS 'exerciseList'
                        FROM fitness_workout_plans wp
                        WHERE wp.userId = ?",
                        "s", [
                            $loginValid
                        ]
                    );
                    
                    while ($userPlansResult->num_rows > 0 && $row = $userPlansResult->fetch_assoc()) {
                        ?>
                            <a href="./plan.php?&workoutPlanId=<?= $row["workoutPlanId"] ?>" class="flexBox_item">
                                <div class="iconContainer"><?= findIconEl($row["firstIcon"]) ?></div>
                                <div>
                                    <h4><?= $row["name"] ?></h4>
                                    <p class="exerciseList"><?= $row["exerciseList"] ?></p>
                                </div>
                            </a>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class='topNav_tab  topNav_tab_history'>
            <h3>View previous workouts</h3>
            <div class="workout_historyOrPlans_grid">
                <?php
                    $userPlansResult = getDatabaseRow(
                        "SELECT
                            w.workoutId,
                            w.dateTime,
    
                            IFNULL((
                                SELECT e.icon
                                FROM fitness_workout_exercises we
                                LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
                                WHERE we.workoutId = w.workoutId
                                LIMIT 1
                            ), 'fa-icon§iconType§fa-solid fa-dumbbell') AS 'firstIcon',
    
                            IFNULL((
                                SELECT group_concat(' <span>', e.name, '</span>')
                                FROM fitness_workout_exercises we
                                LEFT JOIN fitness_exercises e on e.exerciseId = we.exerciseId
                                WHERE we.workoutId = w.workoutId
                                LIMIT 1
                            ), 'Empty plan') AS 'exerciseList'
                        FROM fitness_workouts w
                        WHERE w.userId = ?",
                        "s", [
                            $loginValid
                        ]
                    );
                    
                    while ($userPlansResult->num_rows > 0 && $row = $userPlansResult->fetch_assoc()) {
                        ?>
                            <a href="./workout.php?action=view&workoutId=<?= $row["workoutId"] ?>" class="flexBox_item">
                                <div class="iconContainer"><?= findIconEl($row["firstIcon"]) ?></div>
                                <div>
                                    <h4><?= $row["dateTime"] ?></h4>
                                    <p class="exerciseList"><?= $row["exerciseList"] ?></p>
                                </div>
                            </a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="../script.js"></script>
</body>
</html>