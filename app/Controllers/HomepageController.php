<?php

namespace Controllers;

use Data\Notes;

/**
 * Class HomepageController
 *
 * @package Controllers
 */
class HomepageController extends Controller
{
    /**
     * @var Notes
     */
    private $notes;

    /**
     * HomepageController constructor.
     */
    function __construct()
    {
        $this->notes = new Notes();
    }

    /**
     * Displays the homepage view
     *
     * @param null $get
     * @return string
     */
    public function index($get = null)
    {
        $notes = $this->notes->fetchNotes();

        return $this->renderer()->renderView('Homepage', [
            'notes' => $notes,
            'test'  => 'test'
        ]);
    }

    /**
     * Inserts the post into the database
     *
     * @param $post
     */
    public function insert($post)
    {
        $this->notes->create($post['title'], $post['content']);

        return $this->redirect('/');
    }

    /**
     * Updates the selected note.
     *
     * @param $post
     */
    public function update($post)
    {
        $this->notes->edit($post['id'], $post['title'], $post['content']);

        return $this->redirect('/');
    }

    /**
     * Exports the selected note.
     *
     * @param null $get
     */
    public function export($get = null)
    {
        if (!is_null($get)) {
            $this->notes->export($get['id']);
        }
    }

    /**
     * Exports the selected note.
     *
     * @param null $get
     */
    public function delete($get = null)
    {
        if (!is_null($get)) {
            $this->notes->delete($get['id']);
        }

        return $this->redirect('/');
    }
}