<?php

namespace Data;

use DateTime;

/**
 * Class Note
 *
 * @package Data
 */
class Note
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $content;

    /**
     * @var
     */
    private $created_at;

    /**
     * Note constructor.
     *
     * @param $row
     */
    function __construct($row)
    {
        $this->id         = $row['id'];
        $this->title      = $row['title'];
        $this->content    = $row['content'];
        $this->created_at = new DateTime($row['created_at']);
    }

    /**
     * Returns the id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the title
     *
     * @param bool $full
     * @return string
     */
    public function getTitle(bool $full = false)
    {
        if ($full) {
            return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        }

        return htmlspecialchars(substr($this->title, 0, 15), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Returns the content
     *
     * @return string
     */
    public function getContent()
    {
        return htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Returns the created at
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created_at;
    }
}