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
            resize: vertical; /* allow only vertical stretch */
        }
    </style>
</head>

<body>

<div class="container">
    <div class="page-header">
        <h2> Send a new note </h2>
    </div>
    <form role="form" action="/insert" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Title" name="title" required>
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" placeholder="What do you have in mind ?" name="content" autofocus
                      required></textarea>
        </div>
        <div class="btn-group pull-right">
            <button class="btn btn-danger" type="reset">
                <span class="glyphicon glyphicon-remove"></span> Clear
            </button>
            <button class="btn btn-success" name="new" type="submit">
                <span class="glyphicon glyphicon-send"></span> Send
            </button>
        </div>
    </form>
</div>

<?php if (!empty($args['notes'])): ?>
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
                <?php foreach ($args['notes'] as $note): ?>
                    <tr>
                        <td>
                            <small><?= $note->getTitle(); ?></small>
                        </td>
                        <td><?= $note->getCreated()->format('H:i'); ?></td>
                        <td><?= $note->getCreated()->format('d/m/Y'); ?></td>
                        <td class="pull-right">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" title="Edit this note" href="#" data-toggle="modal"
                                   data-target="#<?= $note->getId(); ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a class="btn btn-danger btn-xs" title="Delete this note" href="/delete?id=<?= $note->getId(); ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                <a class="btn btn-info btn-xs" title="Download this note" href="/export?id=<?= $note->getId(); ?>"
                                   target="_blank">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="<?= $note->getId(); ?>" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit note</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="/update" method="POST">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Title" name="title"
                                                   value="<?= $note->getTitle(true); ?>">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control"
                                                      rows="5"
                                                      placeholder="What do you have in mind ?"
                                                      name="content"
                                                      required><?= $note->getContent(); ?></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="<?= $note->getId(); ?>">
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-success" name="edit" type="submit">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Save
                                        </button>
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
    </div>
<?php endif; ?>

</body>

</html>
