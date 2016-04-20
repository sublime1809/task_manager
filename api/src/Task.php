<?php

/**
 * @Entity @Table(name="tasks")
 **/
class Task implements JsonSerializable
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="datetime", options={"default": 0})
     */
    protected $created_at;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $completed_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getCompletedAt()
    {
        return $this->completed_at;
    }

    /**
     * @param mixed $completed_at
     */
    public function setCompletedAt($completed_at)
    {
        if (is_int($completed_at)) {
            $date = new \DateTime();
            $completed_at = $date->setTimestamp($completed_at);
        }
        $this->completed_at = $completed_at;
    }
    
    public function __toString()
    {
        return (string) $this->name;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'completed_at' => $this->getCompletedAt(),
            'is_completed' => isset($this->completed_at));
    }
}