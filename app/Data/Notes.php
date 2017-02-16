<?php

namespace Data;

use Config\Database;
use PDO;

/**
 * Class Notes
 *
 * @package Data
 */
class Notes
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * Notes constructor.
     */
    function __construct()
    {
        $this->connection = (new Database())->createConnection();
    }

    /**
     * Returns all notes
     *
     * @return array
     */
    public function fetchNotes() {
        $stmt = $this->connection->prepare('
            SELECT id, title, content, created_at FROM notes
        ');

        $stmt->execute();

        $rawNotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $notes    = [];

        foreach ($rawNotes as $key => $note) {
            $notes[$key] = new Note($note);
        }

        return $notes;
    }

    /**
     * Returns the notes
     *
     * @param $id
     * @return Note
     */
    public function fetchOneNote($id)
    {
        $stmt   = $this->connection->prepare('
            SELECT id, title, content, created_at 
            FROM notes
            WHERE id = :id
            ORDER BY created_at DESC
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $rawResult = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $result    = new Note($rawResult);

        return $result;
    }

    /**
     * Creates a note from the provided data
     *
     * @param $title
     * @param $content
     */
    public function create($title, $content)
    {
        $datetime = date("Y-m-d H:i:s");
        $stmt     = $this->connection->prepare('
            INSERT INTO notes (title, content, created_at) 
            VALUES (:title, :content, :created_at)
        ');

        $stmt->bindParam(':title', trim($title));
        $stmt->bindParam(':content', trim($content));
        $stmt->bindParam(':created_at', $datetime);
        $stmt->execute();
    }

    /**
     * Flushes the table of all data and resets index
     */
    public function flush()
    {
        $this->connection->exec('
             DELETE FROM notes; VACUUM;
        ');
    }

    /**
     * Deletes the selected note from the table
     *
     * @param $id
     */
    public function delete($id)
    {
        $stmt = $this->connection->prepare('
            DELETE FROM notes WHERE id = :id
        ');

        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    /**
     * Updates a note when called with the new information
     *
     * @param $id
     * @param $title
     * @param $content
     */
    public function edit($id, $title, $content)
    {
        $stmt = $this->connection->prepare('
            UPDATE notes SET title = :title, content = :content 
            WHERE id = :id
        ');

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', trim($title));
        $stmt->bindParam(':content', trim($content));
        $stmt->execute();
    }

    /**
     * Exports a note by id
     *
     * @param $id
     */
    public function export($id)
    {
        $note   = $this->fetchOneNote($id);
        $fileName = 'note-' . strtolower($note->getTitle()) . '.csv';
        $fileName = str_replace(' ', '-', $fileName);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName);

        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'title',
            'content',
        ]);

        fputcsv($handle, [
            $note->getTitle(),
            $note->getContent(),
        ]);
    }
}