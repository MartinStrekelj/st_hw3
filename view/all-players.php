<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organiziraj tekmovanje</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
    <?php include_once("navbar.php") ?>
    <div class="columns" style="margin-top:20px;">
        <div class="column is-3 is-mobile">
        <?php include_once("sidemenu.php") ?>
        </div>
        <div class="column">
            <div class="columns is-centered">
                <div class="column is-10">
                <?php if (!empty($updateMessage)): ?>
                <div class="notification is-warning">
                    <button class="delete"></button>
                    <?= $updateMessage ?>
                </div>
            <?php endif; ?>
            <div class="control has-icons-left">
                <input class="input is-medium" type="text" placeholder="Išči igralca" id="search-field">
                <span class="icon is-small is-left">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <hr>
                <table class="table is-fullwidth" id = "user-table">
                    <thead>
                        <tr>
                        <th>Igralec</th>
                        <th><abbr title="Znanje ob prijavi">Predznanje</abbr></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($players as $player): ?>
                            <tr>
                                <td><a href="<?= BASE_URL . "players?id=" . $player["PID"] ?>"><?= $player["USERNAME"]?></a></td>
                                <td><?php if ($player["PREDZNANJE"] == 1){
                                            echo "Začetnik";
                                        }
                                        elseif ($player["PREDZNANJE"] == 2){
                                            echo "Izkušen igralec";
                                        }
                                        else{
                                            echo "Veteran";
                                        }
                                        ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script> 
        const selected = document.getElementById("all_players")
        if (selected != undefined){
            selected.classList.add("is-active");
        }

        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                $notification = $delete.parentNode;

                $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
                });
            });
            });

            $(document).ready(function(){
                $("#search-field").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#user-table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
                });
        
    </script>
</body>
</html>