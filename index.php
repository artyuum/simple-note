<?php

// Core (class)
class Notes {
    
    private $pdo;

    const dbFile = 'db.sqlite';

    function __construct() {
        $this->pdo = new PDO('sqlite:'.self::dbFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS notes (
        ID      INTEGER PRIMARY KEY AUTOINCREMENT,
        title   TEXT NOT NULL,
        content TEXT NOT NULL,
        created DATETIME NOT NULL
        );');
    }

    public function fetchNotes($id = null) {
        if ($id != null) {
            $stmt = $this->pdo->prepare('SELECT title,content FROM notes WHERE id = :ID');
            $stmt->bindParam(':ID', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $title = $row['title'];
                header("Content-type: text/plain; charset=utf-8");
                header("Content-Disposition: attachment; filename=$title.txt");
                echo $row['content'];
                return;
            }
        } else {
            $stmt = $this->pdo->query('SELECT * FROM notes ORDER BY created DESC');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function create($title, $content) {
        $datetime = date("Y-m-d H:i:s");
        $stmt = $this->pdo->prepare('INSERT INTO notes (title, content, created) VALUES (:title, :content, :created)');
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':created', $datetime);
        $stmt->execute();
    }

    public function delete($id) {
        if ($id == 'all') {
            $stmt = $this->pdo->query('DELETE FROM notes; VACUUM');
        } else {
            $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :ID');
            $stmt->bindParam(':ID', $id);
            $stmt->execute();
        }
    }

    public function edit($id, $title, $content) {
        $stmt = $this->pdo->prepare('UPDATE notes SET title = :title, content = :content WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }
}

// Init core (class)
$notes = new Notes;

// Actions
if (isset($_POST['new'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $notes->create($title, $content);
}
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $notes->edit($id, $title, $content);
}
if (!empty($_GET['del'])) {
    $id = $_GET['del'];
    $notes->delete($id);
}
if (!empty($_GET['dl'])) {
    $id = $_GET['dl'];
    $notes->fetchNotes($id);
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Simple Note </title>

    <link rel="stylesheet" href="//bootswatch.com/flatly/bootstrap.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <style>
        .container {
            max-width: 680px;
        }
        
        textarea {                
            resize:vertical;    /* allow only vertical stretch   */
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="page-header">
            <h2> Send a new note </h2>
        </div>

        <form role="form" action="index.php" method="POST">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Title" name="title" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="What do you have in mind ?" name="content" autofocus required></textarea>
            </div>
            <div class="btn-group pull-right">
                <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-remove"></span> Clear </button>
                <button class="btn btn-success" name="new" type="submit"><span class="glyphicon glyphicon-send"></span> Send </button>
            </div>
        </form>
    </div>

    <?php
    if (!empty($notes->fetchNotes())):
        $notes = $notes->fetchNotes();
    ?>

    <div class="container" id="notes">
        <div class="page-header">
            <h2> Previously sent </h2>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Date</th>
                            <th class="pull-right">Actions<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
<?php foreach ($notes as $row): ?>
                            <td>
                                <small><?= htmlspecialchars(substr($row['title'], 0, 15), ENT_QUOTES, 'UTF-8') ?></small>
                            </td>
                            <td><?= date('H:i', strtotime($row['created'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['created'])) ?></td>
                            <td class="pull-right">
                                <div class="btn-group">
                                    <a class="btn btn-default btn-xs" title="Edit this note" href="#" data-toggle="modal" data-target="#<?= $row['ID'] ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                    <a class="btn btn-danger btn-xs" title="Delete this note" href="?del=<?= $row['ID'] ?>"><span class="glyphicon glyphicon-trash"></span></a>
                                    <a class="btn btn-info btn-xs" title="Download this note" href="?dl=<?= $row['ID'] ?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="<?= $row['ID'] ?>" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Edit note</h4>
                                </div>
                                <div class="modal-body">
                                  <form role="form" action="index.php" method="POST">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Title" name="title" value="<?= $row['title'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="What do you have in mind ?" name="content" required><?= htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-success" name="edit" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
                                    </div>
                                </div>
                                </form>
                              </div>
                            </div>
                        </div>
<?php endforeach; ?>
                    </tbody>
            </table>
        </div>
<?php endif; ?>
    </div>

</body>

</html>
